<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function classroom(){
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
