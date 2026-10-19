@extends('layouts.app')
@section('title', 'Add New Student')
@section('content')

<div class="content-card"> 
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        
        <!-- student_code input field ထည့်ပေးရန် -->
        <div class="mb-3">
            <label class="form-label">Student Code</label>
            <input type="text" name="student_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Course</label>
            <select name="course_id" class="form-control">
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

@endsection