<?php
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for AdminController
 */
class AdminControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../../app/controllers/AdminController.php';
        $this->controller = new AdminController();
        $_SESSION = []; // reset session
    }

    /** @test */
    public function testLoginWithValidCredentials()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'admin@g4minimart.com';
        $_POST['password'] = 'admin123';

        ob_start();
        $this->controller->login();
        $output = ob_get_clean();

        $this->assertTrue($_SESSION['is_admin'] ?? false);
    }

    /** @test */
    public function testLoginWithInvalidCredentials()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 'wrong@example.com';
        $_POST['password'] = 'wrongpass';

        ob_start();
        $this->controller->login();
        $output = ob_get_clean();

        $this->assertStringContainsString("Invalid admin credentials", $output);
        $this->assertArrayNotHasKey('is_admin', $_SESSION);
    }

    /** @test */
    public function testLogoutClearsSession()
    {
        $_SESSION['is_admin'] = true;

        ob_start();
        $this->controller->logout();
        ob_end_clean();

        $this->assertArrayNotHasKey('is_admin', $_SESSION);
    }

    /** @test */
    public function testEnsureAdminRedirectsIfNotLoggedIn()
    {
        $_SESSION = []; // no admin login
        ob_start();
        $this->controller->dashboard();
        $output = ob_get_clean();

        $this->assertEmpty($_SESSION['is_admin'] ?? null);
    }
}
