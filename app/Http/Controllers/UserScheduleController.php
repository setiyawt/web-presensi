<?php

namespace App\Http\Controllers;
use App\Models\UserSchedule;
use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Http\Request;

class UserScheduleController extends Controller
{
    public function index()
    {
        $schedules = UserSchedule::with('course', 'classroom', 'user')->get();
        return view('admin.schedule.index', compact('schedules'));
    }

    public function create(){
        $courses = Course::all();
        $classrooms = Classroom::all();
        

        return view('admin.schedule.create', compact('courses', 'classrooms'));
        
    }
}
