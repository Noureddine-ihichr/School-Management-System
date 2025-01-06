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
}