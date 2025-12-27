@extends('layouts.staff')

@section('title', 'Courses')

@section('content')
<div class="container-fluid">

    <h3 class="fw-bold mb-3">Courses</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($courses->isEmpty())
        <p class="text-muted">No courses found.</p>
    @else
        <ul class="list-group shadow-sm" style="max-width:600px">
            @foreach($courses as $course)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <strong>{{ $course->course_code }}</strong>
                        — {{ $course->course_title }}
                    </span>

                    <a href="{{ route('courses.edit', $course) }}"
                       class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

</div>
@endsection
