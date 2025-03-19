<?php
/**
 * Configuration settings for the doTask application
 * Current Date and Time (UTC): 2025-03-19 00:00:09
 * Current User: ivanshero
 */

// Environment settings
define('APP_ENV', 'development'); // 'development', 'production', or 'testing'
define('DEBUG_MODE', true);

// Database settings
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'dotask_db');
define('DB_USER', 'dotask_user');
define('DB_PASS', 'dotask_password');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATION', 'utf8mb4_unicode_ci');

// Path settings
define('BASE_URL', 'http://localhost/doTask');
define('ROOT_PATH', dirname(__DIR__));
define('UPLOADS_PATH', ROOT_PATH . '/uploads');
define('LOGS_PATH', ROOT_PATH . '/logs');

// System settings
define('DEFAULT_TIMEZONE', 'UTC');
define('SESSION_EXPIRY', 3600); // Session expiry in seconds (1 hour)
define('REMEMBER_EXPIRY', 2592000); // Remember me expiry in seconds (30 days)
define('MAX_LOGIN_ATTEMPTS', 5);

// API and Integration settings
define('API_TOKEN', 'your-api-token');
define('ENABLE_EXTERNAL_APIS', true);
define('CRON_SECRET_KEY', 'your-cron-secret-key');

// Email settings
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'notify@example.com');
define('SMTP_PASS', 'smtp_password');
define('SMTP_FROM_NAME', 'doTask System');

// Application settings
define('APP_NAME', 'doTask');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'ivanshero');
define('APP_CONTACT', 'admin@dotask.com');
define('APP_DESCRIPTION', 'نظام إدارة وأتمتة ذكي للمواقع');

// Set default timezone
date_default_timezone_set(DEFAULT_TIMEZONE);

// Error reporting based on environment
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Initialize custom error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $logMessage = date('[Y-m-d H:i:s]') . " Error: [$errno] $errstr in $errfile on line $errline" . PHP_EOL;
    error_log($logMessage, 3, LOGS_PATH . '/error.log');
    
    if (APP_ENV !== 'development') {
        return true; // Don't show errors in production
    } else {
        return false; // Show errors in development
    }
}
set_error_handler('customErrorHandler');

// Security headers
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
if (APP_ENV === 'production') {
    header("Content-Security-Policy: default-src 'self'");
}