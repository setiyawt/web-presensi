<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Classroom;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::get();
        return view('admin.course.index', compact('courses'));
        
    }

    public function take_course()
    {
        // $courses = Course::all(); // Mengambil semua data dari tabel 'course'
        // $classrooms = Classroom::all(); // Mengambil semua data dari tabel 'classroom'
        // return view('teacher.dashboard.index', [
        //     'courses' => $courses,
        //     'classrooms' => $classrooms
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'course_name' => 'required|string|max:255',
            ]);

            Course::create([
                'name' => $data['course_name'],
                'slug' => Str::slug($data['course_name'])
            ]);

            return redirect()->route('dashboard.course.index')->with('success', 'Pelajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menambahkan pelajaran.');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    
     public function edit($id) {
        $course = Course::findOrFail($id);
        return view('admin.course.edit', compact('course'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        // Validate input
        $data = $request->validate([
            'course_name' => 'required|string|max:255',
        ]);

        // Find the course
        $course = Course::findOrFail($id);

        // Update the course with name and slug
        $course->update([
            'name' => $data['course_name'],
            'slug' => Str::slug($data['course_name'])
        ]);

        return redirect()->route('dashboard.course.index')->with('success', 'Pelajaran berhasil diperbarui');
    } catch (\Exception $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat memperbarui pelajaran.');
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('dashboard.course.index')->with('success', 'Pelajaran berhasil dihapus');
    }
}
