<!-- app/views/admin/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
<div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
    <h3 class="text-center mb-4">Admin Login</h3>
    <form action="/admin/login" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>
        <button class="btn btn-outline-primary w-100">Login</button>
    </form>
</div>
</body>
</html>
