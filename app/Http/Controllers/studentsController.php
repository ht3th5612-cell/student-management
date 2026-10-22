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
    public function index(Request $request)
    {
        $query = LaravelStudent::with('course');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->input('course'));
        }
        if ($request->filled('gender') && in_array($request->input('gender'), ['Male', 'Female'], true)) {
            $query->where('gender', $request->input('gender'));
        }


        $students = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $count = $students->total();
        $courses = Courses::orderBy('course_name')->get();
        

        return view('students.index', compact('students', 'count', 'courses'));
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
        $students = LaravelStudent::with('course')->orderBy('id')->get();

        return response()->streamDownload(function () use ($students) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['student_code', 'name', 'email', 'phone', 'gender', 'course']);

            foreach ($students as $student) {
                fputcsv($out, [
                    $student->student_code,
                    $student->name,
                    $student->email,
                    $student->phone,
                    $student->gender,
                    $student->course?->course_name,
                ]);
            }

            fclose($out);
        }, 'students-' . now()->format('Y-m-d-His') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'extensions:csv,txt', 'max:2048'],
        ]);

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');

        if ($handle === false) {
            return back()->with('error', 'Unable to read the uploaded file.');
        }

        $header = fgetcsv($handle);

        if ($header === false) {
            fclose($handle);

            return back()->with('error', 'The uploaded CSV file is empty.');
        }

        $header = array_map(function ($column) {
            return strtolower(trim(str_replace("\xEF\xBB\xBF", '', (string) $column)));
        }, $header);

        $courses = Courses::all();
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            if (count(array_filter($row, fn ($value) => trim((string) $value) !== '')) === 0) {
                continue;
            }

            $row = array_pad(array_slice($row, 0, count($header)), count($header), null);
            $record = array_combine($header, $row);

            $studentCode = trim((string) ($record['student_code'] ?? ''));
            $name = trim((string) ($record['name'] ?? ''));
            $email = trim((string) ($record['email'] ?? ''));
            $phone = trim((string) ($record['phone'] ?? ''));
            $gender = ucfirst(strtolower(trim((string) ($record['gender'] ?? ''))));
            $courseValue = trim((string) ($record['course'] ?? $record['course_name'] ?? $record['course_id'] ?? ''));

            if ($studentCode === '' || $name === '' || $email === '') {
                $skipped++;
                $errors[] = "Row {$rowNumber}: student_code, name and email are required.";
                continue;
            }

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skipped++;
                $errors[] = "Row {$rowNumber}: '{$email}' is not a valid email address.";
                continue;
            }

            if (! in_array($gender, ['Male', 'Female'], true)) {
                $skipped++;
                $errors[] = "Row {$rowNumber}: gender must be Male or Female.";
                continue;
            }

            $course = $courses->first(fn ($c) => strcasecmp((string) $c->course_name, $courseValue) === 0)
                ?? $courses->first(fn ($c) => strcasecmp((string) $c->course_code, $courseValue) === 0)
                ?? (ctype_digit($courseValue) ? $courses->firstWhere('id', (int) $courseValue) : null);

            if (! $course) {
                $skipped++;
                $errors[] = "Row {$rowNumber}: course '{$courseValue}' was not found.";
                continue;
            }

            $attributes = [
                'student_code' => $studentCode,
                'name' => $name,
                'email' => $email,
                'phone' => $phone !== '' ? $phone : null,
                'gender' => $gender,
                'course_id' => $course->id,
            ];

            try {
                $student = LaravelStudent::where('student_code', $studentCode)->first();

                if ($student) {
                    $student->update($attributes);
                    $updated++;
                } else {
                    LaravelStudent::create($attributes);
                    $created++;
                }
            } catch (\Throwable $e) {
                $skipped++;
                $errors[] = "Row {$rowNumber}: email '{$email}' already belongs to another student.";
            }
        }

        fclose($handle);

        $message = "Import complete: {$created} created, {$updated} updated, {$skipped} skipped.";

        return redirect()->route('students.index')
            ->with($created + $updated > 0 ? 'success' : 'error', $message)
            ->with('import_errors', array_slice($errors, 0, 10));
    }
}