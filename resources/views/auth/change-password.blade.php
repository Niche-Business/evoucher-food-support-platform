@extends('layouts.dashboard')
@section('title', 'Change Password')
@section('page-title', 'Change Password')
@section('content')

<div class="page-hd">
  <h1>Change Password</h1>
  <p>Update your account password. Choose a strong password of at least 8 characters.</p>
</div>

@if(session('success'))
<div class="alert-success mb-4">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert-danger mb-4">
  <ul class="mb-0">
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<div class="card" style="max-width:480px">
  <div class="card-hd">
    <div class="card-title"><i class="fas fa-lock text-green-600"></i> Change Password</div>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('password.change.update') }}">
      @csrf @method('PUT')

      <div class="mb-4">
        <label class="form-label">Current Password *</label>
        <input type="password" name="current_password" class="form-input" placeholder="Enter your current password" required autocomplete="current-password">
        @error('current_password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label class="form-label">New Password *</label>
        <input type="password" name="password" class="form-input" placeholder="Minimum 8 characters" required autocomplete="new-password">
        @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label class="form-label">Confirm New Password *</label>
        <input type="password" name="password_confirmation" class="form-input" placeholder="Re-enter new password" required autocomplete="new-password">
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
        <i class="fas fa-save mr-2"></i> Update Password
      </button>
    </form>
  </div>
</div>

@endsection
