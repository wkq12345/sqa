@extends('layouts.staff')

@section('title', 'Enrollment')

@section('content')
<style>
    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 0px;
    }

    /* Search Bar */
    .search-bar {
        width: 260px;
        border: 2px solid #000;
        border-radius: 25px;
        padding: 8px 14px;
        font-size: 14px;
    }

    /* Enrollment Card */
    .enroll-card {
        display: flex;
        align-items: center;
        border: 2px solid #000;
        border-radius: 40px;
        padding: 10px 20px;
        margin-bottom: 20px;
        background: #fff;
    }

    .enroll-card img {
        width: 45px;
        height: 45px;
        margin-right: 15px;
    }

    .enroll-title {
        font-size: 17px;
        font-weight: 700;
        flex: 1;
    }

    .view-btn {
        background: black;
        color: white;
        padding: 6px 18px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 14px;
    }
</style>

<div class="container-fluid">

    <!-- TITLE + SEARCH BAR (Fixed Layout) -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Enrollment List</h2>
        <input type="text" class="search-bar" placeholder="Search...">
    </div>

    <!-- Dummy Data Until DB Is Ready -->
    @php
        $enrollments = [
            ['course' => 'BCS3263 SOFTWARE QUALITY ASSURANCE', 'student' => 'John Doe'],
            ['course' => 'BCS3153 SOFTWARE EVOLUTION MAINTENANCE', 'student' => 'Ali Bin Ahmad'],
            ['course' => 'BCM3103 VIRTUAL REALITY', 'student' => 'Fatimah Zainal'],
            ['course' => 'BCS3453 INTEGRATED APPLICATION DEVELOPMENT FRAMEWORK', 'student' => 'Sara Lim'],
            ['course' => 'BUM2413 APPLIED STATISTIC', 'student' => 'Michael Tan'],
        ];
    @endphp

    <!-- Enrollment Cards -->
    @foreach ($enrollments as $item)
        <div class="enroll-card">
            <img src="https://cdn-icons-png.flaticon.com/512/4211/4211763.png" alt="icon">

            <div class="enroll-title">
                {{ $item['course'] }} —
                <span style="font-weight:500;">{{ $item['student'] }}</span>
            </div>

            <a href="#" class="view-btn">View</a>
        </div>
    @endforeach

</div>
@endsection
