<?php
/**
 * Database Configuration and Connection
 *
 * This file establishes a secure PDO connection to the MySQL database
 * for the video tracking application. It includes proper error handling
 * and security configurations to prevent common vulnerabilities.
 */

// Database configuration constants
// Update these values according to your database setup
define('DB_HOST', 'localhost');        // Database server hostname
define('DB_USER', 'root');             // Database username
define('DB_PASS', '');                 // Database password (use strong password in production)
define('DB_NAME', 'video_tracking');   // Database name

/**
 * Establish PDO database connection
 *
 * @return PDO Database connection object
 * @throws PDOException If connection fails
 */
function getDatabaseConnection() {
    try {
        // Create PDO instance with DSN (Data Source Name)
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        // PDO options for security and performance
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,    // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,          // Return associative arrays by default
            PDO::ATTR_EMULATE_PREPARES   => false,                     // Use real prepared statements
            PDO::ATTR_PERSISTENT         => false,                     // Disable persistent connections for security
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",       // Set UTF-8 encoding
        ];

        // Create and return PDO connection
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        return $pdo;

    } catch (PDOException $e) {
        // Log the error (in production, use proper logging)
        error_log("Database connection failed: " . $e->getMessage());

        // In production, don't expose error details to users
        // Instead, show a generic error message
        die("Database connection error. Please try again later.");
    }
}

// Create global PDO instance for backward compatibility
// In modern applications, consider using dependency injection instead
try {
    $pdo = getDatabaseConnection();
} catch (Exception $e) {
    // Handle connection failure gracefully
    $pdo = null;
}
