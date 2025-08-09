<!-- app/views/home.php -->
<!DOCTYPE html>
<html>
<head>
    <title>G4 Mini Mart - Home</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<header class="px-3">
  <div class="container d-flex justify-content-between align-items-center" style="height: 60px;">
    <a href="/" class="logo text-white text-decoration-none fw-bold fs-4">G4 Mini Mart</a>

    <nav class="main-nav">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="/product">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/order/cart">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="/admin/dashboard">Admin</a>
        </li>
      </ul>
    </nav>
  </div>
</header>


<div class="container">
    <h1 class="mb-4">Welcome to G4 Mini Mart</h1>
    <p>This is the homepage. Browse our products here.</p>
    <a href="/product" class="btn btn-primary">View Products</a>
</div>
</body>
</html>
