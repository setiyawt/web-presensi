<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qrcode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'classroom_id',
        'lesson_time',
        'qr_code_path',
    ];


    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function attendance(){
        return $this->belongsTo(Attendance::class, 'qrcode_id');
    }
}
