<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoRecipient extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function memo()
    {
        return $this->belongsTo(Memo::class);
    }

    public function MemoMovement()
    {
        return $this->hasMany(MemoMovement::class);
    }
   
}
