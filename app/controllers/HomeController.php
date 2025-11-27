<?php

require_once __DIR__ . '/../models/Post.php';

class HomeController {

    // --- HOME PÚBLICA ---
    public function publicHome() {
        session_start();

        if (isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=home&action=index");
            exit;
        }

        $postModel = new Post();
        $publicPosts = $postModel->getPublicPostsLimited(2);

        $this->render("layout_public.php", "home/home_public.php", [
            "publicPosts" => $publicPosts
        ]);
    }

    // --- HOME PRIVADA (THE BLUE ROOM) ---
    public function index() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $postModel = new Post();
        $posts = $postModel->getAllPosts();

        $this->render("layout_private.php", "home/home_private.php", [
            "posts" => $posts
        ]);
    }

    private function render($layout, $view, $data = []) {
        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view;
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/' . $layout;
    }
}
