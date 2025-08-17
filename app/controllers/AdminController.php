<?php
// app/controllers/AdminController.php

/**
 * Controller handling Admin authentication and product management.
 */
class AdminController extends Controller
{
    private Product $productModel;

    public function __construct()
    {
        // Load Product model for CRUD operations
        require_once __DIR__ . '/../models/Product.php';
        $this->productModel = new Product();

        // Start a session for admin authentication
        session_start();
    }

    /**
     * Default route for /admin
     * Redirects to admin dashboard
     */
    public function index()
    {
        header('Location: /admin/dashboard');
        exit;
    }

    /**
     * Admin login page + authentication
     * - GET: Show login form
     * - POST: Verify credentials
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize inputs
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Static login (could later be replaced with DB lookup)
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

    /**
     * Logs out the admin and destroys the session
     */
    public function logout()
    {
        session_start();
        unset($_SESSION['is_admin']);
        session_destroy();
        header('Location: /admin/login');
        exit;
    }

    /**
     * Admin Dashboard
     * Displays all products in overview
     */
    public function dashboard()
    {
        $this->ensureAdmin();
        $products = $this->productModel->getAll();
        $this->view('admin/dashboard', ['products' => $products]);
    }

    /**
     * Manage Products (same as dashboard but with management actions)
     */
    public function manageProducts()
    {
        $this->ensureAdmin();
        $products = $this->productModel->getAll();
        $this->view('admin/manage_products', ['products' => $products]);
    }

    /**
     * Add a new product
     * Handles image upload and inserts into DB
     */
    public function addProduct()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize input fields
            $name        = filter_input(INPUT_POST, 'name',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $price       = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $image       = $_FILES['image'] ?? null;

            $filename = null;

            // Handle image upload if present
            if ($image && $image['tmp_name']) {
                $filename = time() . '_' . basename($image['name']);
                $targetPath = __DIR__ . '/../../public/uploads/products/' . $filename;

                // Ensure uploads folder exists
                if (!is_dir(dirname($targetPath))) {
                    mkdir(dirname($targetPath), 0755, true);
                }

                move_uploaded_file($image['tmp_name'], $targetPath);
            }

            // Save product via model
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

    /**
     * Delete a product by ID
     *
     * @param int|null $id Product ID
     */
    public function deleteProduct($id = null)
    {
        $this->ensureAdmin();

        if ($id !== null) {
            $this->productModel->delete((int)$id);
        }

        header('Location: /admin/dashboard');
        exit;
    }

    /**
     * Edit an existing product
     * - GET: Display edit form
     * - POST: Update product in DB
     *
     * @param int $id Product ID
     */
    public function editProduct($id)
    {
        $this->ensureAdmin();

        $product = $this->productModel->findById($id);

        if (!$product) {
            echo "Product not found.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name        = $_POST['name'] ?? '';
            $price       = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $image       = $_FILES['image'] ?? null;

            $filename = $product['image']; // keep old image by default

            if ($image && !empty($image['tmp_name'])) {
                $filename = time() . '_' . basename($image['name']);
                $targetDir = __DIR__ . '/../../public/uploads/products/';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                $targetPath = $targetDir . $filename;

                if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
                    die("Failed to move uploaded file: $targetPath");
                }
            }

            // Update via model
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

    /**
     * Protects all admin routes
     */
    private function ensureAdmin()
    {
        if (empty($_SESSION['is_admin'])) {
            header('Location: /admin/login');
            exit;
        }
    }
}
