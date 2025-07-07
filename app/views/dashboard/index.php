<!-- app/views/dashboard/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Customer') ?></h2>
    <h4 class="mt-4">Your Orders</h4>

    <?php if (empty($data['orders'])): ?>
        <p>You haven't made any orders yet.</p>
    <?php else: ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price ($)</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data['orders'] as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                    <td><?= htmlspecialchars($order['name']) ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td>$<?= number_format($order['price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="/" class="btn btn-secondary mt-4">Back to Store</a>
</div>
</body>
</html>
