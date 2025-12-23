@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i> My Profile</h4>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="row align-items-start">
                        <!-- Profile Picture Section -->
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="position-relative">
                                  <img src="{{ $admin->photo ? asset('storage/'.$admin->photo) : asset('images/default-avatar.png') }}"
                                     class="rounded-circle border shadow-sm"
                                     width="130" height="130" alt="Profile Picture">

                                <form action="{{ route('admin.profile.photo') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                    @csrf
                                    <input type="file" name="photo" class="form-control form-control-sm mb-2" accept="image/*">
                                    <button class="btn btn-outline-primary btn-sm w-100">Upload</button>
                                </form>
                            </div>
                        </div>

                        <!-- Profile Information -->
                        <div class="col-md-9">
                            <form action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Identification Number</label>
                                        <input type="text" name="identification_number" class="form-control" value="{{ old('identification_number', $admin->identification_number) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="">-- Select Gender --</option>
                                            <option value="Male" {{ $admin->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $admin->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone) }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Address</label>
                                        <textarea name="address" rows="2" class="form-control">{{ old('address', $admin->address) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" value="{{ $admin->user->email }}" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Role</label>
                                        <input type="text" class="form-control" value="{{ $admin->role->name }}" readonly>
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Admin ID</label>
                                        <input type="text" name="admin_id" class="form-control" value="{{ old('admin_id', $admin->admin_id) }}" readonly>
                                    </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
