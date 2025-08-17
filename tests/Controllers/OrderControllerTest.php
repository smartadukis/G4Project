<?php
// tests/Controllers/OrderControllerTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/controllers/OrderController.php';

class OrderControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        $_POST = [];
        $_SERVER = [];
        $_SESSION = [];
    }

    public function test_cart_calls_view_with_correct_data()
    {
        // Create a partial mock of OrderController overriding view()
        $controller = $this->getMockBuilder(OrderController::class)
                           ->onlyMethods(['view'])
                           ->disableOriginalConstructor()
                           ->getMock();

        // Prepare a sample cart in the session (two items)
        $_SESSION['cart'] = [
            1 => ['id' => 1, 'name' => 'Apple', 'price' => 2.50, 'quantity' => 3],
            2 => ['id' => 2, 'name' => 'Bread', 'price' => 4.00, 'quantity' => 1],
        ];

        // Expect view() to be called once with 'cart' and an array where 'total' matches expected
        $expectedTotal = (2.50 * 3) + (4.00 * 1); // 11.5

        $controller->expects($this->once())
                   ->method('view')
                   ->with(
                       $this->equalTo('cart'),
                       $this->callback(function ($arg) use ($expectedTotal) {
                           // Should be an array with keys cartItems and total
                           if (!is_array($arg)) return false;
                           if (!isset($arg['cartItems']) || !isset($arg['total'])) return false;

                           // total should equal expected value (float)
                           return abs($arg['total'] - $expectedTotal) < 0.0001;
                       })
                   );

        // Call the cart() method on the partial mock. It will use $_SESSION directly.
        $controller->cart();
    }
}
