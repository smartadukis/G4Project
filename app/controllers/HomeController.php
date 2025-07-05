<?php
// app/controllers/HomeController.php

require_once '../includes/Controller.php';

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home');
    }

    public function cart()
    {
        $this->view('cart');
        header('Location: /order/cart');
        exit;
    }

    public function checkout()
    {
        $this->view('checkout');
    }

    public function confirm()
    {
        $this->view('confirm');
    }

    public function product()
    {
        $this->view('product');
    }
}
