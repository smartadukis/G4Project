<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <h2>Your Shopping Cart</h2>

    <?php if (empty($data['cartItems'])): ?>
        <div class="alert alert-warning">Your cart is empty.</div>
        <a href="/product" class="btn btn-primary">Browse Products</a>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['cartItems'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₦<?php echo number_format($item['price'], 2); ?></td>
                        <td>₦<?php echo number_format($item['subtotal'], 2); ?></td>
                        <td>
                            <a href="/order/removeFromCart/<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2"><strong>₦<?php echo number_format($data['total'], 2); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <a href="/product" class="btn btn-outline-secondary">Continue Shopping</a>
        <a href="/checkout" class="btn btn-success">Proceed to Checkout</a>
        <a href="/order/clear" class="btn btn-danger">Clear Cart</a>
    <?php endif; ?>
</div>

</body>
</html>
