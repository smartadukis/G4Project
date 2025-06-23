<?php
// includes/App.php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Check for a dedicated controller (e.g., /product -> ProductController)
        if (!empty($url) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Determine the method to call
        $methodCandidate = !empty($url) ? $url[array_keys($url)[0]] : 'index';

        if (method_exists($this->controller, $methodCandidate)) {
            $this->method = $methodCandidate;
            // Unset the part of the URL that was used as the method
            if(!empty($url)) {
                unset($url[array_keys($url)[0]]);
            }
        }
        
        // 3. Get remaining parts as parameters
        $this->params = $url ? array_values($url) : [];

        // 4. Call the controller's method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}