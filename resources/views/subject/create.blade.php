@extends('layouts.app')
@section('title', 'Add Subject')

@section('content')
<div class="content-card">
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course</label>
            <select name="course_id" class="form-control">
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>
        </div>

        

        <button type="submit" class="btn btn-primary">Save Subject</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection