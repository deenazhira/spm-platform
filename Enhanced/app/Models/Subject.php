<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'code',
        'title',
        'topic_number',
        'syllabus_path',
    ];

    // Define relationships if needed
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}

