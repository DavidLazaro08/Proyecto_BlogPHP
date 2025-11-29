<?php

require_once __DIR__ . '/../core/Database.php';

class Post {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // ============================================================
    //   Obtener posts públicos (todos, aprobados)
    // ============================================================
    public function getPublicPosts() {
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                WHERE posts.visibility = 'public'
                AND posts.status = 'approved'
                ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Obtener posts públicos LIMITADOS (Home)
    // ============================================================
    public function getPublicPostsLimited($limit = 2) {
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                WHERE posts.visibility = 'public'
                AND posts.status = 'approved'
                ORDER BY posts.created_at DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Obtener TODOS los posts (privado, admin)
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
    //   Crear nuevo post (por defecto status = pending)
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
    public function getPostById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPostsByUser($userId) {
        $sql = "SELECT * FROM posts WHERE author_id = :uid ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Posts según rol (CORREGIDO)
    // ============================================================
    public function getPostsByRole($role, $userId) {

        // -----------------------------------------------------------
        // ADMIN — Ve absolutamente todo
        // -----------------------------------------------------------
        if ($role === 'admin') {
            $sql = "SELECT posts.*, users.username, users.avatar
                    FROM posts
                    JOIN users ON posts.author_id = users.id
                    ORDER BY posts.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // -----------------------------------------------------------
        // EDITOR — Ve TODO lo suyo + aprobados públicos
        // -----------------------------------------------------------
        if ($role === 'editor') {

            $sql = "SELECT posts.*, users.username, users.avatar
                    FROM posts
                    JOIN users ON posts.author_id = users.id
                    WHERE posts.author_id = :uid
                    OR (posts.status = 'approved' AND posts.visibility = 'public')
                    ORDER BY posts.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':uid', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // -----------------------------------------------------------
        // USER — Solo ve aprobados + públicos
        // -----------------------------------------------------------
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                WHERE posts.status = 'approved'
                AND posts.visibility = 'public'
                ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Obtener pendientes para moderación (admin)
    // ============================================================
    public function getPendingPosts() {
        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                WHERE posts.status = 'pending'
                ORDER BY posts.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    //   Aprobar post
    // ============================================================
    public function approvePost($postId) {
        $sql = "UPDATE posts SET status = 'approved' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$postId]);
    }

    // ============================================================
    //   Rechazar post
    // ============================================================
    public function rejectPost($postId) {
        $sql = "UPDATE posts SET status = 'rejected' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$postId]);
    }

    public function deletePost($postId) {

    // Primero obtenemos el post para saber si tiene imagen
    $stmt = $this->conn->prepare("SELECT image FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si tiene imagen, la borramos físicamente
    if ($post && !empty($post['image'])) {

        $filePath = __DIR__ . "/../../public" . $post['image'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

        // Borrar el registro de la BD
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$postId]);
    }

    // ============================================================
    //   Obtener TODOS los posts para moderación (ordenados)
    //   Pendientes → Borradores → Aprobados → Rechazados
    // ============================================================
    public function getAllPostsForModeration() {

        $sql = "SELECT posts.*, users.username, users.avatar
                FROM posts
                JOIN users ON posts.author_id = users.id
                ORDER BY 
                    CASE 
                        WHEN posts.status = 'pending' THEN 1
                        WHEN posts.status = 'draft' THEN 2
                        WHEN posts.status = 'approved' THEN 3
                        WHEN posts.status = 'rejected' THEN 4
                        ELSE 5
                    END,
                    posts.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
