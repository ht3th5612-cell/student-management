@extends('layouts.app')
@section('title', 'Edit Course')
@section('content')

<div class="content-card"> 
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- course_code ပါဝင်ရန် -->
        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" value="{{ $course->course_code }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" value="{{ $course->course_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" value="{{ $course->description }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Duration Hours</label>
            <input type="text" name="duration_hours" class="form-control" value="{{ $course->duration_hours }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Course Fee</label>
            <input type="text" name="course_fee" class="form-control" value="{{ $course->course_fee }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

@endsection