<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function memoMovements()
    {
        return $this->hasMany(MemoMovement::class);
    }

    public function memoRecipients()
    {
        return $this->hasMany(MemoRecipient::class);
    }


}
