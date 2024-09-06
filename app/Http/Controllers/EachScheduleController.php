<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EachSchedule;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\UserSchedule;
use App\Models\Classroom;
use Illuminate\Support\Facades\Log;


class EachScheduleController extends Controller
{
    public function index()
    {
        $schedules = EachSchedule::with(['userSchedule.course', 'userSchedule.classroom'])
        ->get();

        return view('admin.each_schedule.index', compact('schedules'));
    }

    public function create()
    {
        // Ambil semua pengguna
        $users = User::select('id', 'email')->get(); 

    $schedules = UserSchedule::with(['course', 'classroom'])
    ->select('id', 'course_id', 'classroom_id', 'start_time', 'end_time')
    ->get()
    ->map(function($schedule) {
        $schedule->start_time_formatted = \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d H:i');
        $schedule->end_time_formatted = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
        return $schedule;
    });


        return view('admin.each_schedule.create', compact('users', 'schedules'));
    }



    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_schedule_id' => 'required|exists:user_schedules,id',
        ]);

        // Simpan ke tabel each_schedule
        EachSchedule::create([
            'user_id' => $request->user_id,
            'user_schedule_id' => $request->user_schedule_id,
        ]);

        return redirect()->route('dashboard.each_schedule.index')->with('success', 'Schedule created successfully!');
    }












}