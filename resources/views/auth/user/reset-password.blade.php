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
                    <h2 class="mb-1" style="font-weight:700;">Reset Password</h2>
                </div>

                <!-- Body -->
                <div class="card-body" style="padding: 2.5rem;">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $email }}" placeholder="Enter your email" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Sand mail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
