@extends('layouts.staff')

@section('content')


    {{-- Main Content --}}
    <div class="main-content">
        {{-- Header --}}
        
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">ASSIGNMENT & SUBMISSION {{ strtoupper($course->course_title) }}</h2>

            </div>
     

        {{-- Success/Error Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Assignment List Container --}}
        <div class="assignments-wrapper">
            @forelse($assignments as $assignment)
            <div class="assignment-item">
                <span class="assignment-title">{{ $assignment->title }}</span>
                <div class="action-buttons">
                    <a href="{{ route('assignment.edit', $assignment->assignment_id) }}" 
                       class="btn-update">
                        Update
                    </a>
                    <form action="{{ route('assignment.destroy', $assignment->assignment_id) }}" 
                          method="POST" 
                          class="delete-form"
                          onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-3">No assignments found for this course</p>
            </div>
            @endforelse

            {{-- Add Button --}}
            <div class="text-end mt-4">
                <a href="{{ route('assignment.create', $course->course_id) }}" 
                   class="btn-add">
                    ADD
                </a>
            </div>
        </div>
    </div>
</div>

<style>

.nav-item {
    display: flex;
    align-items: center;
    padding: 15px 25px;
    color: #ecf0f1;
    text-decoration: none;
    transition: all 0.3s;
}

.nav-item i {
    margin-right: 10px;
    font-size: 1.1rem;
}

.nav-item:hover,
.nav-item.active {
    background-color: #34495e;
    color: white;
}

.nav-item.logout {
    color: #e74c3c;
}

.nav-item.logout:hover {
    background-color: #c0392b;
    color: white;
}

/* Main Content */
.main-content {
    margin-left: 220px;
    padding: 30px;
    width: calc(100% - 220px);
    background-color: #f5f5f5;
    min-height: 100vh;
}

.content-header {
    background: white;
    padding: 20px 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.content-header h2 {
    color: #2c3e50;
    font-weight: 600;
}

/* Assignments Wrapper */
.assignments-wrapper {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Assignment Item */
.assignment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 30px;
    margin-bottom: 15px;
    background-color: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 30px;
    transition: all 0.3s;
}

.assignment-item:hover {
    border-color: #3498db;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.assignment-title {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.1rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-update {
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 8px 25px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-update:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
    color: white;
}

.delete-form {
    margin: 0;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-delete:hover {
    background-color: #c0392b;
    transform: scale(1.1);
}

.btn-delete i {
    font-size: 1.1rem;
}

/* Add Button */
.btn-add {
    background-color: #27ae60;
    color: white;
    border: none;
    border-radius: 25px;
    padding: 12px 40px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-add:hover {
    background-color: #229954;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        width: 70px;
    }
    
    .nav-item span {
        display: none;
    }
    
    .main-content {
        margin-left: 70px;
        width: calc(100% - 70px);
    }
    
    .assignment-item {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

@endsection