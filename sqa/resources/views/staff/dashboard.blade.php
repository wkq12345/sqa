@extends('layouts.staff')

@section('title', 'Staff Dashboard')

@section('content')
    <h2>Welcome, {{ auth()->user()->email }}</h2>
    <p>This is the staff dashboard area.</p>
@endsection
