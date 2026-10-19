<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

class coursesController extends Controller
{
    
    public function index()
    {
        $courses = Courses::all();
        $count = $courses->count();
        return view('courses.index', compact('courses', 'count'));
    }

   
    public function create()
    {
        return view('courses.create');
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => 'required|string|unique:courses,course_code',
            'course_name' => 'required|string',
            'description' => 'required|string',
            'duration_hours' => 'required|string',
            'course_fee' => 'required|string',
        ]);

        Courses::create($data);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    
    public function show($id)
    {
        $course = Courses::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    
    public function edit($id)
    {
        $course = Courses::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    
    public function update(Request $request, $id)
    {
        $course = Courses::findOrFail($id);
        
        $data = $request->validate([
            'course_code' => ['required', 'string', \Illuminate\Validation\Rule::unique('courses')->ignore($course->id)],
            'course_name' => 'required|string',
            'description' => 'required|string',
            'duration_hours' => 'required|string',
            'course_fee' => 'required|numeric',
        ]);

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    
    public function destroy($id)
    {
        $course = Courses::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}