<?php
// app/controllers/HomeController.php

require_once '../includes/Controller.php';

/**
 * HomeController
 * 
 * Handles requests for general frontend pages of the application
 * such as home, cart, checkout, confirmation, and product details.
 */
class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return void
     */
    public function index()
    {
        $this->view('home');
    }

    /**
     * Redirect user to the cart page.
     * 
     * NOTE: The method first calls view('cart'), but since header redirect
     * is executed immediately after, the view() call will not be effective.
     * Only the redirect will apply.
     *
     * @return void
     */
    public function cart()
    {
        $this->view('cart');
        header('Location: /order/cart');
        exit;
    }

    /**
     * Display the checkout page.
     *
     * @return void
     */
    public function checkout()
    {
        $this->view('checkout');
    }

    /**
     * Display the order confirmation page.
     *
     * @return void
     */
    public function confirm()
    {
        $this->view('confirm');
    }

    /**
     * Display the product page.
     *
     * @return void
     */
    public function product()
    {
        $this->view('product');
    }
}
