<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'name',
    ];

    // Change to many-to-many relationship
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'classe_teacher');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'classe_student');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classe_subject')
                    ->withPivot('teacher_id');
    }

    public function subjectsWithTeachers()
    {
        return $this->belongsToMany(Subject::class, 'classe_subject')
                    ->withPivot('teacher_id')
                    ->join('teachers', 'classe_subject.teacher_id', '=', 'teachers.id')
                    ->select('subjects.*', 'teachers.first_name', 'teachers.last_name');
    }
}