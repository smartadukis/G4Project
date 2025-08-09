<?php
// app/controllers/ProductController.php

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/Product.php';
        $this->productModel = new Product();
    }

    public function index()
    {
        $products = $this->productModel->getAll();

        $this->view('product', [
            'pageTitle' => 'All Products',
            'products' => $products
        ]);
    }

    public function show($id = 0)
    {
        $product = $this->productModel->findById($id);

        if (!$product) {
            echo "Product not found.";
            return;
        }

        $this->view('product_detail', [
            'product' => $product
        ]);
    }


    public function edit($id)
    {
        require_once '../app/models/Product.php';
        $productModel = new Product();
        $product = $productModel->findById($id);

        if (!$product) {
            echo "Product not found";
            return;
        }

        $this->view('admin/edit_product', ['product' => $product]);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $imageName = $_POST['old_image'] ?? null;

            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/../../public/uploads/products/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
            }

            $this->productModel->update($id, $name, $price, $description, $imageName);
            header('Location: /admin/manageProducts');
            exit;
        }
    }




    public function manage()
    {
        require_once '../app/models/Product.php';
        $productModel = new Product();
        $products = $productModel->getAll();

        $this->view('admin/manage_products', ['products' => $products]);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_numeric($id)) {
            $deleted = $this->productModel->delete($id);
            
            if ($deleted) {
                // Redirect back to the manage products page
                header('Location: /admin/manage_products');
                exit;
            } else {
                echo "Failed to delete product.";
            }
        } else {
            echo "Invalid request.";
        }
    }
    
}
