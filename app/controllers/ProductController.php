<?php
// app/controllers/ProductController.php

/**
 * ProductController
 *
 * Handles product listing, details, admin editing, updating, and deletion.
 * Uses Product model for database operations.
 */
class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/Product.php';
        $this->productModel = new Product();
    }

    /**
     * Show all products.
     *
     * @return void
     */
    public function index()
    {
        $products = $this->productModel->getAll();

        $this->view('product', [
            'pageTitle' => 'All Products',
            'products'  => $products
        ]);
    }

    /**
     * Show details of a single product.
     *
     * @param int $id Product ID
     * @return void
     */
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

    /**
     * Load the edit form for a given product.
     *
     * @param int $id Product ID
     * @return void
     */
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

    /**
     * Retrieve product directly using raw query.
     *
     * @param int $id Product ID
     * @return array|false
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update product details after form submission.
     *
     * @return void
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id          = $_POST['id'];
            $name        = $_POST['name'];
            $price       = $_POST['price'];
            $description = $_POST['description'];
            $imageName   = $_POST['old_image'] ?? null;

            // Handle image upload if new image provided
            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/../../public/uploads/products/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
            }

            // Update via model
            $this->productModel->update($id, $name, $price, $description, $imageName);
            header('Location: /admin/manageProducts');
            exit;
        }
    }

    /**
     * Display all products for admin management.
     *
     * @return void
     */
    public function manage()
    {
        require_once '../app/models/Product.php';
        $productModel = new Product();
        $products = $productModel->getAll();

        $this->view('admin/manage_products', ['products' => $products]);
    }

    /**
     * Delete a product by ID.
     *
     * @param int $id Product ID
     * @return void
     */
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_numeric($id)) {
            $deleted = $this->productModel->delete($id);
            
            if ($deleted) {
                // Redirect back to manage products page
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
