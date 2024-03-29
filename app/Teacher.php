<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /**
     * Get the student for the student.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
