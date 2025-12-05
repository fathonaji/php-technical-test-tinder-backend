<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function target()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
