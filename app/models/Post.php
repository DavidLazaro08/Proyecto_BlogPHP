<?php

require_once __DIR__ . '/../core/Database.php';

class Post {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Obtener todos los posts públicos (zona pública del blog)
    public function getPublicPosts() {
        $sql = "SELECT p.*, u.username AS author 
                FROM posts p
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.is_public = 1
                ORDER BY p.created_at DESC";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los posts (para zona privada)
    public function getAllPosts() {
        $sql = "SELECT p.*, u.username AS author 
                FROM posts p
                LEFT JOIN users u ON p.author_id = u.id
                ORDER BY p.created_at DESC";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un post por ID (útil para leerlo completo)
    public function getPostById($id) {
        $sql = "SELECT p.*, u.username AS author 
                FROM posts p
                LEFT JOIN users u ON p.author_id = u.id
                WHERE p.id = :id
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un post nuevo
    public function create($title, $content, $slug, $authorId, $isPublic = 0) {
        $sql = "INSERT INTO posts (title, content, slug, author_id, is_public)
                VALUES (:title, :content, :slug, :author_id, :is_public)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":author_id", $authorId);
        $stmt->bindParam(":is_public", $isPublic);

        return $stmt->execute();
    }
}
