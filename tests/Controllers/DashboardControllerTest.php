<?php
// tests/controller/DashboardControllerTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/models/Order.php';

class DashboardControllerTest extends TestCase
{
    private $controller;
    private $orderMock;

    protected function setUp(): void
    {
        // Mock the Order model to isolate controller testing
        $this->orderMock = $this->createMock(Order::class);

        // Inject the mock into DashboardController
        $this->controller = $this->getMockBuilder(DashboardController::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['view'])
            ->getMock();

        // Replace orderModel with our mock
        $reflection = new ReflectionClass($this->controller);
        $property = $reflection->getProperty('orderModel');
        $property->setAccessible(true);
        $property->setValue($this->controller, $this->orderMock);

        // Start fake session
        $_SESSION = ['user_id' => 1];
    }

    public function testIndexRedirectsIfNotLoggedIn()
    {
        unset($_SESSION['user_id']);

        // Capture output buffer since header() will be called
        $this->expectOutputRegex('/.*/');

        // Expect script to exit after redirect
        $this->expectException(\PHPUnit\Framework\Error\Warning::class);

        $this->controller->index();
    }

    public function testIndexGroupsOrdersCorrectly()
    {
        // Fake database return (two items for one order)
        $fakeOrders = [
            ['id' => 1, 'created_at' => '2025-08-17', 'name' => 'Item A', 'quantity' => 2, 'price' => 100],
            ['id' => 1, 'created_at' => '2025-08-17', 'name' => 'Item B', 'quantity' => 1, 'price' => 50]
        ];

        $this->orderMock->method('getOrdersByUser')->willReturn($fakeOrders);

        // Expect that the view() method is called with grouped data
        $this->controller->expects($this->once())
            ->method('view')
            ->with(
                'dashboard/index',
                $this->callback(function ($data) {
                    return isset($data['orders']) &&
                           count($data['orders']) === 1 &&
                           count($data['orders'][0]['items']) === 2;
                })
            );

        $this->controller->index();
    }
}
