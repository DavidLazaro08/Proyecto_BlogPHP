-- ===========================================
--  BASE DE DATOS PRINCIPAL
-- ===========================================
-- HIDDEN SOUND ATLAS — DATABASE SCHEMA
-- Proyecto: Blue Room Blog
-- Autor: David Gutiérrez
-- Archivo definitivo usado en producción

CREATE DATABASE IF NOT EXISTS hiddensound_atlas
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE hiddensound_atlas;

-- ===========================================
--  TABLA USERS
-- ===========================================

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    role ENUM('admin','editor','user') DEFAULT 'user',
    active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin inicial
INSERT INTO users (username, email, password, role, avatar)
VALUES (
    'admin',
    'admin@hatlas.com',
    '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
    'admin',
    '/avatars/Admin.jpg'
)
ON DUPLICATE KEY UPDATE username = VALUES(username);

-- ===========================================
--  TABLA POSTS
-- ===========================================

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    image VARCHAR(255) NULL,
    visibility ENUM('public','private') DEFAULT 'public',
    status ENUM('draft','pending','approved','rejected') NOT NULL DEFAULT 'approved',
    author_id INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_posts_user
        FOREIGN KEY (author_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===========================================
--  TABLA SOLICITUDES DE EDITOR
-- ===========================================

CREATE TABLE IF NOT EXISTS editor_requests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_editor_request_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===========================================
--  USUARIOS DE EJEMPLO
-- ===========================================

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
 'editor', '/avatars/NightHeron.jpg'),

('Martin', 'martin@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/Martin.jpg')

ON DUPLICATE KEY UPDATE username = VALUES(username);

-- ===========================================
--  USUARIO EXTRA: TRY (editor ya desde inicio)
-- ===========================================

INSERT INTO users (id, username, email, password, role, avatar)
VALUES
(
  82,
  'try',
  'try@hatlas.com',
  '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
  'editor',
  '/avatars/default.jpg'
)
ON DUPLICATE KEY UPDATE username = VALUES(username);

-- ===========================================
--  POSTS OFICIALES
-- ===========================================

INSERT INTO posts (title, subtitle, slug, content, image, visibility, status, author_id)
VALUES
(
  'Películas — La Máquina de Hacer Pájaros',
  'Un clásico argentino que sigue respirando libertad',
  'peliculas-maquina-hacer-pajaros',
  '“Películas” (1977) es una obra que mezcla rock sinfónico, libertad creativa...',
  '/img_posts/peliculas.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='Echoing_Fracture')
),

(
  'Biosphere — Substrata',
  'Un viaje hacia el silencio polar',
  'biosphere-substrata',
  '“Substrata” es frío, pero nunca distante...',
  '/img_posts/substrata.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='Marrowline')
),

(
  'Dalëk — From Filthy Tongue of Gods and Griots',
  'Rap industrial desde las sombras',
  'dalek-filthy-tongue',
  'Si el hip hop tuviera un lado oculto, estaría aquí...',
  '/img_posts/dalek.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='NightHeron')
),

(
  'Ben Frost — By the Throat',
  'Ambientes amenazantes y belleza helada',
  'ben-frost-by-the-throat',
  'Un álbum que te muerde —literalmente...',
  '/img_posts/by_the_throat.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='AuroraNoise')
),

(
  'Ryoji Ikeda — Dataplex',
  'La belleza matemática hecha sonido',
  'ryoji-ikeda-dataplex',
  'Ikeda convierte datos en arte...',
  '/img_posts/dataplex.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='DavidLazaro08')
),

(
  'Autechre — Confield',
  'El caos hecho geometría',
  'autechre-confield',
  '“Confield” es un laberinto matemático...',
  '/img_posts/confield.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='MonoAmura')
)

ON DUPLICATE KEY UPDATE title = VALUES(title);

-- ===========================================
--  POST EXTRA: TRY — "PORCUPINE TREE | SIGNIFY" (pendiente)
-- ===========================================

INSERT INTO posts (title, subtitle, slug, content, image, visibility, status, author_id)
VALUES
(
  'PORCUPINE TREE | SIGNIFY',
  'Un trabajo infravalorado dentro de una gran discografía',
  'ptree-signify-try',
  'Signify no es simplemente un álbum; es el umbral. Publicado en 1996...',
  '/img_posts/signify.jpg',
  'public',
  'pending',
  82
)
ON DUPLICATE KEY UPDATE title = VALUES(title);

-- ===========================================
--  AÑADIR COLUMNA DE VISITAS
-- ===========================================

ALTER TABLE posts ADD COLUMN views INT DEFAULT 0;
