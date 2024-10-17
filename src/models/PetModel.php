<?php
require_once 'database.php';

class PetModel{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllPets(){
        $query = "SELECT * FROM pets";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPetById($id){
        $query = "SELECT * FROM pets WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertPet($name, $type, $age){
        $query = "INSERT INTO pets (pet_name, pet_type, pet_age) VALUES (:name, :type, :age)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':age', $age);
        return $stmt->execute();
    }

    public function updatePet($id, $name, $type, $age){
        $query = "UPDATE pets SET pet_name=:name, pet_type=:type, pet_age=:age WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deletePet($id){
        $query = "DELETE FROM pets WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
