<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    /**
     * Get the subject that owns this topic.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
