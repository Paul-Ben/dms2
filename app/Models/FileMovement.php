<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMovement extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    public function document_recipients()
    {
        return $this->belongsToMany(User::class, 'document_recipients', 'recipient_id', 'file_movement_id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
}
