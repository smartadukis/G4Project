<?php
// app/models/Product.php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Fetch all products
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single product by ID
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $price, $description, $image = null)
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)");
        return $stmt->execute([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $image
        ]);
    }


    public function update($id, $name, $price, $image = null)
    {
        if ($image) {
            $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price, image = :image WHERE id = :id");
            return $stmt->execute([
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'image' => $image
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price WHERE id = :id");
            return $stmt->execute([
                'id' => $id,
                'name' => $name,
                'price' => $price
            ]);
        }
    }

     public function delete($id)
    {
        // Fetch product to delete image too
        $stmt = $this->db->prepare("SELECT image FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && $product['image']) {
            $imagePath = __DIR__ . '/../../uploads/products/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Now delete the DB record
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}
