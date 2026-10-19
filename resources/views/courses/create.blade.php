@extends('layouts.app')
@section('title','Add New Course')
@section('content')

<div class="content-card"> 
    <form action="{{ route('courses.store') }}" method="POST">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        @csrf
        
        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Duration Hours</label>
            <input type="text" name="duration_hours" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Course Fee</label>
            <input type="text" name="course_fee" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

@endsection