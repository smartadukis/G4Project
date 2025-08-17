<?php
// tests/UserTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/core/Database.php';

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        // Initialize User model before each test
        $this->user = new User();
    }

    public function testCreateUser()
    {
        $name = "Test User";
        $email = "testuser@example.com";
        $password = "password123";

        $result = $this->user->create($name, $email, $password);

        $this->assertTrue($result, "User creation should return true");
    }

    public function testFindByEmail()
    {
        $email = "testuser@example.com";
        $user = $this->user->findByEmail($email);

        $this->assertIsArray($user, "findByEmail should return an associative array");
        $this->assertEquals($email, $user['email'], "Email from database should match queried email");
    }
}
