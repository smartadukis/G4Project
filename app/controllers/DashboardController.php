<?php
// app/controllers/DashboardController.php

class DashboardController extends Controller
{
    public function index()
    {
        session_start();
        
        // Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        // Sample order history 
        $orders = [
            ['id' => 101, 'total' => 25.00, 'date' => '2024-06-01'],
            ['id' => 102, 'total' => 10.50, 'date' => '2024-06-05'],
        ];

        $data = [
            'username' => $_SESSION['user_name'],
            'orders' => $orders
        ];

        $this->view('dashboard/index', $data);
    }
}
