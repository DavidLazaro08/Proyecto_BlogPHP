
--  BASE DE DATOS PRINCIPAL DEL PROYECTO

-- Uso utf8mb4 para permitir emojis y caracteres especiales.
-- En un blog musical es habitual encontrar símbolos, idiomas mezclados
-- y títulos poco convencionales, así que es la mejor configuración.

CREATE DATABASE IF NOT EXISTS hiddensound_atlas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
  
-- ========================================================================

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
    
-- ========================================================================

--  TABLA POSTS
--  Entradas del blog.
--  "author_id" referencia al usuario que creó el post.

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,   -- Slug único para URLs limpias
    content TEXT NOT NULL,
    image VARCHAR(255) NULL,             -- Ruta de imagen pequeña opcional
    visibility ENUM('public', 'private') DEFAULT 'public',
    author_id INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Relación con users (autor del post)
    CONSTRAINT fk_posts_user
        FOREIGN KEY (author_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================

--  USUARIOS SECUNDARIOS PARA POSTS DE EJEMPLO
--  (Contraseña real para todos: 1234)

INSERT INTO users (username, email, password, role, avatar) VALUES
('DavidLazaro08', 'david@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/DavidLazaro08.jpg'),

('AuroraNoise', 'aurora@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/AuroraNoise.jpg'),

('MonoAmura', 'monoamura@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'user', '/avatars/MonoAmura.jpg'),

('Marrowline', 'marrow@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/Marrowline.jpg'),

('Echoing_Fracture', 'fracture@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/Echoing_Fracture.jpg'),

('NightHeron', 'heron@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/NightHeron.jpg')
ON DUPLICATE KEY UPDATE
    username = VALUES(username);


-- POSTS PÚBLICOS (con protección contra duplicados)
INSERT INTO posts (title, subtitle, slug, content, image, visibility, author_id)
VALUES
(
    'Películas — La Máquina de Hacer Pájaros',
    'Un clásico argentino que sigue respirando libertad',
    'peliculas-maquina-hacer-pajaros',
    'El álbum "Películas" (1977), de La Máquina de Hacer Pájaros...',
    '/img_posts/peliculas.jpg',
    'public',
    (SELECT id FROM users WHERE username='Echoing_Fracture')
),
(
    'Biosphere — Substrata',
    'Un viaje hacia el silencio polar',
    'biosphere-substrata',
    'Considerado uno de los pilares del ambient nórdico...',
    '/img_posts/substrata.jpg',
    'public',
    (SELECT id FROM users WHERE username='Marrowline')
),
(
    'Dalëk — From Filthy Tongue of Gods and Griots',
    'Rap industrial desde las sombras',
    'dalek-filthy-tongue',
    'Un referente del hip hop industrial, donde...',
    '/img_posts/dalek.jpg',
    'public',
    (SELECT id FROM users WHERE username='NightHeron')
),
(
    'Ben Frost — By the Throat',
    'Ambientes amenazantes y belleza helada',
    'ben-frost-by-the-throat',
    'Un disco brutal, frío y emocionalmente peligroso...',
    '/img_posts/by_the_throat.jpg',
    'public',
    (SELECT id FROM users WHERE username='AuroraNoise')
),
(
    'Ryoji Ikeda — Dataplex',
    'La belleza matemática hecha sonido',
    'ryoji-ikeda-dataplex',
    'Minimalismo digital llevado al extremo...',
    '/img_posts/dataplex.jpg',
    'public',
    (SELECT id FROM users WHERE username='DavidLazaro08')
),
(
    'Autechre — Confield',
    'El caos hecho geometría',
    'autechre-confield',
    'Una obra clave del IDM abstracto...',
    '/img_posts/confield.jpg',
    'public',
    (SELECT id FROM users WHERE username='MonoAmura')
)
ON DUPLICATE KEY UPDATE
    title = VALUES(title);   -- Update mínimo para evitar error
;

-- ==============================================
-- NUEVO CAMPO STATUS EN POSTS
-- ==============================================

/* ALTER TABLE posts
    ADD COLUMN status ENUM('draft','pending','approved') 
    NOT NULL DEFAULT 'approved'
    AFTER visibility; */


