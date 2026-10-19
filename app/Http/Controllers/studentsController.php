<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses; 
use App\Models\laravel_students;
use Illuminate\Validation\Rule;

class studentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = laravel_students::OrderBy('id', 'desc')->paginate(10);
        $count = $students->total();
        $name = 'Ma Ma';
        
        return view('students.index', compact('students', 'count', 'name'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Courses::all(); 
        return view('students.create', compact('courses')); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_code' => 'required|string|unique:laravel_students,student_code',
            'name'         => 'required|string',
            'email'        => 'required|email|unique:laravel_students,email',
            'phone'        => 'nullable|string',
            'gender'       => 'required|in:Male,Female', // Female ပါ ထည့်ခွင့်ပေးလိုက်ပါတယ်
            'course_id'    => ["required", "integer", Rule::exists("courses", "id")],
        ]);

        laravel_students::create($data);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = laravel_students::findOrFail($id); 
        
        $courses = Courses::all();
        
        return view('students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $student = laravel_students::findOrFail($id);

        $data = $request->validate([
            'student_code' => ['required', 'string', Rule::unique('laravel_students')->ignore($student->id)],
            'name'         => 'required|string',
            'email'        => ['required', 'email', Rule::unique('laravel_students')->ignore($student->id)],
            'phone'        => 'nullable|string',
            'gender'       => 'required|in:Male,Female',
            'course_id'    => ["required", "integer", Rule::exists("courses", "id")],
        ]);

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = laravel_students::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}