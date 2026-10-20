@extends('layouts.app')
@section('title','Student List')
@section('content')

    <div class="container mt-5 d-flex flex-wrap gap-2 align-items-start">
        <a href="{{ route('students.create') }}" class="btn btn-primary"> Add Student </a>
        <a href="{{ route('students.export') }}" class="btn btn-success"> Export CSV </a>

        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            @csrf
            <input type="file" name="csv_file" class="form-control" accept=".csv,text/csv" required>
            <button type="submit" class="btn btn-warning text-nowrap"> Import CSV </button>
        </form>
    </div>

    <div class="container mt-5">
        <p> Total Student is {{ $count }}</p>
        
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Student Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_code }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->course?->course_name ?? "N/A" }}</td>
                        <td> 
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links ကို Table ၏ အပြင်ဘက် (အောက်နား) သို့ ရွှေ့ခြင်း -->
        <div class="mt-3">
            {{ $students->links() }}
        </div>
    </div>
@endsection