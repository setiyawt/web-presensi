<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     // Relasi ke Classroom
     public function classrooms()
     {
         return $this->belongsToMany(Classroom::class, 'user_id', 'classroom_id');
     }
 
     // Relasi ke Course
     public function courses()
     {
         return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
     }
     public function schedules()
     {
         return $this->hasMany(UserSchedule::class);
     }

    public function attendance(){
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function admin(){
        return $this->hasOne(Admin::class, 'user_id');
    }
}
