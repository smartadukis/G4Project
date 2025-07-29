<?php
    // app/controllers/OrderController.php
    require_once __DIR__ . '/../models/Product.php';
    require_once __DIR__ . '/../models/Order.php';
    require_once __DIR__ . '/../models/User.php';

    class OrderController extends Controller
    {
        private $productModel;
        private $orderModel;
        private $userModel;

        public function __construct()
        {
            session_start();
            $this->productModel = new Product();
            $this->orderModel   = new Order();
            $this->userModel    = new User();
        }

        // Redirect /order → /order/cart
        public function index()
        {
            header('Location: /order/cart');
            exit;
        }

        // Display the cart
        public function cart()
        {
            $cart = $_SESSION['cart'] ?? [];
            $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
            $this->view('cart', ['cartItems' => $cart, 'total' => $total]);
        }

        
        public function addToCart($id)
        {
            $product = $this->productModel->findById($id);
            if (!$product) {
                die('Product not found.');
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity']++;
            } else {
                $_SESSION['cart'][$id] = [
                    'id'       => $product['id'],
                    'name'     => $product['name'],
                    'price'    => $product['price'],
                    'quantity' => 1
                ];
            }

            header('Location: /order/cart');
            exit;
        }

        // Remove a single product
        public function removeFromCart($id)
        {
            if (isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
            }
            header('Location: /order/cart');
            exit;
        }

        // Clear the entire cart
        public function clear()
        {
            unset($_SESSION['cart']);
            header('Location: /order/cart');
            exit;
        }


    public function checkout()
    {
        if (empty($_SESSION['cart'])) {
            echo "Your cart is empty.";
            return;
        }

        $this->view('checkout', ['cart' => $_SESSION['cart']]);
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $createAccount = isset($_POST['create_account']);
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($address)) {
                echo "Please fill all required fields.";
                return;
            }

            $userId = null;

            // Handle optional account creation
            if ($createAccount) {
                $existing = $this->userModel->findByEmail($email);
                if ($existing) {
                    echo "Email already registered. Please login or use another email.";
                    return;
                }

                if (empty($password)) {
                    echo "Password is required to create an account.";
                    return;
                }

                $userId = $this->userModel->create($name, $email, $password);

                // Auto-login
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $name;
            }

            $cart = $_SESSION['cart'] ?? [];

            if (empty($cart)) {
                echo "Cart is empty.";
                return;
            }

            $orderId = $this->orderModel->createOrder($userId, $name, $email, $address, $cart);

            if ($orderId) {
                unset($_SESSION['cart']);
                header("Location: /order/confirm/$orderId");
                exit;
            } else {
                echo "Something went wrong while placing your order.";
            }
        }
    }

    public function confirm($id)
    {
        $this->view('confirm', ['order_id' => $id]);
    }
}
