<?php

// app/controllers/AuthController.php

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {

        require_once __DIR__ . '/../models/User.php';

        if (!class_exists('User')) {
        die('User model not found even after require.');
    }


        $this->userModel = new User();
        session_start();
    }

    public function login()
    {
        $this->view('auth/login');
    }

    public function register()
    {
        $this->view('auth/register');
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: /dashboard');
                exit;
            } else {
                echo "Invalid email or password.";
            }
        }
    }

    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->findByEmail($email)) {
                echo "Email already registered.";
            } else {
                $this->userModel->create($name, $email, $password);
                header('Location: /auth/login');
                exit;
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /auth/login');
    }
}
