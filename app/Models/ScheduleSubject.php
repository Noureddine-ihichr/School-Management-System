<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'day',
        'time',
        'subject',
        'teacher',
        'room'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
} 