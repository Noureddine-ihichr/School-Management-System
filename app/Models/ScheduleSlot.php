<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'day',
        'start_time',
        'end_time',
        'teacher_id',
        'subject_id',
        'room'
    ];

    public function schedule()
    {
        \Log::info('Accessing schedule relationship');
        return $this->belongsTo(Schedule::class);
    }

    public function teacher()
    {
        \Log::info('Accessing teacher relationship');
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        \Log::info('Accessing subject relationship');
        return $this->belongsTo(Subject::class);
    }
} 