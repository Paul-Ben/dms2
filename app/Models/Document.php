<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fileMovements()
    {
        return $this->hasMany(FileMovement::class, 'document_id');
    }

    public function documentRecipients()
    {
        return $this->hasMany(DocumentRecipient::class);
    }
}
