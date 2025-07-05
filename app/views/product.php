<!-- app/views/product.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G4 Mini Mart - <?php echo htmlspecialchars($data['pageTitle']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4"><?php echo htmlspecialchars($data['pageTitle']); ?></h1>

    <?php if (empty($data['products'])): ?>
        <div class="alert alert-warning">No products found.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($data['products'] as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="/uploads/products/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text text-muted">$<?php echo number_format($product['price'], 2); ?></p>
                            <a href="/product/show/<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm">View</a>
                            <a href="/order/addToCart/<?php echo $product['id']; ?>" class="btn btn-success btn-sm">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="/" class="btn btn-secondary mt-4">Back to Home</a>
</div>

</body>
</html>
