<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EachSchedule extends Model
{
    use HasFactory;

    protected $table = 'each_schedule'; // Pastikan nama tabel sesuai

    protected $fillable = ['user_id', 'user_schedule_id'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke UserSchedule
    public function userSchedule()
    {
        return $this->belongsTo(UserSchedule::class, 'user_schedule_id');
    }
}
