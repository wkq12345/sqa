@extends('layouts.staff')

@section('title', 'Enrolled Students')

@section('content')
<style>
/* ================= BASE ================= */
.page-title { font-size:24px;font-weight:700;margin-bottom:6px }
.top-actions { display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:20px }
.left-actions { display:flex;flex-direction:column;gap:10px }
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
.right-actions { display:flex;flex-direction:column;align-items:flex-end;gap:10px }
.add-btn { background:#000;color:#fff;padding:6px 18px;border-radius:20px;text-decoration:none }
.search-bar { width:260px;border:2px solid #000;border-radius:25px;padding:8px 14px }

/* ================= TABLE ================= */
.table-container { background:#fff;border:2px solid #000;border-radius:20px;padding:20px }
table { width:100%;border-collapse:collapse }
thead th { border-bottom:2px solid #000;padding:10px;text-align:left }
tbody td { padding:10px;border-bottom:1px solid #ddd }

.status-badge {
    padding:5px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:700;
    text-transform:uppercase;
}
.status-active { background:#d1fae5;color:#065f46 }
.status-completed { background:#e0e7ff;color:#3730a3 }
.status-withdrawn { background:#fee2e2;color:#991b1b }

/* ================= ACTIONS ================= */
.action-btn {
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:700;
    border:none;
    cursor:pointer;
}
.edit-btn { background:#000;color:#fff }

.delete-btn {
    background:none;
    border:none;
    cursor:pointer;
}
.delete-btn svg {
    width:18px;
    height:18px;
    fill:#dc2626;
}


/* ================= MODAL ================= */
.modal-overlay {
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.6);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:5000;
}

.modal-box {
    background:#bfbfbf;
    padding:28px 30px;
    border-radius:26px;
    border:3px solid #000;
    width:380px;
    text-align:center;
}

.modal-box h3 {
    font-weight:800;
    margin-bottom:20px;
}

/* Status selector */
.status-options {
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-bottom:22px;
}

.status-option {
    flex:1;
    border:2px solid #000;
    border-radius:22px;
    padding:6px 0;
    font-weight:800;
    cursor:pointer;
    background:#e5e5e5;
}

.status-option.active {
    background:#fff;
}

/* Modal buttons */
.modal-actions {
    display:flex;
    justify-content:center;
    gap:18px;
}

.confirm-btn {
    background:#22c55e;
    padding:6px 22px;
    border-radius:20px;
    font-weight:800;
    border:none;
}

.cancel-btn {
    background:#dc2626;
    color:#fff;
    padding:6px 22px;
    border-radius:20px;
    font-weight:800;
    border:none;
}
</style>

<div class="container-fluid">

    <!-- TOP -->
    <div class="top-actions">
        <div class="left-actions">
            <a href="{{ route('staff.enrollment') }}" class="back-btn">Back</a>
            <h2 class="page-title">{{ $course->course_code }} — {{ $course->course_title }}</h2>
        </div>

        <div class="right-actions">
            <a href="{{ route('module.add', $course->course_id) }}" class="add-btn">+ Add Student</a>
            <input type="text" id="searchInput" class="search-bar"
                   placeholder="Search student name or ID..."
                   onkeyup="filterStudents()">
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th width="160">Action</th>
                </tr>
            </thead>
            <tbody>
            @php
                $priority = ['active'=>1,'completed'=>2,'withdrawn'=>3];
                $sortedModules = $modules->sortBy(fn($m)=>$priority[$m->status]);
            @endphp

            @foreach($sortedModules as $module)
                <tr class="student-row"
                    data-name="{{ strtolower($module->name) }}"
                    data-id="{{ strtolower($module->student->student_id) }}">

                    <td>{{ $module->student->student_id }}</td>
                    <td>{{ $module->name }}</td>
                    <td>
                        <span class="status-badge status-{{ $module->status }}">
                            {{ $module->status }}
                        </span>
                    </td>

                    <td>
                        <button class="action-btn edit-btn"
                                onclick="openEdit({{ $module->id }}, '{{ $module->name }}', '{{ $module->status }}')">
                            EDIT
                        </button>

                        <button class="delete-btn"
                                onclick="openDelete({{ $module->id }}, '{{ $module->name }}')">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 3h6v2h5v2H4V5h5V3zm1 6h2v9h-2V9zm4 0h2v9h-2V9zM6 9h2v9H6V9z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <h3 id="editTitle"></h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="editStatus">

            <div class="status-options">
                <div class="status-option" onclick="selectStatus('withdrawn')">WITHDRAWN</div>
                <div class="status-option" onclick="selectStatus('completed')">COMPLETED</div>
                <div class="status-option" onclick="selectStatus('active')">ACTIVE</div>
            </div>

            <div class="modal-actions">
                <button class="confirm-btn">CONFIRM</button>
                <button type="button" class="cancel-btn" onclick="closeEdit()">CANCEL</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3 id="deleteTitle"></h3>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-actions">
                <button class="confirm-btn">CONFIRM</button>
                <button type="button" class="cancel-btn" onclick="closeDelete()">CANCEL</button>
            </div>
        </form>
    </div>
</div>

<script>
function filterStudents(){
    let q=document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(r=>{
        r.style.display = r.dataset.name.includes(q)||r.dataset.id.includes(q)?'':'none';
    });
}

function openEdit(id,name,status){
    document.getElementById('editTitle').innerText = name+"'s STATUS UPDATE";
    document.getElementById('editForm').action = '/staff/enrollment/update/'+id;
    selectStatus(status);
    document.getElementById('editModal').style.display='flex';
}

function selectStatus(status){
    document.getElementById('editStatus').value=status;
    document.querySelectorAll('.status-option').forEach(o=>{
        o.classList.toggle('active', o.innerText.toLowerCase()===status);
    });
}

function closeEdit(){ document.getElementById('editModal').style.display='none'; }

function openDelete(id,name){
    document.getElementById('deleteTitle').innerText = 'CONFIRM TO REMOVE '+name+' ?';
    document.getElementById('deleteForm').action = '/staff/enrollment/delete/'+id;
    document.getElementById('deleteModal').style.display='flex';
}

function closeDelete(){ document.getElementById('deleteModal').style.display='none'; }
</script>
@endsection
