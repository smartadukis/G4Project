<!-- app/views/dashboard/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Orders - G4 Mini Mart</title>
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

<main class="container my-5">
  <div class="dashboard-hero">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="mb-1">Welcome back, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Customer') ?></h2>
        <div class="order-meta">Here you can review your past orders. Secure, simple and quick.</div>
      </div>
      <div class="text-end">
        <div class="text-muted small">Member since</div>
        <div class="fw-bold"><?= isset($_SESSION['user_created_at']) ? date('M Y', strtotime($_SESSION['user_created_at'])) : '—' ?></div>
      </div>
    </div>
  </div>

  <?php if (empty($data['orders'])): ?>
    <!-- Empty state -->
    <div class="text-center py-5">
      <img src="/assets/images/empty-orders.svg" alt="No orders" style="max-width:220px; opacity:0.9;">
      <h4 class="mt-4">No orders yet</h4>
      <p class="text-muted">Looks like you haven't placed an order. Start browsing our products!</p>
      <a href="/product" class="btn btn-primary">Shop Products</a>
    </div>
  <?php else: ?>
    <div class="mb-3 d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Your Orders (<?= count($data['orders']) ?>)</h4>
      <a href="/order/cart" class="btn btn-outline-primary btn-sm">View Cart</a>
    </div>

    <div class="row g-4">
      <!-- Left: Orders list -->
      <div class="col-lg-8">
        <?php foreach ($data['orders'] as $orderIndex => $order): 
          // calculate order total
          $orderTotal = 0;
          foreach ($order['items'] as $it) {
            $orderTotal += ($it['price'] * $it['quantity']);
          }
          $panelId = 'orderCollapse' . $orderIndex;
        ?>
          <div class="card order-card mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <div class="d-flex align-items-center gap-3">
                    <strong>Order #<?= htmlspecialchars($order['id']) ?></strong>
                    <span class="ms-2 text-muted small"><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></span>
                    <span class="badge ms-3 order-badge">Paid</span>
                  </div>
                  <div class="text-muted small mt-1">Items: <?= count($order['items']) ?> — Total: $<?= number_format($orderTotal, 2) ?></div>
                </div>

                <div class="d-flex gap-2">
                  <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#<?= $panelId ?>" aria-expanded="false" aria-controls="<?= $panelId ?>">
                    Details
                  </button>
                  <a href="/order/confirm/<?= $order['id'] ?>" class="btn btn-sm btn-primary">View Receipt</a>
                </div>
              </div>

              <div class="collapse mt-3" id="<?= $panelId ?>">
                <div class="mt-2">
                  <?php foreach ($order['items'] as $item): 
                    $itemTotal = $item['price'] * $item['quantity'];
                  ?>
                    <div class="order-item">
                      <div class="item-thumb">
                        <!-- if product image exists, show it; otherwise placeholder -->
                        <?php if (!empty($item['image'])): ?>
                          <img src="/uploads/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="max-width:100%; max-height:100%; object-fit:cover;">
                        <?php else: ?>
                          <span class="text-muted">No image</span>
                        <?php endif; ?>
                      </div>

                      <div class="flex-grow-1">
                        <div class="fw-semibold"><?= htmlspecialchars($item['name']) ?></div>
                        <div class="text-muted small"><?= htmlspecialchars($item['description'] ?? '') ?></div>
                      </div>

                      <div class="text-end" style="min-width:120px">
                        <div>Qty: <strong><?= (int)$item['quantity'] ?></strong></div>
                        <div class="fw-bold mt-1">$<?= number_format($itemTotal, 2) ?></div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-end mt-3">
                  <div class="order-summary text-end">
                    <div class="small text-muted">Order Total</div>
                    <div class="fs-5 fw-bold">$<?= number_format($orderTotal, 2) ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Right: Quick Account / Summary Box -->
      <div class="col-lg-4">
        <div class="order-summary mb-4">
          <h6 class="mb-3">Account</h6>
          <p class="mb-1"><strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Customer') ?></strong></p>
          <p class="text-muted small mb-2"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>
          <a href="/auth/logout" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>

        <div class="order-summary">
          <h6 class="mb-3">Quick Links</h6>
          <ul class="list-unstyled mb-0">
            <li><a href="/product">Browse Products</a></li>
            <li><a href="/order/cart">View Cart</a></li>
            <li><a href="/dashboard">Order History</a></li>
          </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
