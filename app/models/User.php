<?php

require_once __DIR__ . '/../core/Database.php';

class User {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    // ============================================================
    //  LOGIN
    // ============================================================

    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($passwordIntroducida, $hashGuardado) {
        return password_verify($passwordIntroducida, $hashGuardado);
    }


    // ============================================================
    //  BÚSQUEDA DE USUARIO POR ID
    // ============================================================

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


// ============================================================
//  CREAR USUARIO (con avatar y devolución de ID)
// ============================================================

public function create($username, $email, $password, $role = 'user', $avatar = '/avatars/default.jpg') {

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password, role, avatar)
              VALUES (:username, :email, :password, :role, :avatar)";
    
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hash);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':avatar', $avatar);

    $stmt->execute();

    // Devuelve el ID del nuevo usuario
    return $this->conn->lastInsertId();
}


    // ============================================================
    //  LISTAR USUARIOS
    // ============================================================

    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ============================================================
    //  SOLICITUDES PARA SER EDITOR
    // ============================================================

    public function requestEditorRole($userId) {
        $sql = "INSERT INTO editor_requests (user_id) VALUES (:uid)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':uid' => $userId]);
    }

    public function hasPendingEditorRequest($userId) {
        $sql = "SELECT * FROM editor_requests 
                WHERE user_id = :uid AND status='pending'
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEditorRequests() {
        $sql = "SELECT editor_requests.*, users.username, users.avatar 
                FROM editor_requests
                JOIN users ON users.id = editor_requests.user_id
                WHERE status='pending'
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveEditorRequest($requestId) {
        $stmt = $this->conn->prepare("SELECT user_id FROM editor_requests WHERE id=?");
        $stmt->execute([$requestId]);
        $req = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$req) return false;

        $uid = $req['user_id'];

        $this->conn->prepare("UPDATE users SET role='editor' WHERE id=?")
                   ->execute([$uid]);

        return $this->conn->prepare("UPDATE editor_requests SET status='approved' WHERE id=?")
                          ->execute([$requestId]);
    }

    public function rejectEditorRequest($requestId) {
        $sql = "UPDATE editor_requests SET status='rejected' WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$requestId]);
    }


    // ============================================================
    //  NUEVOS MÉTODOS PARA PERFIL
    // ============================================================

    public function updateAvatar($userId, $path) {
        $sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':avatar' => $path,
            ':id' => $userId
        ]);
    }

    public function updateRole($userId, $newRole) {
        $sql = "UPDATE users SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':role' => $newRole,
            ':id' => $userId
        ]);
    }

    public function updateBasicData($id, $username, $email) {
    $sql = "UPDATE users SET username = :u, email = :e WHERE id = :id";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        ':u' => $username,
        ':e' => $email,
        ':id' => $id
    ]);
}

    // ============================================================
    public function updateUserAdmin($id, $username, $email, $role)
    {
        $sql = "UPDATE users 
                SET username = :username,
                    email = :email,
                    role = :role
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':role'     => $role,
            ':id'       => $id
        ]);
    }


    // ============================================================
    //  ELIMINAR USUARIO
    // ============================================================
    public function deleteUserById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ============================================================
    //  ACTIVAR /DESACTIVAR
    // ============================================================
    public function toggleActive($id, $newState)
    {
        $sql = "UPDATE users SET active = :state WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':state' => $newState,
            ':id'    => $id
        ]);
    }



}
