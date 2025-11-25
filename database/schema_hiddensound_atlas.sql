
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

INSERT INTO users (username, email, password, role, avatar)
VALUES
('DavidLazaro08', 'david@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/david.jpg'),

('AuroraNoise', 'aurora@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'editor', '/avatars/aurora.jpg'),

('MonoAmura', 'monoamura@hatlas.com',
 '$2y$10$8Dcq4wtgaJnwwuQuAkTLIe6RvM5HKAPlE/eb3fa21ab9B8XdAZ97K',
 'user', '/avatars/mono.jpg');

-- ========================================================================

--  POSTS DE EJEMPLO (PÚBLICOS)
--  Solo visibles parcialment en home_public

INSERT INTO posts (title, subtitle, slug, content, image, visibility, author_id)
VALUES
(
    'Películas — La Máquina de Hacer Pájaros',
    'Un clásico argentino que sigue respirando libertad',
    'peliculas-maquina-hacer-pajaros',
    'El álbum "Películas" (1977), de La Máquina de Hacer Pájaros, sigue siendo un manifiesto sonoro de libertad creativa. El teclado protagonista, las armonías ricas y la estructura casi cinematográfica demuestran un nivel instrumental pocas veces visto en el rock progresivo latinoamericano...',
    '/img_posts/peliculas.jpg',
    'public',
    (SELECT id FROM users WHERE username='admin')
),

(
    'Biosphere — Substrata',
    'Un viaje hacia el silencio polar',
    'biosphere-substrata',
    'Considerado uno de los pilares del ambient nórdico, "Substrata" (1997) se sumerge en paisajes helados, respiraciones mínimas y atmósferas que parecen congelar el aire. El disco se escucha como una expedición introspectiva más que como un álbum tradicional...',
    '/img_posts/substrata.jpg',
    'public',
    (SELECT id FROM users WHERE username='DavidLazaro08')
),

(
    'Kamisama Undercity — Ruido devocional',
    'Rap industrial desde los túneles de Tokio',
    'kamisama-undercity',
    'Un proyecto underground que mezcla rap japonés áspero, distorsión digital y percusiones metálicas. “Ruido devocional” es un disco denso, sucio y fascinante, donde cada verso parece grabado en un túnel de metro abandonado...',
    '/img_posts/kamisama.jpg',
    'public',
    (SELECT id FROM users WHERE username='MonoAmura')
),

(
    'Aurora Noise Ensemble — The Sleeping Engine',
    'Drones metálicos y belleza mecánica',
    'aurora-noise-ensemble',
    'Una obra contemporánea que combina drones profundos, texturas metálicas y ruidos procesados con elegancia quirúrgica. "The Sleeping Engine" es un álbum que late como si fuese un organismo creado enteramente con máquinas...',
    '/img_posts/aurora_engine.jpg',
    'public',
    (SELECT id FROM users WHERE username='AuroraNoise')
);

