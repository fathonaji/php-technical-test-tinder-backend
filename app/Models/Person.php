<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'photo_url',
        'location',
        'like_alert_sent_at',
    ];

    public function sentInteractions()
    {
        return $this->hasMany(Interaction::class, 'user_id');
    }

    public function receivedInteractions()
    {
        return $this->hasMany(Interaction::class, 'person_id');
    }
}
