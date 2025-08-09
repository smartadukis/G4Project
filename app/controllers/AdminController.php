<?php
// app/controllers/AdminController.php

class AdminController extends Controller
{
    private Product $productModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/Product.php';
        $this->productModel = new Product();
        session_start();
    }

    // Default action for /admin
    public function index()
    {
        header('Location: /admin/dashboard');
        exit;
    }

    // Admin Login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Simple static login
            if ($email === 'admin@g4minimart.com' && $password === 'admin123') {
                $_SESSION['is_admin'] = true;
                header('Location: /admin/dashboard');
                exit;
            } else {
                echo "Invalid admin credentials.";
            }
        }

        $this->view('admin/login');
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['is_admin']);
        session_destroy();
        header('Location: /admin/login');
        exit;
    }


    // Admin Dashboard (Product Overview)
    public function dashboard()
    {
        $this->ensureAdmin();
        $products = $this->productModel->getAll();
        $this->view('admin/dashboard', ['products' => $products]);
    }

    // Manage Products
    public function manageProducts()
    {
        $this->ensureAdmin();

        $products = $this->productModel->getAll();
        $this->view('admin/manage_products', ['products' => $products]);
    }


    // Add a new product
    public function addProduct()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name        = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $price       = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $image       = $_FILES['image'] ?? null;

            $filename = null;

            if ($image && $image['tmp_name']) {

                // 1. Build a filename
                $filename = time() . '_' . basename($image['name']);

                // 2. Point to the public uploads folder
                //    __DIR__ = /app/controllers
                $targetPath = __DIR__ . '/../../public/uploads/products/' . $filename;

                // 3. Ensure the directory exists & is writable
                if (!is_dir(dirname($targetPath))) {
                    mkdir(dirname($targetPath), 0755, true);
                }

                move_uploaded_file($image['tmp_name'], $targetPath);
            }

            $this->productModel->create(
                $name,
                $price ?: 0,
                $description,
                $filename
            );

            header('Location: /admin/manage_products');
            exit;
        }

        $this->view('admin/add_product');
    }


    // Delete product
    public function deleteProduct($id = null)
    {
        $this->ensureAdmin();

        if ($id !== null) {
            $this->productModel->delete((int)$id);
        }

        header('Location: /admin/dashboard');
        exit;
    }

    public function editProduct($id)
    {
        $this->ensureAdmin();

        // Fetch the product by ID
        $product = $this->productModel->findById($id);

        if (!$product) {
            echo "Product not found.";
            return;
        }

        // If form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $image = $_FILES['image'] ?? null;

            // Keep existing image by default
            $filename = $product['image'];

            // If a new image was uploaded, save it to public/uploads/products/
            if ($image && !empty($image['tmp_name'])) {
                $filename = time() . '_' . basename($image['name']);

                // Use the same public uploads folder used in addProduct
                $targetDir = __DIR__ . '/../../public/uploads/products/';
                // Ensure directory exists
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                $targetPath = $targetDir . $filename;

                if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
                    die("Failed to move uploaded file. Check permissions and path: $targetPath");
                }
            }

            // Delegate update to the model
            $updated = $this->productModel->update($id, $name, $price, $description, $filename);

            if ($updated) {
                header('Location: /admin/manageProducts');
                exit;
            } else {
                echo "Failed to update product.";
            }
        }

        $this->view('admin/edit_product', ['product' => $product]);
    }   

    // Protect admin pages
    private function ensureAdmin()
    {
        if (empty($_SESSION['is_admin'])) {
            header('Location: /admin/login');
            exit;
        }
    }
}
