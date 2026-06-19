<?php

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../repository/UserRepository.php';

class UserController 
{
    private $repository;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $db = $database->getConnection();
        $this->repository = new UserRepository($db); 
    }
    public function handleRequest() {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            $this->store();
        } elseif ($method === 'GET') {
            $this->index();
        } else {
            $this->sendResponse('error', 'Méthode non autorisée.');
        }
    }
    public function index() {
    try {
        $users = $this->repository->getAllUsers();
        echo json_encode([
            'status' => 'success',
            'data' => $users
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur Database: ' . $e->getMessage()
        ]);
        exit;
    }
}
    public function store() 
    {
        header('Content-Type: application/json');
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            parse_str($json, $data);
        }

        if (!$data || empty($data)) {
            $this->sendResponse('error', 'Aucune donnée reçue.');
        }
        
        $name     = isset($data['name']) ? htmlspecialchars(trim($data['name'])) : '';
        $email    = isset($data['email']) ? htmlspecialchars(trim($data['email'])) : '';
        $password = $data['password'] ?? ''; 
        $role     = isset($data['role']) ? htmlspecialchars(trim($data['role'])) : '';
        $status   = isset($data['status']) ? htmlspecialchars(trim($data['status'])) : '';
        
        if (empty($name) || empty($email) || empty($password)) {
            $this->sendResponse('error', 'Tous les champs (Nom, Email, Mot de passe) sont obligatoires.');
        }
        try { 
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->repository->Adduser($name, $email, $hashedPassword, $role, $status);
            
            $this->sendResponse('success', 'L\'utilisateur ' . $name . ' a été ajouté avec succès !');
        } catch (Exception $e) {
            $this->sendResponse('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }
    private function sendResponse($status, $message) 
    {
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
        exit; 
    }
}
$controller = new UserController();
$controller->handleRequest();