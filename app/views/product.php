
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->

    <!-- app/views/product.php [ADD TO CART BUTTON]-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>G4 Mini Mart - <?= htmlspecialchars($data['pageTitle']) ?></title>
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



<main class="container">
  <h1 class="page-title"><?= htmlspecialchars($data['pageTitle']) ?></h1>

  <?php if (empty($data['products'])): ?>
    <div class="alert alert-warning">No products found.</div>
  <?php else: ?>
    <div class="product-grid">
      <?php foreach ($data['products'] as $p): ?>
        <div class="card">
          <img
            src="/uploads/products/<?= htmlspecialchars($p['image']) ?>"
            alt="<?= htmlspecialchars($p['name']) ?>"
          >
          <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($p['name']) ?></h2>
            <p class="card-text">$<?= number_format($p['price'], 2) ?></p>
            <div class="card-actions">
              <a href="/product/show/<?= $p['id'] ?>" class="btn btn-outline-primary btn-sm">View</a>
              <a href="/order/addToCart/<?= $p['id'] ?>"
                class="btn btn-outline-primary btn-sm">
                Add to Cart
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <a href="/" class="btn btn-secondary mt-4">Back to Home</a>
</main>

<footer>
  &copy; <?= date('Y') ?> G4 Mini Mart. All rights reserved.
</footer>

</body>
</html>
