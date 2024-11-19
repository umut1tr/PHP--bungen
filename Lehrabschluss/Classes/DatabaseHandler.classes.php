<?php

class DatabaseHandler {
    private $dsn = "mysql:host=localhost;dbname=information_schema";
    private $dbusername = "root";
    private $dbpwd = "";
    private $pdo = null;

    public function __construct() 
    {
        // Optional: Initialize $pdo or other startup tasks
    }

    // Log errors to a file
    private function logError($message) {
        error_log($message, 3, 'error_log.txt');
    }

    // Establish connection to the database and return PDO instance
    protected function connect()
    {
        // ensure to only establish one connection
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO($this->dsn, $this->dbusername, $this->dbpwd);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
            } catch (PDOException $e) {
                $this->logError("Connection failed: " . $e->getMessage());
                die("Connection failed. Check logs for details.");
            }
        }
        
        return $this->pdo;
    }

    public function getTableNames()
    {
        try {
            $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES;";
            $stmt = $this->connect()->query($sql);
            $tablenames = [];
            foreach ($stmt as $row) {
                $tablenames[] = $row["TABLE_NAME"];
            }
            return $tablenames;
        } catch (PDOException $e) {
            $this->logError("Failed to get table names: " . $e->getMessage());
            echo "Failed to get table names.";
        }
    }

    public function fetchTableNameData($tableName)
    {
        try {
            $tableName = htmlspecialchars($tableName, ENT_QUOTES, 'UTF-8'); // Sanitize input
            $sql = "SELECT * FROM " . $tableName;
            $stmt = $this->connect()->query($sql);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $this->logError("Failed to get table name data: " . $e->getMessage());
            echo "Failed to get table name data.";
        }
    }
}
