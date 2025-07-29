<!-- app/views/dashboard/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>

    <?php if (empty($data['orders'])): ?>
        <p>You haven't made any orders yet.</p>
    <?php else: ?>
        <?php foreach ($data['orders'] as $order): ?>
            <div class="card mb-4">
                <div class="card-header">
                    Order $<?= $order['id'] ?> on <?= date('M d, Y H:i', strtotime($order['created_at'])) ?>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($order['items'] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                                Qty: <?= $item['quantity'] ?>
                            </div>
                            <div>
                                $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="/product" class="btn btn-secondary">Back to Store</a>
</div>

</body>
</html>
