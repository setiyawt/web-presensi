<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EachSchedule;

class EachScheduleController extends Controller
{
    public function index()
{
    $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login

    // Ambil jadwal berdasarkan ID pengguna yang sedang login
    $schedules = EachSchedule::where('user_id', $userId)
        ->with(['userSchedule.course', 'userSchedule.classroom']) // Muat relasi terkait
        ->get();

    return view('admin.each_schedule.index', compact('schedules'));
}




}