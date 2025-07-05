<?php
// app/controllers/AdminController.php

class AdminController extends Controller
{
    private $productModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/Product.php';
        $this->productModel = new Product();
        session_start();
    }

    // Hardcoded login (adjust as needed)
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

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

    public function dashboard()
    {
        $this->ensureAdmin();
        $products = $this->productModel->getAll();
        $this->view('admin/dashboard', ['products' => $products]);
    }

    public function addProduct()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $image = $_FILES['image'] ?? null;

            $filename = null;
            if ($image && $image['tmp_name']) {
                $filename = time() . '_' . basename($image['name']);
                $targetPath = __DIR__ . '/../../uploads/products/' . $filename;
                move_uploaded_file($image['tmp_name'], $targetPath);
            }

            $this->productModel->create($name, $price, $description, $filename);
            header('Location: /admin/dashboard');
            exit;
        }

        $this->view('admin/add_product');
    }

    public function deleteProduct($id)
    {
        $this->ensureAdmin();
        $this->productModel->delete($id);
        header('Location: /admin/dashboard');
    }

    private function ensureAdmin()
    {
        if (!isset($_SESSION['is_admin'])) {
            header('Location: /admin/login');
            exit;
        }
    }
}
