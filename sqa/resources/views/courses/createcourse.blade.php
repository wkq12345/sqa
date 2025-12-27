@extends('layouts.staff')

@section('title', 'Create Course')

@section('content')
<style>
  :root{
    --bg:#ececec;
    --btn-pink:#ff4fb8;
    --save:#4c565f;
  }

  .main-wrap{
    background:var(--bg);
    padding:22px 26px 40px;
  }

  .topbar{
    display:flex;
    justify-content:flex-end;
  }

  .btn-pink{
    background:var(--btn-pink);
    color:#111;
    padding:7px 14px;
    border-radius:999px;
    font-weight:700;
    font-size:12px;
    text-decoration:none;
    box-shadow:0 2px 0 rgba(0,0,0,.2);
  }

  .error{
    margin:10px 0;
    padding:10px 12px;
    border:2px solid #c0392b;
    background:#fff;
    border-radius:12px;
  }

  .error ul{margin:0;padding-left:18px}

  .card{
    max-width:820px;
    margin:24px auto;
    background:#fff;
    border-radius:12px;
    padding:18px;
    border:1px solid #e2e2e2;
  }

  .row{
    display:grid;
    grid-template-columns:200px 1fr;
    gap:22px;
    align-items:center;
    margin:18px 0;
  }

  .row label{
    font-size:14px;
    font-weight:800;
    text-transform:uppercase;
  }

  input, textarea{
    width:100%;
    border:2px solid #111;
    border-radius:999px;
    padding:12px 16px;
    background:#f7f7f7;
    font-size:14px;
  }

  textarea{
    border-radius:18px;
    min-height:120px;
    resize:none;
  }

  .category input{max-width:300px}

  .image-box{
    border:2px solid #111;
    border-radius:18px;
    background:#f7f7f7;
    display:flex;
    align-items:center;
    gap:18px;
    padding:18px;
    min-height:150px;
  }

  .thumb{
    width:130px;
    height:100px;
    border:2px solid #111;
    border-radius:10px;
    background:#fff;
    display:grid;
    place-items:center;
    font-weight:700;
    color:#999;
  }

  .thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:none;
  }

  .file-input{
    border-radius:999px;
    padding:10px 18px;
    border:2px solid #111;
    background:#fff;
    max-width:520px;
  }

  .actions-row{
    margin-top:22px;
    display:flex;
    gap:12px;
    justify-content:flex-end;
  }

  .btn-cancel{
    background:#f1f3f5;
    color:#111;
    padding:10px 24px;
    border-radius:999px;
    font-weight:800;
    text-decoration:none;
  }

  .save-btn{
    background:var(--save);
    color:#fff;
    padding:10px 28px;
    border-radius:999px;
    font-weight:800;
    border:none;
    cursor:pointer;
  }

  @media (max-width:900px){
    .row{grid-template-columns:1fr}
    .image-box{flex-direction:column;align-items:flex-start}
  }
</style>

<div class="main-wrap">

  <div class="topbar">
    <a href="{{ route('courses.create') }}" class="btn-pink">Create Course</a>
  </div>

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

  <div class="card">
    <h2>Create Course</h2>

    <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">
        <label>Course Code</label>
        <input name="course_code" value="{{ old('course_code') }}" required>
      </div>

      <div class="row">
        <label>Course Title</label>
        <input name="course_title" value="{{ old('course_title') }}" required>
      </div>

      <div class="row">
        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>
      </div>

      <div class="row category">
        <label>Category</label>
        <input name="category" value="{{ old('category') }}">
      </div>

      <div class="row">
        <label>Image</label>
        <div class="image-box">
          <div class="thumb">
            <span id="thumbText">IMG</span>
            <img id="previewImg" alt="preview">
          </div>

          <input class="file-input" type="file" id="imageInput" name="image" accept="image/*">
        </div>
      </div>

      <div class="actions-row">
        <a href="{{ route('courses.index') }}" class="btn-cancel">Cancel</a>
        <button class="save-btn" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
  const imageInput = document.getElementById('imageInput');
  const previewImg = document.getElementById('previewImg');
  const thumbText = document.getElementById('thumbText');

  imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    previewImg.src = URL.createObjectURL(file);
    previewImg.style.display = "block";
    thumbText.style.display = "none";
  });
</script>
@endsection
