<!-- app/views/admin/manage_products.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
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
    <h1 class="mb-4">Manage Products</h1>

    <a href="/admin/addProduct" class="btn btn-primary mb-3">Add New Product</a>

    <?php if (!empty($data['products'])): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price ($)</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= number_format($product['price'], 2) ?></td>
                        <td>
                            <?php if ($product['image']): ?>
                                <img src="/uploads/products/<?= $product['image'] ?>" alt="Product Image" width="60">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td>
                          <a href="/product/show/<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm">View</a>
                            <a href="/admin/editProduct/<?= $product['id'] ?>" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <a href="/admin/deleteProduct/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No products found.</div>
    <?php endif; ?>

    <a href="/admin/dashboard" class="btn btn-secondary mt-4">Back to Dashboard</a>
</div>
</body>
</html>
