@extends('layouts.pharmacy')

@section('title', 'Profile Settings')
@section('page-title', 'Account & Profile Settings')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <style>
        .profile-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
            max-width: 750px;
        }
        .profile-section {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .profile-header {
            margin-bottom: 18px;
            border-bottom: 1px solid var(--slate-100);
            padding-bottom: 12px;
        }
        .profile-header h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--slate-900);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .profile-header p {
            font-size: 0.82rem;
            color: var(--slate-500);
            margin-top: 4px;
        }
    </style>
@endsection

@section('content')

<div class="profile-container">

    <!-- 1. Profile Information -->
    <div class="profile-section">
        <div class="profile-header">
            <h3><i class="bi bi-person-circle" style="color: var(--primary);"></i> Profile Information</h3>
            <p>Update your account's name and login email address.</p>
        </div>
        <div>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- 2. Update Password -->
    <div class="profile-section">
        <div class="profile-header">
            <h3><i class="bi bi-shield-lock" style="color: var(--warning);"></i> Change Password</h3>
            <p>Ensure your account is using a secure password to protect pharmacy records.</p>
        </div>
        <div>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- 3. Delete Account -->
    <div class="profile-section" style="border-color: #fee2e2; background: #fffdfd;">
        <div class="profile-header" style="border-color: #fee2e2;">
            <h3 style="color: var(--danger);"><i class="bi bi-trash"></i> Delete Account</h3>
            <p>Permanently remove your staff account and personal profile data.</p>
        </div>
        <div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

@endsection