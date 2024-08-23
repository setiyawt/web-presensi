<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('admin.dashboard.index');
        
    }

    public function student_index()
    {
        return view('student.dashboard.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'qr_code_path' => 'required|string',
        'user_id' => 'required|integer',
        'course_schedules_id' => 'required|integer',
    ]);

    try {
        $qrCodePath = $validated['qr_code_path'];
        $userId = $validated['user_id'];
        $courseSchedulesId = $validated['course_schedules_id'];

        // Proses data

        return response()->json(['success' => 'Data received successfully']);
    } catch (\Exception $e) {
        Log::error('Error in QRCodeController@store: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred'], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        return view('admin.attendance.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
