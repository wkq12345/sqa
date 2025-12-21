@extends('layouts.staff')

@section('title', 'Enrollment')

@section('content')
<style>
    .page-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 0;
    }

    .search-bar {
        width: 260px;
        border: 2px solid #000;
        border-radius: 25px;
        padding: 8px 14px;
        font-size: 14px;
    }

    .enroll-card {
        display: flex;
        align-items: center;
        border: 2px solid #000;
        border-radius: 40px;
        padding: 10px 20px;
        margin-bottom: 16px;
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

    .alphabet-filter {
        position: fixed;
        right: 20px;
        top: 160px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        z-index: 1000;
    }

    .alphabet-filter a {
        font-size: 13px;
        font-weight: 600;
        color: #000;
        cursor: pointer;
        text-decoration: none;
    }

    .alphabet-filter a:hover {
        text-decoration: underline;
    }
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Enrollment List</h2>

        <input type="text"
               id="searchInput"
               class="search-bar"
               placeholder="Search by Course ID or Title..."
               onkeyup="filterCourses()">
    </div>

    <div id="courseList">

        @php
            $groupedCourses = $courses
                ->sortBy('course_title')
                ->groupBy(fn($course) => strtoupper(substr($course->course_title, 0, 1)));
        @endphp

        @foreach ($groupedCourses as $letter => $items)
            <div id="letter-{{ $letter }}" class="mb-4">

                <h4 class="fw-bold mb-3">{{ $letter }}</h4>

                @foreach ($items as $course)
                    <div class="enroll-card course-item"
                         data-course-id="{{ strtolower($course->course_code) }}"
                         data-course-title="{{ strtolower($course->course_title) }}">

                        <img src="https://cdn-icons-png.flaticon.com/512/4211/4211763.png">

                        <div class="enroll-title">
                            {{ $course->course_code }} —
                            <span style="font-weight:500">{{ $course->course_title }}</span>
                        </div>

                        <a href="{{ route('module.show', $course->course_id) }}" class="view-btn">
                            View
                        </a>
                    </div>
                @endforeach

            </div>
        @endforeach

    </div>
</div>

<div class="alphabet-filter">
    @foreach (range('A','Z') as $char)
        <a onclick="scrollToLetter('{{ $char }}')">{{ $char }}</a>
    @endforeach
</div>

<script>
    function filterCourses() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let items = document.getElementsByClassName('course-item');

        Array.from(items).forEach(item => {
            let code = item.dataset.courseId;
            let title = item.dataset.courseTitle;

            item.style.display =
                code.includes(input) || title.includes(input)
                ? 'flex' : 'none';
        });
    }

    function scrollToLetter(letter) {
        let el = document.getElementById('letter-' + letter);
        if (el) el.scrollIntoView({ behavior: 'smooth' });
    }
</script>
@endsection
