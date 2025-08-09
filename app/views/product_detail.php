<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($data['product']['name']) ?> - G4 Mini Mart</title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<header class="px-3">
  <div class="container d-flex justify-content-between align-items-center" style="height: 60px;">
    <a href="/" class="logo text-white text-decoration-none fw-bold fs-4">G4 Mini Mart</a>
    <nav class="main-nav">
      <ul class="nav">
        <li class="nav-item"><a class="nav-link text-white" href="/product">Products</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/order/cart">Cart</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="/admin/dashboard">Admin</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="container my-5">
  <div class="row">
    <!-- Product Image -->
    <div class="col-md-5 text-center">
      <?php if (!empty($data['product']['image'])): ?>
        <img src="/uploads/products/<?= htmlspecialchars($data['product']['image']) ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($data['product']['name']) ?>">
      <?php else: ?>
        <div class="bg-light d-flex align-items-center justify-content-center" style="height:300px;">No Image</div>
      <?php endif; ?>
    </div>

    <!-- Product Details -->
    <div class="col-md-7">
      <h1><?= htmlspecialchars($data['product']['name']) ?></h1>
      <h4 class="text-primary mb-3">$<?= number_format($data['product']['price'], 2) ?></h4>
      <p><?= nl2br(htmlspecialchars($data['product']['description'])) ?></p>

      <div class="mt-4">
        <a href="/order/addToCart/<?= $data['product']['id'] ?>" class="btn btn-success me-2">Add to Cart</a>
        <a href="/product" class="btn btn-secondary">Back to Products</a>
      </div>
    </div>
  </div>
</div>

<footer class="text-center py-4 border-top mt-5">
  &copy; <?= date('Y') ?> G4 Mini Mart. All rights reserved.
</footer>

</body>
</html>
