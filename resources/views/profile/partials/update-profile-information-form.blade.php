<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div style="display: flex; flex-direction: column; gap: 16px; max-width: 500px;">
        <!-- Name -->
        <div class="form-group">
            <label class="form-label" for="name">Full Name <span style="color: var(--danger);">*</span></label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @if ($errors->has('name'))
                <span class="form-error">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <!-- Email -->
        <div class="form-group">
            <label class="form-label" for="email">Email Address <span style="color: var(--danger);">*</span></label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @if ($errors->has('email'))
                <span class="form-error">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <!-- Role (Readonly info) -->
        <div class="form-group">
            <label class="form-label">Account Role</label>
            <input type="text" class="form-input" value="{{ strtoupper($user->role) }}" style="background-color: var(--slate-100); font-weight: 700; color: var(--slate-600);" readonly>
        </div>

        <div style="display: flex; align-items: center; gap: 16px; margin-top: 10px;">
            <button type="submit" class="btn-primary">
                <i class="bi bi-check2-circle"></i> Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <span style="font-size: 0.85rem; color: #059669; font-weight: 600;">
                    <i class="bi bi-check-circle"></i> Saved successfully.
                </span>
            @endif
        </div>
    </div>
</form>