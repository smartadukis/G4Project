<?php
// app/models/Order.php

class Order
{
    private $db;

    public function __construct()
    {
        // Initialize the database connection (singleton instance)
        $this->db = Database::getInstance();
    }

    /**
     * Create a new order and save it into the database.
     * 
     * @param int $userId - ID of the user placing the order
     * @param string $name - Customer name
     * @param string $email - Customer email
     * @param string $address - Delivery address
     * @param array $cartItems - Array of items in the cart (id, quantity, price)
     * 
     * @return int|false - Returns the newly created order ID on success, or false on failure
     */
    public function createOrder($userId, $name, $email, $address, $cartItems)
    {
        // Start transaction to ensure atomicity
        $this->db->beginTransaction();

        try {
            // Insert order into `orders` table
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

            // Get the last inserted order ID
            $orderId = $this->db->lastInsertId();

            // Insert related products into `order_items` table
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

            // Commit transaction if all queries succeed
            $this->db->commit();
            return $orderId;

        } catch (PDOException $e) {
            // Roll back if any query fails
            $this->db->rollBack();
            error_log("Order Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all orders placed by a specific user.
     * 
     * @param int $userId - ID of the user
     * 
     * @return array - Returns an array of orders with items
     */
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
