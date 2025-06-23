<?php
// app/controllers/ProductController.php

class ProductController extends Controller
{
    
    public function index()
    {
        // Some example data you might get from a Product Model in the future
        $data = [
            'pageTitle' => 'Our Products',
            'products' => [
                ['id' => 1, 'name' => 'Fresh Apples', 'price' => 1.99],
                ['id' => 2, 'name' => 'Loaf of Bread', 'price' => 2.49],
                ['id' => 3, 'name' => 'Gallon of Milk', 'price' => 3.00]
            ]
        ];

       
        $this->view('product', $data); 
    }

   
    public function show($id = 0)
    {
        echo "Showing product with ID: " . htmlspecialchars($id);
        
    }
}
