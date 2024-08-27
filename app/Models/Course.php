<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function classroom(){
        return $this->hasMany(Classroom::class, 'classroom', 'classroom_id');
    }

    public function courseSchedules(){
        return $this->hasMany(CourseSchedules::class);
    }

    public function qrcode(){
        return $this->belongsTo(Qrcode::class, 'courses_id');
    }
}
