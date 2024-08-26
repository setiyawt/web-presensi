<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['qr_code_id', 'course_schedules_id', 'user_id'];
    
    

    public function courseSchedule()
    {
        return $this->belongsTo(Course::class, 'course_schedules_id');

    }

public function user()
    {
        return $this->belongsTo(User::class);
    }

}
