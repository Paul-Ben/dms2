<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreFileChargeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->default_role, ['superadmin', 'Admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3|in:NGN,USD,EUR,GBP',
            'file_type' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'effective_date' => 'nullable|date|after_or_equal:today',
            'expiry_date' => 'nullable|date|after:effective_date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Charge name is required.',
            'name.max' => 'Charge name cannot exceed 255 characters.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount cannot be negative.',
            'currency.required' => 'Currency is required.',
            'currency.in' => 'Currency must be one of: NGN, USD, EUR, GBP.',
            'file_type.max' => 'File type cannot exceed 100 characters.',
            'is_active.boolean' => 'Active status must be true or false.',
            'effective_date.date' => 'Effective date must be a valid date.',
            'effective_date.after_or_equal' => 'Effective date cannot be in the past.',
            'expiry_date.date' => 'Expiry date must be a valid date.',
            'expiry_date.after' => 'Expiry date must be after the effective date.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}