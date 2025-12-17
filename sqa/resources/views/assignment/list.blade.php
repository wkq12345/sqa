@extends('layouts.staff')

@section('content')
<div class="d-flex">
    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-content">
            <a href="#" class="nav-item">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-book"></i>
                <span>Module</span>
            </a>
            <a href="{{ route('assignments.assignments') }}" class="nav-item active">
                <i class="bi bi-file-text"></i>
                <span>Assignment & Submission</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
            <a href="#" class="nav-item logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Header --}}
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">ASSIGNMENT & SUBMISSION {{ strtoupper($course->name) }}</h2>
                <button class="btn btn-outline-primary rounded-pill px-4">
                    Notifications
                </button>
            </div>
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

        {{-- Assignment List --}}
        <div class="assignments-list">
            @forelse($assignments as $assignment)
                <div class="assignment-row">
                    <div class="assignment-title">{{ $assignment->title }}</div>
                    <div class="assignment-actions">
                        {{-- Edit Button (Blue) --}}
                        <a href="{{ route('assignments.edit', $assignment->id) }}" 
                           class="action-btn edit-btn">
                            EDIT
                        </a>
                        
                        {{-- Delete Button (Red) --}}
                        <form action="{{ route('assignments.destroy', $assignment->id) }}" 
                              method="POST" 
                              class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete-btn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                    <p class="text-muted mt-3">No assignments yet. Click the + button to add one.</p>
                </div>
            @endforelse
        </div>

        {{-- Floating Add Button --}}
        <a href="{{ route('assignments.create', $course->id) }}" class="fab-button">
            ADD
        </a>
    </div>
</div>

<style>
/* Sidebar Styles (same as Interface 1) */
.sidebar {
    width: 220px;
    background-color: #2c3e50;
    min-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
}

.sidebar-content {
    padding: 20px 0;
}

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

/* Assignment Row */
.assignments-list {
    max-width: 800px;
}

.assignment-row {
    background: white;
    border-radius: 30px;
    padding: 20px 30px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.assignment-row:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.assignment-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: #2c3e50;
}

.assignment-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

/* Action Buttons */
.action-btn {
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
}

.edit-btn {
    background-color: #3498db;
    color: white;
}

.edit-btn:hover {
    background-color: #2980b9;
    transform: scale(1.05);
    color: white;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
    font-size: 1.1rem;
}

.delete-btn:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

/* Floating Add Button */
.fab-button {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #27ae60;
    color: white;
    border: none;
    border-radius: 30px;
    padding: 15px 30px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.fab-button:hover {
    background-color: #229954;
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.4);
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
    
    .assignment-row {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .assignment-actions {
        width: 100%;
        justify-content: flex-end;
        margin-top: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const confirmed = confirm('Confirm To Delete Project Group?');
            
            if (confirmed) {
                form.submit();
            }
        });
    });

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