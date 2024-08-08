<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qrcode extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function course(){
        return $this->belongsTo(Course::class, 'courses_id');
    }

    public function attendance(){
        return $this->belongsTo(Attendance::class, 'qrcode_id');
    }
}
