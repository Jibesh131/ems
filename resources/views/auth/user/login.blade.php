<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Welcome Back</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .login-container {
            max-width: 450px;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="login-container w-100">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                    <h2 class="mb-1" style="font-weight:700;">Welcome Back</h2>
                    <p class="mb-0 opacity-75">Sign in to continue</p>
                </div>

                <!-- Body -->
                <div class="card-body" style="padding: 2.5rem;">
                    <form action="{{ route('user.login.post') }}" method="POST">
                        @csrf
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" placeholder="Enter your password" required>
                                <button class="btn btn-dark" type="button" id="togglePassword" style="width: 46px;">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none">Forgot Password?</a>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Sign In
                            </button>
                        </div>

                        <!-- Sign Up Link -->
                        <div class="text-center mt-4">
                            <p class="text-muted mb-0">
                                Don't have an account? <a href="{{ route('user.signup.view') }}"
                                    class="text-decoration-none fw-semibold">Sign Up</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>