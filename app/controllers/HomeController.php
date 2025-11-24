<?php

// Necesario para poder usar el modelo Post
require_once __DIR__ . '/../models/Post.php';

class HomeController {

    // PARTE PÚBLICA DEL BLOG (sin login)
    // ================================================================

    public function publicHome() {

        // No iniciamos sesión obligatoriamente aquí,
        // pero la iniciamos por si existe ya una sesión previa.
        session_start();

        // Si ya está logueado lo mandamos a The Blue Room
        if (isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=home&action=index");
            exit;
        }

        // Cargar la vista pública
        require_once __DIR__ . '/../views/home_public.php';
    }

    // ZONA PRIVADA — THE BLUE ROOM
    // ================================================================

    public function index() {
        session_start();

        // Si NO está logueado forzamos el login
        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        // Cargar todos los posts (públicos + privados)
        $postModel = new Post();
        $posts = $postModel->getAllPosts();

        // Contenido de introducción para The Blue Room
        $content = "
            <h2>Bienvenido a The Blue Room</h2>
            <p>Ya formas parte del corazón de Hidden Sound Atlas.</p>
            <p>Aquí podrás ver los posts completos, comentar,
            y si eres editor o admin, crear las próximas entradas.</p>
        ";

        require_once __DIR__ . '/../views/layout.php';
    }
}
