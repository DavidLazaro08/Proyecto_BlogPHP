<?php

class HomeController {

    public function index() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Proyecto_BlogPHP/public/?controller=auth&action=loginForm");
            exit;
        }

        $content = "
            <h2>Bienvenido a Hidden Sound Atlas</h2>
            <p>Explora sonidos, discos, artistas y rincones ocultos del mapa musical.</p>

            <p>Estás dentro de <strong>The Blue Room</strong>. Muy pronto aquí verás:
            <ul>
                <li>Entradas del blog</li>
                <li>Reseñas</li>
                <li>Artistas underground</li>
                <li>Listas y recomendaciones</li>
            </ul>
            </p>
        ";

        require_once __DIR__ . '/../views/layout.php';
    }
}