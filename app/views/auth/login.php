<!-- app/views/auth/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
<div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4">User Login</h3>
    <form action="/auth/loginUser" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center">Don't have an account? <a href="/auth/register">Register here</a>.</p>
    <p class="mt-2 text-center"><a href="/dashboard">Go to Dashboard</a></p>
</div>
</body>
</html>

