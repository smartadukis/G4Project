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
    <a href="/admin/addProduct" class="btn btn-success mb-3">Add New Product</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th><th>Price</th><th>Image</th><th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['products'] as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>$<?= number_format($product['price'], 2) ?></td>
                <td>
                    <?php if ($product['image']): ?>
                        <img src="/uploads/products/<?= $product['image'] ?>" width="50">
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Edit to be added later -->
                    <a href="/admin/deleteProduct/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>
