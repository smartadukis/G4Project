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

        echo "<h1>" . htmlspecialchars($product['name']) . "</h1>";
        echo "<p>₦" . number_format($product['price'], 2) . "</p>";
        echo "<p>" . htmlspecialchars($product['description']) . "</p>";
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

    public function update($id, $name, $price, $description, $image = null)
    {
        $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price, description = :description, image = :image WHERE id = :id");
        return $stmt->execute([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $image,
            'id' => $id
        ]);
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
