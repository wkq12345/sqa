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
                <h2 class="mb-0">ASSIGNMENT & SUBMISSION</h2>
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

        {{-- Course Cards --}}
        <div class="courses-container">
            @forelse($courses as $course)
                <div class="course-card" onclick="window.location='{{ route('assignments.list', $course->id) }}'">
                    <h5>{{ strtoupper($course->name) }}</h5>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">No courses available</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Sidebar Styles */
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

/* Course Cards Container */
.courses-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

/* Course Card */
.course-card {
    background: white;
    border-radius: 30px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.course-card h5 {
    color: #2c3e50;
    font-weight: 600;
    margin: 0;
    font-size: 1.1rem;
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
    
    .courses-container {
        grid-template-columns: 1fr;
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