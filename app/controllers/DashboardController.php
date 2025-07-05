<?php
// app/controllers/DashboardController.php

require_once __DIR__ . '/../models/Order.php';

class DashboardController extends Controller
{
    private $orderModel;

    public function __construct()
    {
        session_start();
        $this->orderModel = new Order();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        $orders = $this->orderModel->getOrdersByUser($_SESSION['user_id']);
        $this->view('dashboard/index', ['orders' => $orders]);
    }
}
