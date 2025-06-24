<?php
require_once '../config/config.php';
require_once '../includes/Database.php';

$db = Database::getInstance();
echo "Connected successfully!";
