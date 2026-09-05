<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div style="display: flex; flex-direction: column; gap: 16px; max-width: 500px;">
        <!-- Current Password -->
        <div class="form-group">
            <label class="form-label" for="update_password_current_password">Current Password <span style="color: var(--danger);">*</span></label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-input" autocomplete="current-password" required>
            @if ($errors->updatePassword->has('current_password'))
                <span class="form-error">{{ $errors->updatePassword->first('current_password') }}</span>
            @endif
        </div>

        <!-- New Password -->
        <div class="form-group">
            <label class="form-label" for="update_password_password">New Password <span style="color: var(--danger);">*</span></label>
            <input type="password" id="update_password_password" name="password" class="form-input" autocomplete="new-password" required>
            @if ($errors->updatePassword->has('password'))
                <span class="form-error">{{ $errors->updatePassword->first('password') }}</span>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label class="form-label" for="update_password_password_confirmation">Confirm New Password <span style="color: var(--danger);">*</span></label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-input" autocomplete="new-password" required>
            @if ($errors->updatePassword->has('password_confirmation'))
                <span class="form-error">{{ $errors->updatePassword->first('password_confirmation') }}</span>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 16px; margin-top: 10px;">
            <button type="submit" class="btn-primary">
                <i class="bi bi-key"></i> Update Password
            </button>

            @if (session('status') === 'password-updated')
                <span style="font-size: 0.85rem; color: #059669; font-weight: 600;">
                    <i class="bi bi-check-circle"></i> Password updated.
                </span>
            @endif
        </div>
    </div>
</form>