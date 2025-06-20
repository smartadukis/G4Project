<!-- app/views/checkout.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Checkout</h1>
    <form>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea id="address" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
</body>
</html>
