@extends('layouts.guest')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background-image: url('{{ asset('images/HRStatix.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .page-container {
        min-height: 100vh;
        display: flex;
        justify-content: flex-end;
        padding-right: 8%;
        padding-top: 5%;
    }

    .login-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 380px;
        height: 100%;
        margin-top: 100px;
    }

    .login-form-container h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        color: #555;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: none;
        background: #F0F2F5;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .password-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .reset-link {
        color: #4154f1;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .remember-me {
        margin: 1rem 0;
        display: flex;
        align-items: center;
    }

    .remember-me input[type="checkbox"] {
        margin-right: 0.5rem;
    }

    .login-button {
        width: 100%;
        padding: 0.75rem;
        background: #4154f1;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .login-button:hover {
        background: #3644d0;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
</style>

<div class="page-container">
    <div class="login-container">
        <div class="login-form-container">
            <h2>Login</h2>
            
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" 
                           placeholder="admin@example.com"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="password-label">
                        <label for="password">Password</label>
                        <a href="#" class="reset-link">Reset Password</a>
                    </div>
                    <input type="password" id="password" name="password" 
                           placeholder="••••••••"
                           required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-me">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember Password
                    </label>
                </div>

                @if (session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif

                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --primary-blue: #4461F2;
    --primary-hover: #3451E2;
    --text-dark: #333;
    --text-light: #666;
    --border-color: #E5E7EB;
    --error-color: #EF4444;
}

/* Left Section */
.left-section {
    flex: 1;
    background: var(--primary-blue);
    padding: 3rem;
    position: relative;
    display: flex;
    align-items: flex-start;
    overflow: hidden;
}

.left-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    transform: skewY(-20deg);
    transform-origin: top right;
}

.left-content {
    position: relative;
    z-index: 1;
    color: white;
    max-width: 400px;
    padding-top: 2rem;
}

.left-content h1 {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.left-content p {
    font-size: 1rem;
    opacity: 0.9;
    line-height: 1.6;
}

/* Right Section */
.right-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    background: white;
}

.login-form-container h2 {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.password-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.reset-link {
    font-size: 0.875rem;
    color: var(--primary-blue);
    text-decoration: none;
    transition: color 0.2s;
}

.reset-link:hover {
    color: var(--primary-hover);
}

.form-group input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-dark);
    transition: all 0.2s;
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(68, 97, 242, 0.1);
}

.form-group input::placeholder {
    color: #9CA3AF;
}

.remember-me {
    margin-bottom: 1.5rem;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-light);
}

.checkbox-container input[type="checkbox"] {
    width: 1rem;
    height: 1rem;
    border-radius: 0.25rem;
    border: 1px solid var(--border-color);
    cursor: pointer;
}

.login-button {
    width: 100%;
    padding: 0.875rem;
    background: var(--primary-blue);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.login-button:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.login-button:active {
    transform: translateY(1px);
}

.error-message {
    display: block;
    color: var(--error-color);
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.alert-error {
    padding: 0.75rem 1rem;
    background: #FEF2F2;
    color: var(--error-color);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .login-container {
        flex-direction: column;
    }
    
    .left-section {
        padding: 2rem;
        min-height: 200px;
    }
    
    .right-section {
        padding: 2rem;
    }
    
    .left-content h1 {
        font-size: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.password-toggle');
    
    if (toggleButton && passwordInput) {
        toggleButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleButton.querySelector('i').classList.toggle('fa-eye');
            toggleButton.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endpush
