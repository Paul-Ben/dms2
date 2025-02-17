<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoMovement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function memo()
    {
        return $this->belongsTo(Memo::class);
    }

    public function memo_recipients()
    {
        return $this->belongsToMany(User::class, 'memo_recipients', 'recipient_id', 'memo_movement_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
