<?php

define('PLAINKIT_BASE_PATH', dirname(__DIR__) . '/');

require dirname(__DIR__, 3) . '/vendor/autoload.php';

$config = require base_path('config/app.php');
$host = $config['database']['connection']['host'];
$port = $config['database']['connection']['port'];
$dbName = $config['database']['connection']['dbname'];
$username = $config['database']['username'];
$password = $config['database']['password'];

$pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create database
$pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo->exec("USE `$dbName`");
echo "Database '$dbName' created\n";

// Create users table
$pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )
    ");
echo "Table 'users' created\n";

// Create clients table
$pdo->exec("
        CREATE TABLE IF NOT EXISTS clients (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        )
    ");
echo "Table 'clients' created\n";

// Create transactions table
$pdo->exec("
        CREATE TABLE IF NOT EXISTS transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type ENUM('earning', 'expense') NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            client_id INT NOT NULL,
            FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
echo "Table 'transactions' created\n";
