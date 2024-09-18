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
        $user = Auth::user();
        $schedules = EachSchedule::with(['userSchedule.course', 'userSchedule.classroom'])
        ->get();

        return view('admin.each_schedule.index', compact('schedules', 'user'));
    }

    public function create()
        {
            // Ambil semua pengguna
            $user = Auth::user();
            $users = User::select('id', 'email')->get(); 

            $schedules = UserSchedule::with(['course', 'classroom'])
            ->select('id', 'course_id', 'classroom_id', 'start_time', 'end_time')
            ->get()
            ->map(function($schedule) {
                $schedule->start_time_formatted = \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d H:i');
                $schedule->end_time_formatted = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                return $schedule;
        });


        return view('admin.each_schedule.create', compact('users', 'schedules', 'user'));
    }



    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_schedule_id' => 'required|exists:user_schedules,id',
        ]);
        $existingSchedule = EachSchedule::where('user_id', $validatedData['user_id'])
        ->where('user_schedule_id', $validatedData['user_schedule_id'])
        ->first();

        if ($existingSchedule) {
            // If a duplicate entry is found, return an error message
            return back()->with('error', 'Jadwal sudah ada untuk pengguna');
        }
        // Simpan ke tabel each_schedule
        EachSchedule::create([
            'user_id' => $request->user_id,
            'user_schedule_id' => $request->user_schedule_id,
        ]);

        return redirect()->route('dashboard.each_schedule.index')->with('success', 'Schedule created successfully!');
    }

    public function edit($id)
{
    // Ambil pengguna yang sedang login
    $user = Auth::user();

    // Ambil semua pengguna untuk dropdown (pilihan untuk user_id)
    $users = User::select('id', 'email')->get();

    // Ambil jadwal yang akan diedit berdasarkan ID
    $eachSchedule = EachSchedule::with(['userSchedule.course', 'userSchedule.classroom'])
        ->findOrFail($id);

    // Ambil semua jadwal yang tersedia untuk dropdown
    $schedules = UserSchedule::with(['course', 'classroom'])
        ->select('id', 'course_id', 'classroom_id', 'start_time', 'end_time')
        ->get()
        ->map(function($schedule) {
            $schedule->start_time_formatted = \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d H:i');
            $schedule->end_time_formatted = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
            return $schedule;
        });

    return view('admin.each_schedule.edit', compact('users', 'schedules', 'user', 'eachSchedule'));
}




public function update(Request $request, $id)
{
    // Validasi input dari form
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'user_schedule_id' => 'required|exists:user_schedules,id',
    ]);

    // Temukan jadwal yang ingin diperbarui berdasarkan ID
    $eachSchedule = EachSchedule::findOrFail($id);

    // Perbarui data jadwal dengan data dari request
    $eachSchedule->update([
        'user_id' => $validatedData['user_id'],
        'user_schedule_id' => $validatedData['user_schedule_id'],
    ]);

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('dashboard.each_schedule.index')->with('success', 'Schedule updated successfully!');
}


    public function destroy($id)
    {
        // Temukan jadwal yang ingin dihapus berdasarkan ID
        $eachSchedule = EachSchedule::findOrFail($id);

        // Hapus jadwal
        $eachSchedule->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('dashboard.each_schedule.index')->with('success', 'Schedule deleted successfully!');
    }










}