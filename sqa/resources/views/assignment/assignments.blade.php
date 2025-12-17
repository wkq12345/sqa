@extends('layouts.staff')

@section('title', 'Assignment & Submission')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Assignment & Submission</h2>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($courses->isEmpty())
                <div class="alert alert-info">
                    No courses found. You need to have courses to manage assignments.
                </div>
            @else
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->course_code }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $course->course_name }}</h6>
                                    <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                    <a href="{{ route('assignments.course', $course->id) }}" 
                                       class="btn btn-primary">
                                        Manage Assignments
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection