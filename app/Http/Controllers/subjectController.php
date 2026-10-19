<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\subject;
use App\Models\Courses;

class subjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = subject::with('courses')->orderBy('id', 'desc')->get();
        $count = $subjects->count();

        return view('subject.index', compact('subjects', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Courses::all();

        return view('subject.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_name' => 'required|string',
            'description'  => 'required|string',
            'course_id'    => ['required', 'integer', Rule::exists('courses', 'id')],
        ]);

        subject::create($data);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
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
        $subject = subject::findOrFail($id);
        $courses = Courses::all();

        return view('subject.edit', compact('subject', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = subject::findOrFail($id);

        $data = $request->validate([
            'subject_name' => 'required|string',
            'description'  => 'required|string',
            'course_id'    => ['required', 'integer', Rule::exists('courses', 'id')],
        ]);

        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
