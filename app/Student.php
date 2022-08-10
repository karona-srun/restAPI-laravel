<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * Get the post that owns the students.
     */
    public function teacher()
    {
        return $this->hasMany(Teacher::class,'id','teacher_id');
    }
}
