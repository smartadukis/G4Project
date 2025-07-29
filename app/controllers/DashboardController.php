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

    $userId = $_SESSION['user_id'];
    $orders = $this->orderModel->getOrdersByUser($userId);
    
    // Re‑group rows into orders with nested items
    $grouped = [];
    foreach ($orders as $row) {
        $oid = $row['id'];
        if (!isset($grouped[$oid])) {
            $grouped[$oid] = [
                'id'         => $oid,
                'created_at' => $row['created_at'],
                'items'      => []
            ];
        }
        $grouped[$oid]['items'][] = [
            'name'     => $row['name'],
            'quantity' => $row['quantity'],
            'price'    => $row['price']
        ];
    }

    // Pass an indexed array of orders
    $this->view('dashboard/index', ['orders' => array_values($grouped)]);
}

}
