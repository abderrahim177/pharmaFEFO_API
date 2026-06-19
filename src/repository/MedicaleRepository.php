<?php
require_once __DIR__ . '/../../config/database.php';

class MedicaleRepository{
    private PDO $pdo;
    
    public function __construct(PDO $pdo){
         $this->pdo = $pdo;
    }
     public function insertProduct($product_name, $product_lot, $unit_price,$date_expiration, $quantity, $Emplacement) {
    try {
        $this->pdo->beginTransaction();
        $queryProduct = 'INSERT INTO product (name, description, unit_price, Emplacement, created_at) 
                         VALUES (:name, :description, :unit_price, :Emplacement, NOW())';        
        $stmtProduct = $this->pdo->prepare($queryProduct);
        $stmtProduct->execute([
            ':name'        => $product_name,
            ':Emplacement' => $Emplacement,
            ':description' => 'No description provided', 
            ':unit_price'  => $unit_price,
        ]);
        $productId = $this->pdo->lastInsertId();
        
        if (!$productId) {
            throw new Exception("Impossible de récupérer l'ID du produit inséré.");
        }
        $queryLot = 'INSERT INTO lots (product_id, lot_number, expiratio_date, quantity,created_at) 
                     VALUES (:product_id, :lot_number, :expiration_date, :quantity, NOW())';       
        $stmtLot = $this->pdo->prepare($queryLot);
        $stmtLot->execute([
            ':product_id'      => $productId,      
            ':lot_number'      => $product_lot,
            ':expiration_date' => $date_expiration,
            ':quantity'        => $quantity,    
        ]);
        $this->pdo->commit();
        return true;
        
    } catch (PDOException $e) {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
        throw new Exception("Erreur DB: " . $e->getMessage());
    }
}
 public function GetAllProducts() {
    try {
        $query = 'SELECT 
                    p.name AS product_name, 
                    p.Emplacement, 
                    l.lot_number, 
                    l.expiration_date,  
                    l.status
                  FROM products p
                  INNER JOIN lots l ON p.id = l.product_id
                  ORDER BY l.expiration_date ASC';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();       
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException) {
        return [];
    }
}
public function GeteTotaleLots(){
    try{
        $query = 'SELECT count(lots.id) FROM lots';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }catch (PDOException) {
        return 0;
    }
}
}