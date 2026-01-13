<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Create Your Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .signup-container {
            max-width: 700px;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="signup-container w-100">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                    <h2 class="mb-1" style="font-weight:700;">Create Account</h2>
                    <p class="mb-0 opacity-75">Join us today and get started</p>
                </div>

                <!-- Body -->
                <div class="card-body" style="padding: 2rem;">
                    <form action="{{ route('user.signup.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Profile Picture Upload -->
                        <div class="text-center mb-4">
                            <div class="d-inline-block position-relative">
                                <div id="profilePreview"
                                    class="rounded-circle bg-light border border-3 d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 120px; height: 120px; overflow: hidden;">
                                    <i class="fas fa-user fa-3x text-secondary"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="profilePic" class="btn btn-primary btn-sm">
                                    <i class="fas fa-camera me-2"></i>Upload Photo
                                </label>
                                <input type="file" name="profile_pic" id="profilePic" accept="image/*"
                                    class="d-none">
                                <div class="form-text">JPG, PNG or GIF (Max 2MB)</div>
                            </div>
                        </div>

                        <!-- Row 1: Name and Email -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter your full name" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Enter email"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Phone and Password -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Enter phone number" required>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Create a password" required>
                                    <button class="btn btn-dark" type="button" id="togglePassword" style="width: 46px;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-text text-small">Must be at least 8 characters</div>
                            </div>
                        </div>

                        <!-- Confirm Password (Full Width) -->
                        {{-- <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> --}}

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Create Account
                            </button>
                            <small class="text-muted text-center d-block mt-2">
                                By creating an account, you agree to our
                                <a href="#" class="text-decoration-none">Terms and Conditions</a>.
                            </small>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <p class="text-muted mb-0">
                                Already have an account? <a href="{{ route('user.login.view') }}"
                                    class="text-decoration-none fw-semibold">Sign In</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Profile picture preview
        document.getElementById('profilePic').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').innerHTML =
                        '<img src="' + e.target.result +
                        '" alt="Profile" class="w-100 h-100" style="object-fit: cover;">';
                }
                reader.readAsDataURL(file);
            }
        });

        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
