@extends('layouts.staff')

@section('title', 'Course List')

@section('content')
<style>
  :root{
    --bg:#ececec;
    --btn-pink:#ff4fb8;
    --btn-blue:#1f6feb;
    --btn-red:#ff4d4d;
  }

  .main-wrap{
    background:var(--bg);
    padding:22px 26px 40px;
  }

  .topbar{
    display:flex;
    justify-content:flex-end;
    gap:8px;
  }

  .btn{
    border:none;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    cursor:pointer;
    text-decoration:none;
    font-weight:700;
  }

  .btn-pink{background:var(--btn-pink);color:#111}
  .btn-blue{background:var(--btn-blue);color:#fff}

  .course-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(16,24,40,0.06)
  }

  .course-table th,
  .course-table td{
    padding:12px 14px;
    border-bottom:1px solid #eef2f6;
    font-size:14px;
    text-align:left;
  }

  .course-table th{
    background:#f4f6f8;
    font-weight:800;
    font-size:13px;
  }

  .course-img{
    width:140px;
    height:84px;
    object-fit:cover;
    border-radius:6px;
    background:#f3f3f3;
  }

  .code{color:#666;font-weight:800}
  .title{font-weight:900}

  .actions{
    display:flex;
    gap:8px;
    align-items:center;
  }

  .edit{
    background:var(--btn-blue);
    color:#fff;
    padding:8px 12px;
    border-radius:999px;
    font-size:12px;
    text-decoration:none;
    font-weight:700;
  }

  .delete{
    background:var(--btn-red);
    color:#fff;
    padding:8px 12px;
    border-radius:999px;
    border:none;
    font-size:12px;
    font-weight:700;
    cursor:pointer;
  }

  .search-container{
    margin:18px 0;
  }

  .search-input{
    padding:10px 14px;
    border:1px solid #ddd;
    border-radius:6px;
    font-size:14px;
    width:300px;
  }

  .desc-details{max-width:260px}

  .desc-summary{
    cursor:pointer;
    background:#f4f6f8;
    border:1px solid #e6ebf2;
    border-radius:10px;
    padding:8px 12px;
    font-size:13px;
    font-weight:700;
    list-style:none;
    position:relative;
    padding-right:30px;
  }

  .desc-summary::after{
    content:"▼";
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    font-size:12px;
    color:#1f6feb;
  }

  .desc-details[open] .desc-summary::after{
    transform:translateY(-50%) rotate(180deg);
  }

  .desc-full{
    margin-top:8px;
    padding:10px 12px;
    border:1px solid #eef2f6;
    border-radius:10px;
    background:#fff;
    font-size:13px;
    line-height:1.6;
    max-height:200px;
    overflow:auto;
  }

  .success-box{
    margin:12px 0;
    padding:10px 14px;
    background:#e6fffa;
    border:2px solid #2ecc71;
    border-radius:10px;
    font-weight:700;
    color:#065f46;
  }
</style>

<div class="main-wrap">

  <div class="topbar">
    <a href="{{ route('courses.create') }}" class="btn btn-pink">Create Course</a>
    <a href="{{ route('courses.index') }}" class="btn btn-blue">Course List</a>
  </div>

  <h1 class="mt-3">Course List</h1>

  @if(session('success'))
    <div class="success-box">
      {{ session('success') }}
    </div>
  @endif

  <div class="search-container">
    <input type="text" id="courseSearch" class="search-input"
           placeholder="Search by course code or title...">
  </div>

  <table class="course-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Code</th>
        <th>Title</th>
        <th>Description</th>
        <th>Category</th>
        <th width="160">Actions</th>
      </tr>
    </thead>

    <tbody>
      @forelse($courses as $course)
        <tr>
          <td>
            @if($course->image_path)
              <img src="{{ asset('storage/'.$course->image_path) }}" class="course-img">
            @else
              <div class="course-img d-flex align-items-center justify-content-center text-muted">IMG</div>
            @endif
          </td>

          <td class="code">{{ strtoupper($course->course_code) }}</td>
          <td class="title">{{ $course->course_title }}</td>

          <td>
            @if($course->description)
              <details class="desc-details">
                <summary class="desc-summary">
                  {{ \Illuminate\Support\Str::limit($course->description, 50) }}
                </summary>
                <div class="desc-full">{{ $course->description }}</div>
              </details>
            @else
              -
            @endif
          </td>

          <td>{{ $course->category ?? '-' }}</td>

          <td>
            <div class="actions">
              <a href="{{ route('courses.edit',$course) }}" class="edit">Edit</a>

              <form method="POST"
                    action="{{ route('courses.destroy',$course) }}"
                    class="delete-form"
                    data-course-title="{{ $course->course_title }}">
                @csrf
                @method('DELETE')
                <button type="button" class="delete">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="padding:18px;color:#555">No courses yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

</div>

<!-- Delete modal -->
<div id="delete-modal" style="display:none;position:fixed;inset:0;z-index:1200;">
  <div style="position:absolute;inset:0;background:rgba(0,0,0,.45)"></div>
  <div style="position:relative;max-width:420px;margin:80px auto;background:#fff;border-radius:12px;padding:18px">
    <h3>Confirm delete</h3>
    <p id="delete-modal-body"></p>
    <div style="display:flex;justify-content:flex-end;gap:8px">
      <button id="delete-cancel" class="btn btn-pink" style="background:#f1f3f5;color:#111">Cancel</button>
      <button id="delete-confirm" class="btn" style="background:var(--btn-red);color:#fff">Delete</button>
    </div>
  </div>
</div>

<script>
(function(){
  const modal = document.getElementById('delete-modal');
  const body = document.getElementById('delete-modal-body');
  const cancel = document.getElementById('delete-cancel');
  const confirm = document.getElementById('delete-confirm');
  const search = document.getElementById('courseSearch');
  let activeForm = null;

  document.querySelectorAll('.delete-form').forEach(form=>{
    form.querySelector('button').onclick = e=>{
      e.preventDefault();
      body.textContent = 'Delete "' + form.dataset.courseTitle + '"? This action cannot be undone.';
      activeForm = form;
      modal.style.display = 'block';
    };
  });

  cancel.onclick = ()=> modal.style.display='none';
  confirm.onclick = ()=> activeForm && activeForm.submit();

  search.addEventListener('input',()=>{
    const q = search.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row=>{
      row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  });
})();
</script>
@endsection
