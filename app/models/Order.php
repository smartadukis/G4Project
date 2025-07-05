<?php
// app/models/Order.php

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createOrder($userId, $name, $email, $address, $cartItems)
    {
        $this->db->beginTransaction();

        try {
            // Insert into orders table
            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, name, email, address, created_at) 
                VALUES (:user_id, :name, :email, :address, NOW())
            ");
            $stmt->execute([
                'user_id' => $userId,
                'name' => $name,
                'email' => $email,
                'address' => $address
            ]);

            $orderId = $this->db->lastInsertId();

            // Insert products
            foreach ($cartItems as $item) {
                $stmt = $this->db->prepare("
                    INSERT INTO order_items (order_id, product_id, quantity, price) 
                    VALUES (:order_id, :product_id, :quantity, :price)
                ");
                $stmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            $this->db->commit();
            return $orderId;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Order Error: " . $e->getMessage());
            return false;
        }
    }

    public function getOrdersByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT o.id, o.created_at, oi.quantity, oi.price, p.name 
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON p.id = oi.product_id
            WHERE o.user_id = :user_id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
