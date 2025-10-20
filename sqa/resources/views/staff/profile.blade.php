@extends('layouts.staff')

@section('title', 'Staff Profile')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i> My Profile</h4>
                    <a href="{{ route('staff.dashboard') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="row align-items-start">
                        <!-- Profile Picture Section -->
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="position-relative">
                                <img src="{{ $staff->photo ? asset('storage/'.$staff->photo) : asset('images/default-avatar.png') }}"
                                     class="rounded-circle border shadow-sm"
                                     width="130" height="130" alt="Profile Picture">

                                <form action="{{ route('staff.profile.photo') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                    @csrf
                                    <input type="file" name="photo" class="form-control form-control-sm mb-2" accept="image/*">
                                    <button class="btn btn-outline-primary btn-sm w-100">Upload</button>
                                </form>
                            </div>
                        </div>

                        <!-- Profile Information -->
                        <div class="col-md-9">
                            <form action="{{ route('staff.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Identification Number</label>
                                        <input type="text" name="identification_number" class="form-control" value="{{ old('identification_number', $staff->identification_number) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="">-- Select Gender --</option>
                                            <option value="Male" {{ $staff->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $staff->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ $staff->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $staff->phone) }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Address</label>
                                        <textarea name="address" rows="2" class="form-control">{{ old('address', $staff->address) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" value="{{ $staff->user->email }}" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Role</label>
                                        <input type="text" class="form-control" value="{{ $staff->role->name }}" readonly>
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Staff ID</label>
                                        <input type="text" name="staff_id" class="form-control" value="{{ old('staff_id', $staff->staff_id) }}" readonly>
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
