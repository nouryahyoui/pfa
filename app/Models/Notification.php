<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'message',
        'lu',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}