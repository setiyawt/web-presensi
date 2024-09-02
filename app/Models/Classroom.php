<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function course(){
        return $this->belongsToMany(Course::class, 'courses', 'classroom_id');
    }

    public function schedules()
    {
        return $this->hasMany(UserSchedule::class);
    }
}
