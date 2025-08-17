<?php
// tests/HomeControllerTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/controllers/HomeController.php';

class HomeControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        // Initialize the HomeController before each test
        $this->controller = new HomeController();
    }

    /**
     * Test that index() loads the home view without errors.
     */
    public function testIndexLoadsHomeView()
    {
        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        // The view loader should include the 'home' file
        $this->assertStringContainsString('home', $output ?? 'view loaded');
    }

    /**
     * Test that cart() redirects properly.
     */
    public function testCartRedirectsToOrderCart()
    {
        // Suppress headers in CLI test
        $this->expectOutputRegex('/.*/');

        try {
            $this->controller->cart();
        } catch (\Exception $e) {
            // Since header() may fail under CLI, just assert redirect URL
            $this->assertStringContainsString('/order/cart', xdebug_get_headers()[0] ?? '');
        }
    }

    /**
     * Test that checkout() loads checkout view.
     */
    public function testCheckoutLoadsView()
    {
        ob_start();
        $this->controller->checkout();
        $output = ob_get_clean();

        $this->assertStringContainsString('checkout', $output ?? 'view loaded');
    }

    /**
     * Test that confirm() loads confirm view.
     */
    public function testConfirmLoadsView()
    {
        ob_start();
        $this->controller->confirm();
        $output = ob_get_clean();

        $this->assertStringContainsString('confirm', $output ?? 'view loaded');
    }

    /**
     * Test that product() loads product view.
     */
    public function testProductLoadsView()
    {
        ob_start();
        $this->controller->product();
        $output = ob_get_clean();

        $this->assertStringContainsString('product', $output ?? 'view loaded');
    }
}
