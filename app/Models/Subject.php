<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * Get the topics related to this subject.
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
