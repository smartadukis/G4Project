<!DOCTYPE html>
<html>
<head>
  <title>Your Cart</title>
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
  <?php if (empty($data['cartItems'])): ?>
    <div class="text-center py-5">
      <div class="mb-4">
        <i class="bi bi-cart fs-1 text-secondary"></i>
      </div>
      <h4 class="mb-2">Your cart is empty</h4>
      <p class="text-muted mb-4">Add some products to get started!</p>
      <a href="/product" class="btn btn-primary">Start Shopping</a>
    </div>
  <?php else: ?>
    <div class="row">
      <!-- Cart Items -->
      <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Your Items (<?= count($data['cartItems']) ?>)</strong>
            <a href="/order/clear" class="btn btn-sm btn-danger">Clear Cart</a>
          </div>
          <div class="card-body">
            <?php foreach ($data['cartItems'] as $item): 
              $subtotal = $item['price'] * $item['quantity'];
            ?>
              <div class="d-flex align-items-center border-bottom py-3">
                <div style="width: 60px; height: 60px; background: #f0f0f0; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                  <?php if (!empty($item['image'])): ?>
                    <img src="/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="max-width:100%; max-height:100%;">
                  <?php else: ?>
                    <span class="text-muted small">No Image</span>
                  <?php endif; ?>
                </div>
                <div class="ms-3 flex-grow-1">
                  <h6 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                  <small class="text-muted">Unit Price: $<?= number_format($item['price'], 2) ?></small>
                </div>
                <div class="text-end me-3">
                  Qty: <?= $item['quantity'] ?>
                </div>
                <div class="text-end me-3">
                  $<?= number_format($subtotal, 2) ?>
                </div>
                <a href="/order/removeFromCart/<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger">&times;</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header">
            <strong>Order Summary</strong>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
              <span>Subtotal</span>
              <strong>$<?= number_format($data['total'], 2) ?></strong>
            </div>
            <a href="/checkout" class="btn btn-primary w-100 mb-2">Proceed to Checkout</a>
            <a href="/product" class="btn btn-outline-secondary w-100">Continue Shopping</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
