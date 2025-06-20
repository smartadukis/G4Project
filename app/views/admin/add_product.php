<!-- app/views/admin/add_product.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Add New Product</h1>
    <form enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" class="form-control">
        </div>
        <button class="btn btn-success">Save Product</button>
    </form>
</div>
</body>
</html>
