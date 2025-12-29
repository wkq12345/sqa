@extends('layouts.staff')

@section('title', 'Edit Course')

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
  }

  .card{
    max-width:720px;
    margin:24px auto;
    background:#fff;
    border-radius:12px;
    padding:18px;
    border:1px solid #e2e2e2;
  }

  .row{
    display:grid;
    grid-template-columns:190px 1fr;
    gap:18px;
    align-items:center;
    margin:18px 0;
  }

  label{
    font-size:14px;
    font-weight:800;
    text-transform:uppercase;
  }

  input, textarea{
    width:100%;
    border:2px solid #111;
    border-radius:999px;
    padding:10px 14px;
    background:#f7f7f7;
    font-size:14px;
  }

  textarea{
    border-radius:18px;
    min-height:110px;
    resize:none;
  }

  .category input{width:240px}

  .image-box{
    border:2px solid #111;
    border-radius:18px;
    background:#f7f7f7;
    display:flex;
    align-items:center;
    gap:18px;
    padding:18px;
  }

  .thumb{
    width:120px;
    height:100px;
    border:2px solid #111;
    border-radius:10px;
    background:#fff;
    display:grid;
    place-items:center;
    overflow:hidden;
  }

  .thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
  }

  .file-input{
    border-radius:999px;
    padding:8px 14px;
    border:2px solid #111;
    background:#fff;
    max-width:520px;
  }

  .remove-check{
    display:flex;
    align-items:center;
    gap:6px;
    font-size:13px;
    font-weight:700;
    text-transform:uppercase;
    cursor:pointer;
  }

  .actions-row{
    margin-top:20px;
    display:flex;
    gap:10px;
    justify-content:flex-end;
  }

  .btn-cancel{
    background:#f1f3f5;
    color:#111;
    padding:8px 18px;
    border-radius:999px;
    font-weight:800;
    text-decoration:none;
  }

  .save-btn{
    background:var(--save);
    color:#fff;
    padding:8px 22px;
    border-radius:999px;
    font-weight:800;
    border:none;
    cursor:pointer;
  }

  @media (max-width:900px){
    .row{grid-template-columns:1fr}
    .category input{width:100%}
    .image-box{flex-direction:column}
  }
</style>

<div class="main-wrap">

  <div class="topbar">
    <a href="{{ route('courses.create') }}" class="btn-pink">Create Course</a>
  </div>

  <div class="card">
    <h2>Edit Course</h2>

    <form method="POST"
          action="{{ route('courses.update', $course) }}"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row">
        <label>Course Code</label>
        <input name="course_code"
               value="{{ old('course_code', $course->course_code) }}"
               required>
      </div>

      <div class="row">
        <label>Course Title</label>
        <input name="course_title"
               value="{{ old('course_title', $course->course_title) }}"
               required>
      </div>

      <div class="row">
        <label>Description</label>
        <textarea name="description">{{ old('description', $course->description) }}</textarea>
      </div>

      <div class="row category">
        <label>Category</label>
        <input name="category"
               value="{{ old('category', $course->category) }}">
      </div>

      <div class="row">
        <label>Image</label>
        <div class="image-box">

          <div class="thumb">
            @if($course->image_path)
              <img src="{{ asset('storage/'.$course->image_path) }}">
            @else
              <span style="color:#999">No image</span>
            @endif
          </div>

          <div>
            <input class="file-input" type="file" name="image">

            @if($course->image_path)
              <label class="remove-check mt-2">
                <input type="checkbox" name="remove_image" value="1">
                <span>Remove current image</span>
              </label>
            @endif
          </div>

        </div>
      </div>

      <div class="actions-row">
        <a href="{{ route('courses.index') }}" class="btn-cancel">Cancel</a>
        <button type="submit" class="save-btn">Update</button>
      </div>

    </form>
  </div>
</div>
@endsection
