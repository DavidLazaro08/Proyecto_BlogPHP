
-- Creamos la base de datos del proyecto del blog.
-- Uso utf8mb4 y unicode_ci porque leí que son recomendables
-- para sitios con textos variados, acentos y símbolos.
-- En un blog musical puede haber títulos especiales, emojis o idiomas,
-- así que es mejor dejar el conjunto de caracteres preparado.

CREATE DATABASE IF NOT EXISTS hiddensound_atlas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE hiddensound_atlas;

-- Tabla de usuarios para Hidden Sound Atlas
-- Incluye tres roles: admin, editor y user.
-- Preparamos la tabla para un blog moderno con seguridad básica y control de estados.

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','editor','user') DEFAULT 'user',
    active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, email, password, role)
VALUES (
    'admin',
    'admin@hatlas.com',
    '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
    'admin'
);



