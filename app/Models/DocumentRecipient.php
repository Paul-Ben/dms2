<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRecipient extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function fileMovement()
    {
        return $this->hasMany(FileMovement::class);
    }
    
}
