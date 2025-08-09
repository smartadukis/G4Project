<!-- app/views/admin/add_product.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
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
    <h2>Add New Product</h2>
    <form action="/admin/addProduct" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name:</label>
            <input name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price:</label>
            <input name="price" type="number" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Image:</label>
            <input name="image" type="file" class="form-control">
        </div>
        <button class="btn btn-success">Add Product</button>
        <a href="/admin/dashboard" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
