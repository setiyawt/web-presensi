<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Classroom;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::get();
        $user = Auth::user();
        return view('admin.course.index', compact('courses', 'user'));
        
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
        $user = Auth::user();
        return view('admin.course.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'course_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('courses', 'name')->whereNull('deleted_at') // Ignores soft-deleted records
                ],
            ]);

            $existingCourse = Course::whereRaw('LOWER(name) = ?', [strtolower($data['course_name'])])
            ->whereNull('deleted_at')
            ->first();

            if ($existingCourse) {
                return back()->with('error', 'Nama pelajaran sudah ada. Pilih nama yang berbeda.');
            }

            Course::create([
                'name' => $data['course_name'],
                'slug' => Str::slug($data['course_name'])
            ]);

            return redirect()->route('dashboard.course.index')->with('success', 'Pelajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return back()->with('error', 'Nama pelajaran sudah ada. Pilih nama yang berbeda.');
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
        $user = Auth::user();
        return view('admin.course.edit', compact('course', 'user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $course = Course::findOrFail($id);
            // Validate input
            $data = $request->validate([
                'course_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses', 'name')
                    ->ignore($course->id)
                    ->whereNull('deleted_at') // Ignores soft-deleted records
                    
            ],
            ]);

            $existingCourse = Course::whereRaw('LOWER(name) = ?', [strtolower($data['course_name'])])
            ->whereNull('deleted_at')
            ->first();

            if ($existingCourse) {
                return back()->with('error', 'Nama pelajaran sudah ada. Pilih nama yang berbeda.');
            }
            

            // Update the course with name and slug
            $course->update([
                'name' => $data['course_name'],
                'slug' => Str::slug($data['course_name'])
            ]);

            return redirect()->route('dashboard.course.index')->with('success', 'Pelajaran berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
            return back()->with('error', 'Nama pelajaran sudah ada. Pilih nama yang berbeda.');
        }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Cek apakah ada jadwal yang menggunakan course ini
        if ($course->schedules()->exists()) {
            return redirect()->route('dashboard.course.index')->with('error', 'Pelajaran tidak bisa dihapus karena masih digunakan di jadwal.');
        }

        // Jika tidak digunakan, lanjutkan penghapusan
        $course->delete();
        return redirect()->route('dashboard.course.index')->with('success', 'Pelajaran berhasil dihapus');
    }


}
