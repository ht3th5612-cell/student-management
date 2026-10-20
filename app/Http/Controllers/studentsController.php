<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses; 
use App\Models\LaravelStudent; // Model နာမည်မှန် (PascalCase & Singular) ဖြင့် အသုံးပြုပါ
use Illuminate\Validation\Rule;

class studentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = LaravelStudent::orderBy('id', 'desc')->paginate(10);
        
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
            'gender'       => 'required|in:Male,Female', 
            'course_id'    => ["required", "integer", Rule::exists("courses", "id")],
        ]);

        LaravelStudent::create($data);

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
        $student = LaravelStudent::findOrFail($id); 
        
        $courses = Courses::all();
        
        return view('students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = LaravelStudent::findOrFail($id);

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
        $student = LaravelStudent::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function exportCSV()
    {
        $filename = 'students.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () {
            $out = fopen('php://output', 'w');
            
            // CSV Header ထည့်ခြင်း
            fputcsv($out, ['ID', 'Student Code', 'Name', 'Email', 'Phone', 'Gender', 'Course_ID']);

            LaravelStudent::orderBy('id')->chunk(500, function ($students) use ($out) {
                foreach ($students as $student) {
                    fputcsv($out, [
                        $student->id,
                        $student->student_code,
                        $student->name,
                        $student->email,
                        $student->phone,
                        $student->gender,
                        $student->course_id
                    ]);
                }
            });

            fclose($out);
        }, 200, $headers);
    }
    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // CSV Header ကို ဖယ်ရှားခြင်း
        $header = array_shift($data);

        foreach ($data as $row) {
            if (count($row) === count($header)) {
                $studentData = array_combine($header, $row);
                LaravelStudent::updateOrCreate(
                    ['student_code' => $studentData['student_code']],
                    [
                        'name'      => $studentData['name'],
                        'email'     => $studentData['email'],
                        'phone'     => $studentData['phone'],
                        'gender'    => $studentData['gender'],
                        'course_id' => $studentData['course_id'],
                    ]
                );
            }
        }

        return redirect()->route('students.index')->with('success', 'CSV imported successfully.');
    }
}