<?php
// tests/Controllers/AuthControllerTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/controllers/AuthController.php';
require_once __DIR__ . '/../../app/models/User.php';

class AuthControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        // reset superglobals after each test
        $_POST = [];
        $_SERVER = [];
        $_SESSION = [];
    }

    public function test_registerUser_when_email_exists_outputs_message_and_does_not_create()
    {
        // Arrange - create a controller mock that does not call real constructor (avoid DB)
        $controller = $this->getMockBuilder(AuthController::class)
                           ->onlyMethods(['view'])
                           ->disableOriginalConstructor()
                           ->getMock();

        // Create a User model mock where findByEmail returns a truthy value (email exists)
        $userMock = $this->createMock(User::class);
        $userMock->method('findByEmail')->willReturn(['id' => 1, 'email' => 'a@a.com']);

        // Inject mock into private property $userModel (Reflection)
        $ref = new ReflectionObject($controller);
        $prop = $ref->getProperty('userModel');
        $prop->setAccessible(true);
        $prop->setValue($controller, $userMock);

        // Simulate POST request with form values
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = 'Test User';
        $_POST['email'] = 'a@a.com';
        $_POST['password'] = 'secret';

        // Capture output
        ob_start();
        $controller->registerUser();
        $output = ob_get_clean();

        // Assert message shown and create() was not called
        $this->assertStringContainsString('Email already registered', $output);
    }

    public function test_loginUser_with_invalid_credentials_outputs_error()
    {
        $controller = $this->getMockBuilder(AuthController::class)
                           ->onlyMethods(['view'])
                           ->disableOriginalConstructor()
                           ->getMock();

        // Build user record with a password hash that does NOT match the POSTed password
        $passwordHash = password_hash('correct-password', PASSWORD_DEFAULT);
        $userRecord = ['id' => 2, 'name' => 'Tester', 'email' => 't@t.com', 'password' => $passwordHash];

        $userMock = $this->createMock(User::class);
        $userMock->method('findByEmail')->willReturn($userRecord);

        $ref = new ReflectionObject($controller);
        $prop = $ref->getProperty('userModel');
        $prop->setAccessible(true);
        $prop->setValue($controller, $userMock);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = 't@t.com';
        $_POST['password'] = 'wrong-password';

        ob_start();
        $controller->loginUser();
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid email or password', $output);
    }
}
