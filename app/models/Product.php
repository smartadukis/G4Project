<?php
// app/models/Product.php

class Product
{
    private $db;

    public function __construct()
    {
        // Get the shared database instance
        $this->db = Database::getInstance();
    }

    /**
     * Fetch all products from the database
     * 
     * @return array - List of products
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a single product by ID
     * 
     * @param int $id - Product ID
     * @return array|false - Product data or false if not found
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new product into the database
     */
    public function create($name, $price, $description, $image = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, price, description, image) 
            VALUES (:name, :price, :description, :image)
        ");
        return $stmt->execute([
            'name'        => $name,
            'price'       => $price,
            'description' => $description,
            'image'       => $image
        ]);
    }

    /**
     * Update an existing product
     * - If $imageFilename is provided, update image too
     * - Otherwise keep the old image
     */
    public function update($id, $name, $price, $description, $imageFilename = null)
    {
        if ($imageFilename !== null && $imageFilename !== '') {
            $sql = "UPDATE products
                    SET name = :name,
                        price = :price,
                        description = :description,
                        image = :image
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':name'        => $name,
                ':price'       => $price,
                ':description' => $description,
                ':image'       => $imageFilename,
                ':id'          => $id
            ]);
        } else {
            $sql = "UPDATE products
                    SET name = :name,
                        price = :price,
                        description = :description
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':name'        => $name,
                ':price'       => $price,
                ':description' => $description,
                ':id'          => $id
            ]);
        }
    }

    /**
     * Delete a product and its image (if exists)
     */
    public function delete($id)
    {
        // First fetch product to remove the image file
        $stmt = $this->db->prepare("SELECT image FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // If product has an image, delete it from filesystem
        if ($product && $product['image']) {
            $imagePath = __DIR__ . '/../../uploads/products/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Finally remove product from database
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
