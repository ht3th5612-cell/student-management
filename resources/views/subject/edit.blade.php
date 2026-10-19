@extends('layouts.app')
@section('title', 'Edit Subject')
@section('content')

<div class="content-card">
    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject_name" class="form-control" value="{{ $subject->subject_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" value="{{ $subject->description }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course</label>
            <select name="course_id" class="form-control" required>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected($course->id == $subject->course_id)>
                        {{ $course->course_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Subject</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

@endsection
