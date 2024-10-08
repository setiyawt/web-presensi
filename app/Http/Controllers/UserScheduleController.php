<?php

namespace App\Http\Controllers;

use App\Models\UserSchedule;
use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserScheduleController extends Controller
{
    public function index()
    {
        $schedules = UserSchedule::with('course', 'classroom')->get();
        $user = Auth::user();
        return view('admin.schedule.index', compact('schedules', 'user'));
    }

    

    public function create()
    {
        $courses = Course::all();
        $classrooms = Classroom::all();
        $user = Auth::user();

        return view('admin.schedule.create', compact('courses', 'classrooms', 'user'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'course_id' => 'nullable|exists:courses,id',
                'classroom_id' => 'nullable|exists:classrooms,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
            ]);

            $existingSchedule = UserSchedule::where('course_id', $data['course_id'])
            ->where('classroom_id', $data['classroom_id'])
            ->whereDate('start_time', '=', $data['start_time'])
            ->whereDate('end_time', '=', $data['end_time'])
            ->first();

            if ($existingSchedule) {
                // If a duplicate is found, return an error message
                return back()->with('error', 'Jadwal pelajaran sudah ada.');
            }

            // Simpan ke UserSchedule
            UserSchedule::create([
                'course_id' => $data['course_id'],
                'classroom_id' => $data['classroom_id'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time']
            ]);

            return redirect()->route('dashboard.schedule.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan jadwal.');
        }
    }
    
    public function edit($id)
    {
        $schedule = UserSchedule::with('course', 'classroom')->findOrFail($id);
        $courses = Course::all();
        $classrooms = Classroom::all();
        $user = Auth::user(); // Ambil data user yang sedang login

        return view('admin.schedule.edit', compact('schedule', 'courses', 'classrooms', 'user'));
    }


    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'course_id' => 'nullable|exists:courses,id',
                'classroom_id' => 'nullable|exists:classrooms,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
            ]);

            // Update jadwal
            $schedule = UserSchedule::findOrFail($id);

            

            $schedule->update($data);

            return redirect()->route('dashboard.schedule.index')->with('success', 'Jadwal pelajaran berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui jadwal.');
        }
    }



    public function destroy($id) {
        $schedule = UserSchedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('dashboard.schedule.index')->with('success', 'Jadwal pelajaran berhasil dihapus');
    }
}
