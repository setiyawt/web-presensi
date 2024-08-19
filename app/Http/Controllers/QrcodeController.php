<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use Illuminate\Support\Facades\Log;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return('this is qrcode.com');
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.qrcode.create');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_name' => 'required|exists:courses,name',
            'lesson_time' => 'required|date',
        ]);

        // Ambil nama course dari request
        $courseName = $validatedData['course_name'];

        // Cari course berdasarkan nama
        $course = Course::where('name', $courseName)->firstOrFail();
        $courseId = $course->id;

        $lessonTime = $validatedData['lesson_time'];

        // Siapkan data QR Code
        $qrData = $courseName . ' ' . $lessonTime;
        $qrCodePath = 'qrcodes/' . uniqid() . '.png';

        // Generate QR code
        QrCode::format('png')->size(300)->generate($qrData, public_path($qrCodePath));

        // Simpan data QR Code ke tabel
        Qrcode::create([
            'course_id' => $courseId,
            'lesson_time' => $lessonTime,
            'qr_code_path' => $qrCodePath,
        ]);

        return redirect()->back()->with('success', 'QR Code generated successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Qrcode $qrcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qrcode $qrcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Qrcode $qrcode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Qrcode $qrcode)
    {
        //
    }
}
