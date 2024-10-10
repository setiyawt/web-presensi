<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function classroom(){
        return $this->hasMany(Classroom::class, 'classroom', 'classroom_id');
    }

    public function schedules()
    {
        return $this->hasMany(UserSchedule::class);
    }

    public function qrcode(){
        return $this->belongsTo(Qrcode::class);
    }
}
