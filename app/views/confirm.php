<!-- app/views/confirm.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
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
    <h1>Thank You!</h1>
    <p>Your order has been placed successfully.</p>
    <a href="/product" class="btn btn-outline-secondary">Back to Products</a>
</div>
</body>
</html>
