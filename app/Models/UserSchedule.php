<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['course_id', 'classroom_id', 'start_time', 'end_time'];


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    
}
