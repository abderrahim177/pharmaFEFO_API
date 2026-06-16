<?php
require_once __DIR__ . '/../../config/database.php';

class UserRepository {
    private PDO $pdo;
    
    public function __construct(PDO $pdo){
         $this->pdo = $pdo;
    }
    public function Adduser($name, $email, $password, $role, $status){
        try {
            $query = 'INSERT INTO users (name, email, password, status, role, created_at) 
                      VALUES (:nom, :email, :password, :status, :role, NOW())';
                      
            $stm = $this->pdo->prepare($query);
                $result = $stm->execute([
                ':nom'      => $name,
                ':email'    => $email,
                ':password' => $password, 
                ':status'   => $status,
                ':role'     => $role
            ]);
            
            return $result;
        } catch (PDOException $e) {
            throw $e; 
        }
    }
}