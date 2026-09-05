<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('WARNING: Are you sure you want to delete your account? This cannot be undone.');">
    @csrf
    @method('delete')

    <div style="display: flex; flex-direction: column; gap: 16px; max-width: 500px;">
        <div class="form-group">
            <label class="form-label" for="password">Please enter your password to confirm deletion <span style="color: var(--danger);">*</span></label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Your current password" required>
            @if ($errors->userDeletion->has('password'))
                <span class="form-error">{{ $errors->userDeletion->first('password') }}</span>
            @endif
        </div>

        <div>
            <button type="submit" class="btn-primary" style="background-color: var(--danger);">
                <i class="bi bi-trash"></i> Permanently Delete Account
            </button>
        </div>
    </div>
</form>