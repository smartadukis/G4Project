<!-- app/views/admin/edit_product.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Edit Product</h1>

    <form action="/admin/editProduct/<?= $data['product']['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['product']['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price (₦)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="<?= $data['product']['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($data['product']['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Product Image</label><br>
            <?php if ($data['product']['image']): ?>
                <img src="/uploads/products/<?= $data['product']['image'] ?>" width="100" class="mb-2"><br>
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary">Update Product</button>
        <a href="/admin/manageProducts" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
