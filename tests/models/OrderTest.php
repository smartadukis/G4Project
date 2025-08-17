<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Order.php';
require_once __DIR__ . '/../app/core/Database.php';

class OrderTest extends TestCase
{
    private $order;

    protected function setUp(): void
    {
        $this->order = new Order();
    }

    public function testCreateOrder()
    {
        $cartItems = [
            ['id' => 1, 'quantity' => 2, 'price' => 100],
            ['id' => 2, 'quantity' => 1, 'price' => 200]
        ];

        $orderId = $this->order->createOrder(1, "John Doe", "john@example.com", "123 Test Street", $cartItems);

        // Assert that an order ID was returned (not false)
        $this->assertIsNumeric($orderId);
        $this->assertGreaterThan(0, $orderId);
    }

    public function testGetOrdersByUser()
    {
        $orders = $this->order->getOrdersByUser(1);

        // Assert result is an array
        $this->assertIsArray($orders);

        // If orders exist, check the structure
        if (!empty($orders)) {
            $this->assertArrayHasKey('id', $orders[0]);
            $this->assertArrayHasKey('created_at', $orders[0]);
            $this->assertArrayHasKey('quantity', $orders[0]);
            $this->assertArrayHasKey('price', $orders[0]);
            $this->assertArrayHasKey('name', $orders[0]);
        }
    }
}
