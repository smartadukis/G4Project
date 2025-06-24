<?php
// public/index.php

// Show errors for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require_once '../app/models/User.php';

require_once '../config/config.php'; // If you have one for DB, etc.
require_once '../includes/App.php';
require_once '../includes/Controller.php';
require_once '../includes/Database.php'; // and other core files


$app = new App();