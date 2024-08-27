<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


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
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            Log::info('Received request data: ' . json_encode($request->all()));

            // Validate the incoming request
            $validatedData = $request->validate([
                'qr_code_id' => 'required|integer|exists:qrcodes,id',
            ]);

            // Check if an attendance record already exists for this user and QR code today
            $existingAttendance = Attendance::where('user_id', $user->id)
                ->where('qr_code_id', $validatedData['qr_code_id'])
                ->whereDate('scan_at', Carbon::today())
                ->first();

            if ($existingAttendance) {
                return response()->json(['error' => 'Attendance already recorded for today'], 422);
            }

            // Create the attendance record
            $attendance = new Attendance();
            $attendance->qr_code_id = $validatedData['qr_code_id'];
            $attendance->user_id = $user->id;
            $attendance->scan_at = Carbon::now();
            $attendance->save();

            Log::info('Attendance record created: ' . json_encode($attendance));

            return response()->json(['success' => 'Attendance recorded successfully'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in AttendanceController@store: ' . json_encode($e->errors()));
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error in AttendanceController@store: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to record attendance: ' . $e->getMessage()], 500);
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
