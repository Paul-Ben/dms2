<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Folder extends Model
{
    protected $fillable = [
        'name',
        'description',
        'tenant_id',
        'created_by',
        'parent_id',
        'is_private'
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(FolderPermission::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'folder_permissions')
            ->withPivot('permission')
            ->withTimestamps();
    }
} 