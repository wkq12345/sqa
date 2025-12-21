@extends('layouts.staff')

@section('title', 'Add Students')

@section('content')
<style>
    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    /* STICKY CONTROL BAR */
    .sticky-bar {
        position: sticky;
        top: 72px; /* below navbar */
        z-index: 1200;
        background: #f9fafb;
        padding: 16px 0;
        border-bottom: 2px solid #000;
    }

    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        flex-wrap: wrap;
    }

    .left-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .back-btn {
        background: transparent;
        border: 2px solid #000;
        padding: 6px 18px;
        border-radius: 20px;
        text-decoration: none;
        color: #000;
        font-size: 14px;
        width: fit-content;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .add-btn {
        background: #16a34a;
        color: #fff;
        padding: 10px 26px;
        border-radius: 25px;
        border: none;
        font-weight: 700;
        cursor: pointer;
    }

    .reset-btn {
        background: #e5e7eb;
        color: #000;
        padding: 10px 26px;
        border-radius: 25px;
        border: 2px solid #000;
        font-weight: 700;
        cursor: pointer;
    }

    .search-bar {
        width: 260px;
        border: 2px solid #000;
        border-radius: 25px;
        padding: 8px 14px;
        font-size: 14px;
        height: 42px;
    }

    /* STUDENT LIST */
    .student-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #000;
        padding: 10px 14px;
        background: #fff;
    }

    .student-name {
        font-weight: 600;
    }

    .select-box {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    /* ALPHABET FILTER */
    .alphabet-filter {
        position: fixed;
        right: 20px;
        top: 160px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        z-index: 1000;
    }

    .alphabet-filter span {
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    /* MODAL */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .modal-box {
        background: #bfbfbf;
        padding: 30px;
        border-radius: 25px;
        text-align: center;
        width: 360px;
        border: 3px solid #000;
    }

    .modal-actions {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .confirm-btn {
        background: #22c55e;
        padding: 6px 18px;
        border-radius: 20px;
        border: none;
        font-weight: 700;
        cursor: pointer;
    }

    .cancel-btn {
        background: #dc2626;
        color: #fff;
        padding: 6px 18px;
        border-radius: 20px;
        border: none;
        font-weight: 700;
        cursor: pointer;
    }
</style>

<div class="container-fluid">

    <!-- STICKY BAR -->
    <div class="sticky-bar">
        <div class="top-actions">

            <!-- LEFT -->
            <div class="left-actions">
                <a href="{{ route('module.show', $course->course_id) }}" class="back-btn">
                    Back
                </a>

                <h2 class="page-title">
                    {{ $course->course_code }} — {{ $course->course_title }}
                </h2>

                <div class="action-buttons">
                    <button type="button" class="add-btn" onclick="openConfirm()">
                        ADD SELECTED
                    </button>

                    <button type="button" class="reset-btn" onclick="resetSelection()">
                        RESET
                    </button>
                </div>
            </div>

            <!-- RIGHT -->
            <input type="text"
                   id="searchInput"
                   class="search-bar"
                   placeholder="Search student name or ID..."
                   onkeyup="filterStudents()">
        </div>
    </div>

    <!-- FORM -->
    <form id="addForm" method="POST" action="{{ route('module.store') }}">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->course_id }}">

        <div id="studentList">
            @php
                $enrolledIds = $course->modules->pluck('student_id')->toArray();
                $availableStudents = $students
                    ->whereNotIn('id', $enrolledIds)
                    ->sortBy('name');
            @endphp

            @foreach ($availableStudents as $student)
                <div class="student-card student-item"
                     id="letter-{{ strtoupper(substr($student->name, 0, 1)) }}"
                     data-name="{{ strtolower($student->name) }}"
                     data-id="{{ strtolower($student->student_id) }}">

                    <div>
                        <div class="student-name">{{ $student->name }}</div>
                        <small>{{ $student->student_id }}</small>
                    </div>

                    <input type="checkbox"
                           class="select-box"
                           name="student_id[]"
                           value="{{ $student->id }}">
                </div>
            @endforeach
        </div>
    </form>
</div>

<!-- ALPHABET -->
<div class="alphabet-filter">
    @foreach (range('A','Z') as $char)
        <span onclick="scrollToLetter('{{ $char }}')">{{ $char }}</span>
    @endforeach
</div>

<!-- MODAL -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <h3>CONFIRM ADD STUDENTS?</h3>

        <div class="modal-actions">
            <button class="confirm-btn" onclick="submitForm()">CONFIRM</button>
            <button class="cancel-btn" onclick="closeConfirm()">CANCEL</button>
        </div>
    </div>
</div>

<script>
    function filterStudents() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.student-item').forEach(item => {
            let name = item.dataset.name;
            let id = item.dataset.id;
            item.style.display =
                name.includes(input) || id.includes(input)
                ? 'flex' : 'none';
        });
    }

    function resetSelection() {
        document.getElementById('searchInput').value = '';
        document.querySelectorAll('.select-box').forEach(cb => cb.checked = false);
        document.querySelectorAll('.student-item').forEach(item => {
            item.style.display = 'flex';
        });
    }

    function scrollToLetter(letter) {
        let el = document.getElementById('letter-' + letter);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }

    function openConfirm() {
        let checked = document.querySelectorAll('.select-box:checked');
        if (checked.length === 0) {
            alert('Please select at least one student.');
            return;
        }
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function closeConfirm() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    function submitForm() {
        document.getElementById('addForm').submit();
    }
</script>
@endsection
