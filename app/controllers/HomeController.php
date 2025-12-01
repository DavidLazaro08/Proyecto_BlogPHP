<?php

require_once __DIR__ . '/../models/Post.php';

class HomeController
{
    // ==========================
    //  HOME PÚBLICA (visitantes)
    // ==========================
    public function publicHome()
    {
        session_start();

        // Si ya está logueado, lo mandamos directo a The Blue Room
        if (isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=home&action=index");
            exit;
        }

        $postModel   = new Post();
        $publicPosts = $postModel->getPublicPostsLimited(2);

        // Vista pública sin layout (home_public.php ya incluye el HTML completo)
        require __DIR__ . '/../views/home/home_public.php';
    }

    // ==========================
    //  BLUE ROOM (zona privada)
    // ==========================
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $postModel = new Post();
        $posts     = $postModel->getAllPosts();

        // Cargar contenido dentro del layout privado
        $this->renderPrivate("posts/index.php", [
            'posts' => $posts
        ]);
    }

    // ==========================
    //  MOTOR DE RENDER PRIVADO
    // ==========================
    private function renderPrivate($view, $data = [])
    {
        extract($data);

        ob_start();
        require __DIR__ . '/../views/' . $view;
        $content = ob_get_clean();

        require __DIR__ . '/../views/layout/layout_private.php';
    }
}
