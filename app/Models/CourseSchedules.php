<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSchedules extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'course_id',
        'classroom_id',
    ];

    public function course(){
        return $this->belongsTo(Course::class, 'courses_id');
    }

    public function attendance(){
        return $this->belongsTo(Attendance::class, 'course_schedules_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    
}
