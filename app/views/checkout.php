<!-- app/views/checkout.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function togglePasswordField() {
            const checkbox = document.getElementById('create_account');
            const pwdField = document.getElementById('password_field');
            pwdField.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
</head>
<body class="p-4">
<div class="container">
    <h1>Checkout</h1>
    <form action="/order/processCheckout" method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="<?= $_SESSION['user_name'] ?? '' ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="create_account" name="create_account" onclick="togglePasswordField()">
            <label class="form-check-label" for="create_account">Create an account?</label>
        </div>

        <div class="mb-3" id="password_field" style="display:none;">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Place Order</button>
    </form>
</div>
</body>
</html>
