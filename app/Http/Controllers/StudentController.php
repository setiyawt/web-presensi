<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\Model\Student;
use App\Models\Attendance;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil attendance yang user-nya memiliki role student
        $attendances = Attendance::whereHas('user', function($query) {
            $query->role('student'); // Pastikan 'student' adalah role yang sesuai.
        })
        ->orderBy('id', 'DESC')
        ->get();
        

        return view('admin.tables_attend.table_student', [
            'attendances' => $attendances,
        ]);
        
    }

    public function scopeRole($query, $roleName)
    {
        return $query->whereHas('roles', function($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }

    public function form_student() {
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
        //
    }

    /**
     * Display the specified resource.
     */
    // public function show(student $student)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(student $student)
    // {
        
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, student $student)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(student $student)
    // {
    //     //
    // }
}
