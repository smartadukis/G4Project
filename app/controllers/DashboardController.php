<?php
// app/controllers/DashboardController.php

require_once __DIR__ . '/../models/Order.php';

class DashboardController extends Controller
{
    private $orderModel;

    public function __construct()
    {
        // Start session if not already started
        session_start();

        // Load the Order model for retrieving order history
        $this->orderModel = new Order();
    }

    /**
     * Show the user dashboard with their order history
     *
     * - Redirects to login if the user is not authenticated
     * - Fetches all orders belonging to the logged-in user
     * - Groups each order with its corresponding items
     * - Passes the grouped orders to the dashboard view
     */
    public function index()
    {
        // Ensure only logged-in users can access the dashboard
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }

        // Get current logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Fetch all order rows belonging to this user
        $orders = $this->orderModel->getOrdersByUser($userId);
        
        // Re-group rows into structured orders with nested items
        $grouped = [];
        foreach ($orders as $row) {
            $oid = $row['id'];

            // Initialize order if not seen before
            if (!isset($grouped[$oid])) {
                $grouped[$oid] = [
                    'id'         => $oid,
                    'created_at' => $row['created_at'],
                    'items'      => []
                ];
            }

            // Append the current product/item into the order
            $grouped[$oid]['items'][] = [
                'name'     => $row['name'],
                'quantity' => $row['quantity'],
                'price'    => $row['price']
            ];
        }

        // Pass an indexed array of grouped orders to the view
        $this->view('dashboard/index', ['orders' => array_values($grouped)]);
    }
}
