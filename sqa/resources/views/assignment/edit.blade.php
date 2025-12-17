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
                <h2 class="mb-0">ASSIGNMENT & SUBMISSION {{ strtoupper($assignment->course->name ?? 'MATHEMATICS') }}</h2>
                <button class="btn btn-outline-primary rounded-pill px-4">
                    Notifications
                </button>
            </div>
        </div>

        {{-- Form Container --}}
        <div class="form-wrapper">
            <form action="{{ route('assignments.update', $assignment->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="assignment-form">
                @csrf
                @method('PUT')

                {{-- Title Field --}}
                <div class="form-group">
                    <label class="form-label">TITLE :</label>
                    <input type="text" 
                           class="form-input @error('title') is-invalid @enderror" 
                           name="title" 
                           value="{{ old('title', $assignment->title) }}"
                           placeholder="Assignment 1"
                           required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Date and Time Fields (Side by Side) --}}
                <div class="row-fields">
                    <div class="form-group half-width">
                        <label class="form-label">DUEDATE :</label>
                        <input type="date" 
                               class="form-input @error('due_date') is-invalid @enderror" 
                               name="due_date" 
                               value="{{ old('due_date', $assignment->due_date->format('Y-m-d')) }}"
                               required>
                        @error('due_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group half-width">
                        <label class="form-label">TIME :</label>
                        <input type="time" 
                               class="form-input @error('due_time') is-invalid @enderror" 
                               name="due_time" 
                               value="{{ old('due_time', date('H:i', strtotime($assignment->due_time))) }}"
                               required>
                        @error('due_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description Field --}}
                <div class="form-group">
                    <label class="form-label">DESCRIPTION :</label>
                    <textarea class="form-textarea @error('description') is-invalid @enderror" 
                              name="description" 
                              rows="5"
                              required>{{ old('description', $assignment->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- File Upload Field with Current File Display --}}
                <div class="form-group">
                    <label class="form-label">FILE UPLOAD :</label>
                    
                    {{-- Current File Display --}}
                    @if($assignment->file_path)
                        <div class="current-file-box" id="current-file">
                            <div class="pdf-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-lines">
                                    <div class="line"></div>
                                    <div class="line"></div>
                                    <div class="line"></div>
                                </div>
                            </div>
                            <a href="{{ route('assignments.download', $assignment->id) }}" 
                               class="download-btn"
                               title="Download file">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                        <p class="file-note">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                Current file: {{ basename($assignment->file_path) }}. Upload a new file to replace it.
                            </small>
                        </p>
                    @endif
                    
                    {{-- New File Upload Box --}}
                    <div class="file-upload-box" onclick="document.getElementById('file-input').click()">
                        <div id="file-placeholder" class="file-placeholder">
                            <p class="mb-0 text-muted">
                                {{ $assignment->file_path ? 'Click to upload new file...' : 'Click to select file...' }}
                            </p>
                        </div>
                        <div id="file-display" class="file-display" style="display: none;">
                            <i class="bi bi-file-earmark"></i>
                            <span id="file-name-text"></span>
                        </div>
                    </div>
                    <input type="file" 
                           id="file-input" 
                           name="file" 
                           accept=".pdf,.doc,.docx,.zip"
                           class="d-none @error('file') is-invalid @enderror">
                    @error('file')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Save Button --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn-save">
                        Save
                    </button>
                </div>
            </form>
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

/* Form Wrapper */
.form-wrapper {
    max-width: 700px;
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Form Groups */
.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.form-input {
    width: 100%;
    padding: 12px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 0.95rem;
    transition: all 0.3s;
}

.form-input:focus {
    outline: none;
    border-color: #3498db;
}

.form-textarea {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    font-size: 0.95rem;
    resize: vertical;
    transition: all 0.3s;
}

.form-textarea:focus {
    outline: none;
    border-color: #3498db;
}

/* Row Fields (Date and Time) */
.row-fields {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.half-width {
    flex: 1;
    margin-bottom: 0 !important;
}

/* Current File Display (Picture 9 style) */
.current-file-box {
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 20px;
    background-color: #fafafa;
    position: relative;
}

.pdf-icon {
    background-color: #e74c3c;
    width: 60px;
    height: 70px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pdf-icon i {
    font-size: 2rem;
    color: white;
}

.file-info {
    flex-grow: 1;
}

.file-lines {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.line {
    height: 3px;
    background-color: #ddd;
    border-radius: 2px;
}

.line:nth-child(1) {
    width: 80%;
}

.line:nth-child(2) {
    width: 60%;
}

.line:nth-child(3) {
    width: 70%;
}

.download-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 35px;
    height: 35px;
    background-color: #3498db;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s;
}

.download-btn:hover {
    background-color: #2980b9;
    transform: scale(1.1);
    color: white;
}

.file-note {
    margin-bottom: 15px;
}

/* File Upload Box */
.file-upload-box {
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    background-color: #fafafa;
}

.file-upload-box:hover {
    border-color: #3498db;
    background-color: #f0f8ff;
}

.file-placeholder p {
    color: #999;
}

.file-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.file-display i {
    font-size: 1.5rem;
    color: #3498db;
}

/* Save Button */
.btn-save {
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 25px;
    padding: 12px 50px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-save:hover {
    background-color: #1a252f;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.error-message {
    color: #e74c3c;
    font-size: 0.85rem;
    margin-top: 5px;
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
    
    .row-fields {
        flex-direction: column;
    }
    
    .half-width {
        margin-bottom: 25px !important;
    }
}
</style>

<script>
// File upload handling
document.getElementById('file-input').addEventListener('change', function(event) {
    const filePlaceholder = document.getElementById('file-placeholder');
    const fileDisplay = document.getElementById('file-display');
    const fileNameText = document.getElementById('file-name-text');
    const hasCurrentFile = {{ $assignment->file_path ? 'true' : 'false' }};
    
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const fileName = file.name;
        
        // Show confirmation if replacing existing file
        if (hasCurrentFile) {
            const confirmed = confirm('You are about to replace the existing file. The old file will be permanently deleted. Continue?');
            if (!confirmed) {
                this.value = '';
                return;
            }
        }
        
        fileNameText.textContent = fileName;
        filePlaceholder.style.display = 'none';
        fileDisplay.style.display = 'flex';
    } else {
        filePlaceholder.style.display = 'block';
        fileDisplay.style.display = 'none';
    }
});

// Form validation
document.getElementById('assignment-form').addEventListener('submit', function(event) {
    const title = document.querySelector('[name="title"]');
    const dueDate = document.querySelector('[name="due_date"]');
    const dueTime = document.querySelector('[name="due_time"]');
    const description = document.querySelector('[name="description"]');
    
    let isValid = true;
    
    if (title.value.trim() === '') isValid = false;
    if (dueDate.value === '') isValid = false;
    if (dueTime.value === '') isValid = false;
    if (description.value.trim() === '') isValid = false;
    
    if (!isValid) {
        event.preventDefault();
        alert('Please fill in all required fields (TITLE, DUEDATE, TIME, DESCRIPTION)');
    }
});
</script>
@endsection