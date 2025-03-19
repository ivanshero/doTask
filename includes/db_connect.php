<?php
/**
 * Database Connection Manager
 * Current Date and Time (UTC): 2025-03-19 00:00:09
 * Current User: ivanshero
 */

// Include configuration
require_once 'config.php';

class DatabaseManager {
    private static $instance = null;
    private $pdo;
    private $isConnected = false;
    private $statement;
    private $lastInsertId = null;
    private $transactionCount = 0;

    /**
     * Connect to the database using singleton pattern
     */
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true
            ];

            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            $this->isConnected = true;
            
            // Log connection
            $this->logActivity('Database connection established');
        } catch (PDOException $e) {
            $this->logError('Connection Error: ' . $e->getMessage());
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get Singleton instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Execute a query with parameters
     */
    public function query($query, $params = []) {
        try {
            $this->statement = $this->pdo->prepare($query);
            $this->statement->execute($params);
            $this->lastInsertId = $this->pdo->lastInsertId();
            return $this;
        } catch (PDOException $e) {
            $this->logError('Query Error: ' . $e->getMessage() . ' in query: ' . $query);
            throw new Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Fetch a single row
     */
    public function fetch() {
        return $this->statement->fetch();
    }

    /**
     * Fetch all rows
     */
    public function fetchAll() {
        return $this->statement->fetchAll();
    }

    /**
     * Get row count
     */
    public function rowCount() {
        return $this->statement->rowCount();
    }

    /**
     * Get the last inserted ID
     */
    public function lastInsertId() {
        return $this->lastInsertId;
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction() {
        if ($this->transactionCount == 0) {
            $this->pdo->beginTransaction();
        }
        $this->transactionCount++;
        return $this;
    }

    /**
     * Commit a transaction
     */
    public function commit() {
        if ($this->transactionCount == 1) {
            $this->pdo->commit();
        }
        $this->transactionCount = max(0, $this->transactionCount - 1);
        return $this;
    }

    /**
     * Rollback a transaction
     */
    public function rollback() {
        if ($this->transactionCount == 1) {
            $this->pdo->rollBack();
        }
        $this->transactionCount = max(0, $this->transactionCount - 1);
        return $this;
    }

    /**
     * Log database activity for debugging
     */
    private function logActivity($message) {
        if (DEBUG_MODE) {
            $logMessage = date('[Y-m-d H:i:s]') . " {$message}" . PHP_EOL;
            error_log($logMessage, 3, LOGS_PATH . '/db_activity.log');
        }
    }

    /**
     * Log database errors
     */
    private function logError($message) {
        $logMessage = date('[Y-m-d H:i:s]') . " {$message}" . PHP_EOL;
        error_log($logMessage, 3, LOGS_PATH . '/db_error.log');
    }

    /**
     * Close the connection
     */
    public function close() {
        $this->pdo = null;
        $this->isConnected = false;
        self::$instance = null;
    }

    /**
     * Prevent cloning
     */
    private function __clone() { }

    /**
     * Prevent unserialization
     */
    public function __wakeup() { 
        throw new Exception('Cannot unserialize singleton');
    }
}

// Create a global instance for easy access
$db = DatabaseManager::getInstance();