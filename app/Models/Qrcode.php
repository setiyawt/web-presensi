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


    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function attendance(){
        return $this->belongsTo(Attendance::class, 'qrcode_id');
    }
}
