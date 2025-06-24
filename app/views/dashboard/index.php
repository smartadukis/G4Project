<!-- app/views/dashboard/index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-3">Welcome, <?php echo htmlspecialchars($data['username']); ?>!</h1>

    <p>Your recent orders:</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data['orders'] as $order): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td>$<?php echo number_format($order['total'], 2); ?></td>
                <td><?php echo $order['date']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/auth/logout" class="btn btn-danger">Logout</a>
</div>

</body>
</html>
