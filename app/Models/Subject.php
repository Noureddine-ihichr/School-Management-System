<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Teacher;

class Subject extends Model
{
    protected $fillable = ['name', 'code', 'description'];

    /**
     * Get the teachers that teach this subject.
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher');
    }
}
