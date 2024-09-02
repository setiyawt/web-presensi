<?php

namespace App\Http\Controllers;
use App\Models\UserSchedule;

use Illuminate\Http\Request;

class UserScheduleController extends Controller
{
    public function index()
    {
        $schedules = UserSchedule::with('course', 'classroom', 'user')->get();
        return view('admin.schedule.index', compact('schedules'));
    }
}
