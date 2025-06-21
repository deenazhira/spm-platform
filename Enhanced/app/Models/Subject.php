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
    ];

<<<<<<< HEAD:app/Models/Subject.php
    // Define relationships if needed
=======
    /**
     * Get the topics related to this subject.
     */
>>>>>>> 1ba4bb801dd819045c4f9ebe4a53f7a7a07a64fa:Enhanced/app/Models/Subject.php
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}

