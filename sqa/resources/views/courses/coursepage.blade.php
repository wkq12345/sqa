@extends('layouts.staff')

@section('title', 'Courses')

@section('content')
<style>
  :root{
    --sidebar:#3f464d;
    --bg:#ececec;
    --text:#111;
    --line:#111;
    --btn-pink:#ff4fb8;
    --btn-blue:#1f6feb;
    --btn-red:#ff4d4d;
    --save:#4c565f;
  }
  *{box-sizing:border-box}
  body{margin:0;font-family:Arial,Helvetica,sans-serif;color:var(--text);background:#fff}

  .main{background:var(--bg);padding:22px 26px 40px;position:relative}
  .topbar{display:flex;justify-content:flex-end;align-items:flex-start}

  .btn{border:none;padding:7px 14px;border-radius:999px;font-size:12px;cursor:pointer}
  .btn-pink{background:var(--btn-pink);color:#111;font-weight:700;box-shadow:0 2px 0 rgba(0,0,0,.2)}

  h1{margin:18px 0;font-size:16px;letter-spacing:.2px}

  .flash{padding:10px 12px;border:2px solid #111;border-radius:12px;background:#fff;margin:14px 0;font-size:13px}
  .error{margin:10px 0;padding:10px 12px;border:2px solid #c0392b;background:#fff;border-radius:12px}
  .error ul{margin:0;padding-left:18px}

  /* Cards */
  .cards{display:flex;gap:18px;flex-wrap:wrap;padding-top:6px}

  .course-card{
    width:200px;min-height:150px;background:#fff;border:1px solid #e6e6e6;border-radius:12px;
    padding:10px;display:flex;flex-direction:column;justify-content:space-between;
    box-shadow:0 2px 6px rgba(16,24,40,0.05)
  }

  .image-icon{
    width:100%;height:64px;border-radius:8px;background:#f3f3f3;overflow:hidden;margin-bottom:8px
  }

  .image-icon img{width:100%;height:100%;object-fit:cover}

  .course-title{text-align:center;font-weight:800;font-size:13px;line-height:1.1;margin:6px 0}
  .course-title .code{display:block;font-size:11px;color:#666;margin-bottom:4px}

  .card-actions{display:flex;justify-content:center;gap:10px}

  .edit{
    background:var(--btn-blue);color:#fff;padding:6px 12px;border-radius:999px;
    font-size:12px;font-weight:700;text-decoration:none
  }

  .delete{
    width:32px;height:32px;border-radius:50%;border:none;background:var(--btn-red);
    color:#fff;cursor:pointer
  }

  .search-container{margin-bottom:18px}
  .search-input{padding:10px 14px;border:1px solid #ddd;border-radius:6px;width:300px}

  @media (max-width:900px){
    .course-card{width:100%}
  }
</style>

<div class="main">

  <div class="topbar">
    <a href="{{ route('courses.create') }}" class="btn btn-pink me-2">Create Course</a>
    <a href="{{ route('courses.index') }}" class="btn" style="background:var(--btn-blue);color:#fff;font-weight:700">
      Course List
    </a>
  </div>

  @if(session('success'))
    <div class="flash">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="error">
      <strong>Please fix:</strong>
      <ul>
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <h1>COURSE OVERVIEW</h1>

  <div class="search-container">
    <input type="text" id="courseSearch" class="search-input"
           placeholder="Search by course code or title...">
  </div>

  <section class="cards">
    @forelse($courses as $course)
      <article class="course-card">
        <div>
          <div class="image-icon">
            @if($course->image_path)
              <img src="{{ asset('storage/'.$course->image_path) }}">
            @else
              <div style="display:grid;place-items:center;height:100%;color:#999;font-weight:700">IMG</div>
            @endif
          </div>

          <div class="course-title">
            <span class="code">{{ strtoupper($course->course_code) }}</span>
            {{ $course->course_title }}
          </div>
        </div>

        <div class="card-actions">
          <a href="{{ route('courses.edit',$course) }}" class="edit">Edit</a>

          <form method="POST" action="{{ route('courses.destroy',$course) }}" class="delete-form"
                data-course-title="{{ $course->course_title }}">
            @csrf @method('DELETE')
            <button type="button" class="delete">×</button>
          </form>
        </div>
      </article>
    @empty
      <p>No courses yet.</p>
    @endforelse
  </section>
</div>

<!-- Delete Modal -->
<div id="delete-modal" style="display:none;position:fixed;inset:0;z-index:1200;">
  <div style="position:absolute;inset:0;background:rgba(0,0,0,.45)"></div>
  <div style="position:relative;max-width:420px;margin:80px auto;background:#fff;
              border-radius:12px;padding:18px">
    <h3>Confirm delete</h3>
    <p id="delete-modal-body"></p>
    <div style="display:flex;justify-content:flex-end;gap:8px">
      <button id="delete-cancel" class="btn-cancel">Cancel</button>
      <button id="delete-confirm" class="btn-danger">Delete</button>
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

  document.querySelectorAll('.delete-form').forEach(f=>{
    f.querySelector('button').onclick = e=>{
      e.preventDefault();
      body.textContent = 'Delete "' + f.dataset.courseTitle + '"?';
      activeForm = f;
      modal.style.display = 'block';
    };
  });

  cancel.onclick = ()=> modal.style.display='none';
  confirm.onclick = ()=> activeForm && activeForm.submit();

  search.addEventListener('input',()=>{
    const q = search.value.toLowerCase();
    document.querySelectorAll('.course-card').forEach(c=>{
      c.style.display = c.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
  });
})();
</script>
@endsection
