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
    <p>Here is a list of our available items.</p>

    <div class="list-group">
        <?php foreach ($data['products'] as $product): ?>
            <a href="/product/show/<?php echo $product['id']; ?>" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo htmlspecialchars($product['name']); ?></h5>
                    <small>$<?php echo number_format($product['price'], 2); ?></small>
                </div>
                <p class="mb-1">Click to view more details about this amazing product.</p>
            </a>
        <?php endforeach; ?>
    </div>

    <a href="/" class="btn btn-secondary mt-4">Back to Home</a>
</div>

</body>
</html>

