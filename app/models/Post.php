<?php

require_once __DIR__ . '/../core/Database.php';

class Post {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // ============================================================
    //   Obtener posts públicos (todos)
    // ============================================================
    public function getPublicPosts() {
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                WHERE posts.visibility = 'public'
                ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Obtener posts públicos LIMITADOS (para home pública)
    // ============================================================
    public function getPublicPostsLimited($limit = 2) {
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                WHERE posts.visibility = 'public'
                ORDER BY posts.created_at DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Obtener TODOS los posts (The Blue Room)
    // ============================================================
    public function getAllPosts() {
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Crear nuevo post
    // ============================================================
    public function createPost($title, $subtitle, $slug, $content, $visibility, $author_id, $image = null, $status = 'pending') {

    $sql = "INSERT INTO posts (title, subtitle, slug, content, visibility, author_id, image, status)
            VALUES (:title, :subtitle, :slug, :content, :visibility, :author_id, :image, :status)";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':subtitle', $subtitle);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':visibility', $visibility);
    $stmt->bindParam(':author_id', $author_id);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':status', $status);

    return $stmt->execute();
}

    // ============================================================
    //   Obtener un post por ID
    // ============================================================
    public function getPostById($id)
{
    $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
