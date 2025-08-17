<?php

// app/controllers/AuthController.php

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        // Load User model
        require_once __DIR__ . '/../models/User.php';

        // Check if User model class exists
        if (!class_exists('User')) {
            die('User model not found even after require.');
        }

        // Initialize User model
        $this->userModel = new User();

        // Start session (required for login persistence)
        session_start();
    }

    /**
     * Show login page
     */
    public function login()
    {
        $this->view('auth/login');
    }

    /**
     * Show registration page
     */
    public function register()
    {
        $this->view('auth/register');
    }

    /**
     * Handle user login request
     */
    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Check if user exists by email
            $user = $this->userModel->findByEmail($email);

            // Verify password
            if ($user && password_verify($password, $user['password'])) {
                // Store user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // Redirect to dashboard
                header('Location: /dashboard');
                exit;
            } else {
                // Invalid credentials
                echo "Invalid email or password.";
            }
        }
    }

    /**
     * Handle user registration request
     */
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Check if email already exists
            if ($this->userModel->findByEmail($email)) {
                echo "Email already registered.";
            } else {
                // Create new user in DB
                $this->userModel->create($name, $email, $password);

                // Redirect to login page
                header('Location: /auth/login');
                exit;
            }
        }
    }

    /**
     * Log out user and destroy session
     */
    public function logout()
    {
        session_start();
        session_destroy();

        // Redirect to login page
        header('Location: /auth/login');
    }
}
