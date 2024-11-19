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

    // Establish connection to the database and return PDO instance
    protected function connect()
    {
        
        try {
            $this->pdo = new PDO($this->dsn, $this->dbusername, $this->dbpwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch (PDOException $e) {
            die("Connection failed due to: " . $e->getMessage());
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
            echo "Failed to get table names: " . $e->getMessage();
        }
    }

    public function fetchTableNameData($tableName)
    {
    try {
        // Create the SQL query string dynamically
        $sql = "SELECT * FROM " . $tableName;
        $stmt = $this->connect()->query($sql);
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    } catch (PDOException $e) {
        echo "Failed to get table name data: " . $e->getMessage();
    }
}


}
