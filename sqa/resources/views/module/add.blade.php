@extends('layouts.staff')

@section('title', 'Module Enrollment')

@section('content')
<style>
    .page-title {
        font-size: 26px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .course-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    /* Search Bar */
    .search-box {
        width: 280px;
        border: 2px solid #000;
        border-radius: 25px;
        padding: 8px 14px;
        font-size: 14px;
    }

    /* Add Student Button */
    .add-btn {
        background: #ff4fc0;
        color: white;
        font-weight: 700;
        padding: 10px 28px;
        border-radius: 25px;
        text-decoration: none;
        font-size: 15px;
    }

    .student-table {
        width: 75%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .student-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 2px solid #000;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 6px;
        background: #fff;
    }

    .student-name {
        font-size: 15px;
        font-weight: 600;
    }

    .status-label {
        font-size: 14px;
        font-weight: 700;
        margin-right: 15px;
    }

    .status-active { color: #28a745; }
    .status-completed { color: #0d6efd; }
    .status-withdrawn { color: #dc3545; }

    .edit-btn {
        padding: 4px 16px;
        background: #0d6efd;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        font-size: 13px;
        margin-right: 10px;
        text-decoration: none;
    }

    .del-btn {
        background: #dc3545;
        color: white;
        border-radius: 50%;
        padding: 8px 11px;
        font-size: 13px;
        text-decoration: none;
    }

</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">MODULE ENROLLMENT</h2>
            <h4 class="course-title">BCS3263 SOFTWARE QUALITY ASSURANCE</h4>
            <h5 style="font-weight:700;">STUDENT LIST :</h5>
        </div>

        <div class="text-end">
            <a href="#" class="add-btn">ADD STUDENT</a>
            <br><br>
            <input type="text" class="search-box" placeholder="Search...">
        </div>
    </div>

    @php
        $students = [
            ['name' => 'IKHWAN BADZLI', 'status' => 'ACTIVE'],
            ['name' => 'AKMAL RAZELAN', 'status' => 'ACTIVE'],
            ['name' => 'HARITH ZULHAIRI', 'status' => 'ACTIVE'],
            ['name' => 'MASYITAH GHOZALI', 'status' => 'ACTIVE'],
            ['name' => 'ATHIRAH HUSNA', 'status' => 'ACTIVE'],
            ['name' => 'NOORZAHIRAH HANIM', 'status' => 'COMPLETED'],
            ['name' => 'AKIF DANI', 'status' => 'COMPLETED'],
            ['name' => 'HAIQAL ZHAFRIL', 'status' => 'COMPLETED'],
            ['name' => 'FAWWAZ HATMI', 'status' => 'COMPLETED'],
            ['name' => 'CHE KU DANIEL HILMI', 'status' => 'COMPLETED'],
            ['name' => 'BUNGA CINTA LESTARI', 'status' => 'WITHDRAWN'],
            ['name' => 'AFGAN DANIEL', 'status' => 'WITHDRAWN'],
        ];
    @endphp

    <div class="student-table">
        @foreach ($students as $student)
            <div class="student-row">
                <div class="student-name">{{ $student['name'] }}</div>

                <div class="d-flex align-items-center">

                    {{-- STATUS --}}
                    <div class="status-label
                        {{ $student['status'] == 'ACTIVE' ? 'status-active' : '' }}
                        {{ $student['status'] == 'COMPLETED' ? 'status-completed' : '' }}
                        {{ $student['status'] == 'WITHDRAWN' ? 'status-withdrawn' : '' }}
                    ">
                        ( {{ strtoupper($student['status']) }} )
                    </div>

                    {{-- EDIT --}}
                    <a href="#" class="edit-btn">EDIT</a>

                    {{-- DELETE --}}
                    <a href="#" class="del-btn">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>

@endsection
