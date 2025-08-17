<?php
// app/controllers/OrderController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/User.php';

/**
 * OrderController
 *
 * Handles cart operations, checkout process, and order confirmation.
 * Works with Product, Order, and User models to manage shopping flow.
 */
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

    /**
     * Redirect /order → /order/cart
     *
     * @return void
     */
    public function index()
    {
        header('Location: /order/cart');
        exit;
    }

    /**
     * Display the shopping cart with total price.
     *
     * @return void
     */
    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $this->view('cart', ['cartItems' => $cart, 'total' => $total]);
    }

    /**
     * Add a product to the cart (increments quantity if already exists).
     *
     * @param int $id Product ID
     * @return void
     */
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

    /**
     * Remove a single product from the cart.
     *
     * @param int $id Product ID
     * @return void
     */
    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /order/cart');
        exit;
    }

    /**
     * Clear the entire cart.
     *
     * @return void
     */
    public function clear()
    {
        unset($_SESSION['cart']);
        header('Location: /order/cart');
        exit;
    }

    /**
     * Show checkout page if cart is not empty.
     *
     * @return void
     */
    public function checkout()
    {
        if (empty($_SESSION['cart'])) {
            echo "Your cart is empty.";
            return;
        }

        $this->view('checkout', ['cart' => $_SESSION['cart']]);
    }

    /**
     * Handle checkout form submission.
     *
     * - Validates required fields
     * - Optionally creates a user account
     * - Creates an order
     * - Clears the cart upon success
     *
     * @return void
     */
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name    = $_POST['name'] ?? '';
            $email   = $_POST['email'] ?? '';
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

                // Auto-login user
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $name;
            }

            $cart = $_SESSION['cart'] ?? [];
            if (empty($cart)) {
                echo "Cart is empty.";
                return;
            }

            // Create order
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

    /**
     * Display confirmation page after order is placed.
     *
     * @param int $id Order ID
     * @return void
     */
    public function confirm($id)
    {
        $this->view('confirm', ['order_id' => $id]);
    }
}
