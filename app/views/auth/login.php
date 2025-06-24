<!-- app/views/auth/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Login</h1>
   <!-- app/views/auth/login.php -->
<form action="/auth/loginUser" method="POST">
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>
    <p class="mt-3">Don't have an account? <a href="/auth/register">Register here</a>.</p>
    <p class="mt-3"><a href="/dashboard">Go to Dashboard</a></p>
</div>
</body>
</html>
