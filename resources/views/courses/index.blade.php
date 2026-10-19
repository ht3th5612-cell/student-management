@extends('layouts.app')
@section('title', 'Course List')
@section('content')

    <div class="container mt-5">
        <a href="{{ route('courses.create') }}" class="btn btn-primary"> Add Course </a>
    </div>
    
    <div class="container mt-5">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Duration Hours</th>
                    <th>Course Fee</th>
                    <th>Actions</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $c)
                    <tr>
                        <td>{{ $c->course_code }}</td>
                        <td>{{ $c->course_name }}</td>
                        <td>{{ $c->description }}</td>
                        <td>{{ $c->duration_hours }}</td>
                        <td>{{ $c->course_fee }}</td>
                        <td>
                            <a href="{{ route('courses.edit', $c->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            
                            <form action="{{ route('courses.destroy', $c->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection