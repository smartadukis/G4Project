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
}
