<?php

require_once __DIR__ . '/../core/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Buscar usuario por email
    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar contraseña
    public function verifyPassword($passwordIntroducida, $hashGuardado) {
        return password_verify($passwordIntroducida, $hashGuardado);
    }

    // Crear nuevo usuario
    public function create($username, $email, $password, $role = 'user') {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password, role)
                  VALUES (:username, :email, :password, :role)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }
}
