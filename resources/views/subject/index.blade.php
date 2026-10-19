@extends('layouts.app')
@section('title','Subject List')
@section('content')

    <div class="container mt-5">
        <a href="{{ route('subjects.create') }}" class="btn btn-primary"> Add Subject </a>
    </div>

    <div class="container mt-5">
        <p> Total Subjects is {{ $count }}</p>
        
        <table class="table table-bordered table-striped">
            <thead class="table-dark"> <!-- calss အစား class ဟု ပြင်ဆင်ခြင်း -->
                <tr>
                    <th>Subject_ID</th>
                    <th>Subject Name</th>
                    <th>Description</th>
                    <th>Course</th>
                    <th>Actions</th> <!-- Actions ကော်လံခေါင်းစဉ် -->
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>{{ $subject->description }}</td>
                        <td>{{ $subject->courses?->course_name ?? "N/A" }}</td>
                        <td> 
                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection