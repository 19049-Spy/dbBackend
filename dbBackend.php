<?php

class Database {
    private $host = "localhost";
    private $username = "your_username";
    private $password = "your_password";
    private $database = "your_database";
    private $conn;
    
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}

class Entity {
    private $id;
    private $name;
    private $description;
    
    public function __construct($id, $name, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getDescription() {
        return $this->description;
    }
}

class EntityLoader {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function loadEntities() {
        $entities = array();
        
        $sql = "SELECT * FROM entities";
        $result = $this->db->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $entity = new Entity($row["id"], $row["name"], $row["description"]);
                $entities[] = $entity;
            }
        }
        
        return $entities;
    }
}

$db = new Database();
$conn = $db->getConnection();

$loader = new EntityLoader($conn);
$entities = $loader->loadEntities();

echo "<table>";
echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";

foreach ($entities as $entity) {
    echo "<tr><td>" . $entity->getId() . "</td><td>" . $entity->getName() . "</td><td>" . $entity->getDescription() . "</td></tr>";
}

echo "</table>";