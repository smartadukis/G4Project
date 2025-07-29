<!-- app/views/admin/dashboard.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Admin Dashboard</h1>
    <a href="/admin/addProduct" class="btn btn-success me-3 mb-3">Add New Product</a>
    <a href="/admin/manageProducts" class="btn btn-info mb-3">Manage Products</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Price ($)</th>
            <th>Image</th>
            <!-- <th>Actions</th> -->
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['products'] as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td>
                    <?php if ($product['image']): ?>
                        <img src="/uploads/products/<?= $product['image'] ?>" width="50" height="50" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php endif; ?>
                </td>
                <!-- <td>
                    <a href="/admin/editProduct/<?= $product['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                    <a href="/admin/deleteProduct/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td> -->
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <!-- <a href="/admin/logout" class="btn btn-outline-danger btn-sm float-end">Logout</a> -->


</div>
</body>
</html>
