@extends('layouts.student')

@section('content')
<div class="container py-5">
    <h2>Welcome Student, {{ Auth::user()->email }}!</h2>
</div>
@endsection
