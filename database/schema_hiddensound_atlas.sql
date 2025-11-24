
--  BASE DE DATOS PRINCIPAL DEL PROYECTO

-- Uso utf8mb4 para permitir emojis y caracteres especiales.
-- En un blog musical es habitual encontrar símbolos, idiomas mezclados
-- y títulos poco convencionales, así que es la mejor configuración.

CREATE DATABASE IF NOT EXISTS hiddensound_atlas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE hiddensound_atlas;

--  TABLA USERS
--  Sistema de usuarios con roles y avatar opcional.
--  Los roles permiten diferenciar administradores,
--  editores que crean contenido y usuarios normales.

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,               -- Ruta del avatar del usuario (opcional)
    role ENUM('admin','editor','user') DEFAULT 'user',
    active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

--  INSERT ADMIN INICIAL
--  Con la cláusula "ON DUPLICATE KEY UPDATE" evitamos errores
--  si el script se ejecuta más de una vez durante el desarrollo.
--  En una ejecución limpia, insertará al admin sin problema.

INSERT INTO users (username, email, password, role)
VALUES (
    'admin',
    'admin@hatlas.com',
    '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
    'admin'
)
ON DUPLICATE KEY UPDATE
    username = VALUES(username);  -- Pequeña actualización simbólica

--  TABLA POSTS
--  Entradas del blog.
--  "is_public" permite controlar si es visible sin login.
--  "slug" servirá para URLs amigables en un futuro.
--  "author_id" referencia al usuario que creó el post.

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    author_id INT UNSIGNED,
    is_public TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
