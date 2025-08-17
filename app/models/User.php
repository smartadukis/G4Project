<?php
// app/models/User.php

class User
{
    private $db;

    public function __construct()
    {
        // Get the singleton database instance
        $this->db = Database::getInstance();
    }

    /**
     * Find a user by email address
     *
     * @param string $email
     * @return array|false Returns user record as associative array or false if not found
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new user
     *
     * @param string $name User's full name
     * @param string $email User's email address
     * @param string $password Plain text password (will be hashed before saving)
     * @return bool True on success, false on failure
     */
    public function create($name, $email, $password)
    {
        // Securely hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }
}
