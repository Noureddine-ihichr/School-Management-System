<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Classe extends Model
{
   

    protected $fillable = [
        'name',
        'teacher_id',
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'classe_student');
    }
    
}