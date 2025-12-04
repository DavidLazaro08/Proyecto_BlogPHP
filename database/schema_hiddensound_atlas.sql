-- ===========================================
--  BASE DE DATOS PRINCIPAL
-- ===========================================
-- HIDDEN SOUND ATLAS — DATABASE SCHEMA
-- Proyecto: Blue Room Blog
-- Autor: David Gutiérrez
-- Archivo definitivo usado en producción por el profesor

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
    views INT DEFAULT 0,

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
--  USUARIO EXTRA TRY (editor desde inicio)
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
--  POSTS OFICIALES (TEXTOS COMPLETOS)
-- ===========================================

INSERT INTO posts (title, subtitle, slug, content, image, visibility, status, author_id)
VALUES
(
  'Películas — La Máquina de Hacer Pájaros',
  'Un clásico argentino que sigue respirando libertad',
  'peliculas-maquina-hacer-pajaros',
  '“Películas” (1977) es una obra que mezcla rock sinfónico, libertad creativa
y una sensibilidad casi cinematográfica. El álbum avanza como una secuencia
de escenas: suaves, vibrantes, explosivas. Es un disco que no envejece porque
nació libre. Cuando Charly García abandonó Serú Girán durante un tiempo,
dejó claro que su búsqueda artística empezaba aquí: melodías impredecibles,
armonías arriesgadas y una producción que todavía hoy suena fresca. “Qué se
puede hacer salvo ver películas”… es una frase que todavía resuena como un
manifiesto: crear también es resistir.',
  '/img_posts/peliculas.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='Echoing_Fracture')
),

(
  'Biosphere — Substrata',
  'Un viaje hacia el silencio polar',
  'biosphere-substrata',
  '“Substrata” es frío, pero nunca distante. Es hielo que respira, nieve que
cruje, montañas que observan. Geir Jens creó un disco que no se mueve: flota.
La música no avanza, te rodea. Es minimalista sin ser vacío, ambiental sin
ser decorativo. Cada nota parece colocada para dejar espacio a la imaginación
del oyente. Un álbum imprescindible en la historia del ambient nórdico.',
  '/img_posts/substrata.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='Marrowline')
),

(
  'Dalëk — From Filthy Tongue of Gods and Griots',
  'Rap industrial desde las sombras',
  'dalek-filthy-tongue',
  'Si el hip hop tuviera un lado oculto, estaría aquí. Dalëk propone un universo
áspero, lleno de ruido, distorsión y poesía política. Más cercano al industrial
y al shoegaze que al rap convencional, “Filthy Tongue…” es un disparo directo:
beats como martillos, voces profundas, ambientes saturados y un mensaje que no
pide permiso para incomodar. No es un disco amable; es un disco necesario.',
  '/img_posts/dalek.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='NightHeron')
),

(
  'Ben Frost — By the Throat',
  'Ambientes amenazantes y belleza helada',
  'ben-frost-by-the-throat',
  'Un álbum que te muerde —literalmente. Frost utiliza texturas salvajes:
respiraciones de lobos, drones afilados, explosiones digitales. “By the
Throat” es un paisaje sonoro extremo, pero también profundamente emocional.
Aquí la tensión nunca baja; es un disco que se siente más que se escucha,
como si una tormenta eléctrica estuviera siempre a punto de caer sobre ti.',
  '/img_posts/by_the_throat.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='AuroraNoise')
),

(
  'Ryoji Ikeda — Dataplex',
  'La belleza matemática hecha sonido',
  'ryoji-ikeda-dataplex',
  'Ikeda convierte datos en arte. “Dataplex” es la representación sonora del
orden perfecto: números, códigos, patrones digitales convertidos en música.
Drones que suben, señales binarias que vibran, glitches que parecen diseñados
con escalpelo. Es música conceptual, sí, pero también física: cada sonido
tiene peso, impacto, intención. Una experiencia casi quirúrgica.',
  '/img_posts/dataplex.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='DavidLazaro08')
),

(
  'Autechre — Confield',
  'El caos hecho geometría',
  'autechre-confield',
  '“Confield” es un laberinto matemático. No es un álbum fácil; es un desafío.
Ritmos fragmentados, estructuras imposibles, melodías que aparecen y 
desaparecen como criaturas electrónicas. Pero debajo del caos hay una lógica
impecable —una geometría interna que solo Autechre entiende. Y aun así,
quienes entran en su universo descubren una belleza nueva, casi alienígena.',
  '/img_posts/confield.jpg',
  'public',
  'approved',
  (SELECT id FROM users WHERE username='MonoAmura')
)
ON DUPLICATE KEY UPDATE slug = slug;

-- ===========================================
--  POST PENDIENTE (TRY) — COMPLETO
-- ===========================================

INSERT INTO posts (title, subtitle, slug, content, image, visibility, status, author_id)
VALUES
(
  'PORCUPINE TREE | SIGNIFY',
  ' Un trabajo infravalorado dentro de una gran discografía',
  'porcupine-tree-|-signify-1764536604',
  'Signify no es simplemente un álbum; es el umbral. Publicado en 1996, captura a Porcupine Tree suspendido en el punto exacto donde la neblina psicodélica de sus inicios se condensa en la arquitectura de rock progresivo melancólico que definiría su legado. Es la primera vez que la alineación clásica —Wilson, Barbieri, Edwin y Maitland— funciona como un cuadrilátero sónico unificado, y se siente: el disco respira con una intención colectiva que trasciende las visiones en solitario.

Este álbum es un viaje por la alienación moderna, un paisaje sonoro donde las melodías vocales etéreas de Steven Wilson flotan sobre cimientos rítmicos que se sienten a la vez industriales y orgánicos. Desde la percusión tribal que da título a la pista "Signify", hasta la hipnosis post-rock de "Waiting Phase One", la banda teje una narrativa de desapego. La joya de la corona, "Every Home Is Wired", captura la paranoia de la conectividad digital antes de que se convirtiera en la norma, con sus loops de piano que evocan una soledad fría y cableada.

La atmósfera es densa, casi tangible. Signify se siente como escuchar la radiofrecuencia de un sueño febril, culminando en la épica y sombría "Dark Matter". Es un trabajo que no ofrece respuestas fáciles, sino que invita al oyente a habitar sus espacios liminales, marcando el momento exacto en que Porcupine Tree dejó de ser un proyecto de culto para convertirse en una fuerza progresiva con una identidad propia e inconfundible. Es un testamento a la transición, un disco que suena a futuro distópico que, con el tiempo, se ha revelado profético.',
  '/img_posts/1764536604_signify.jpg',
  'public',
  'pending',
  82
)
ON DUPLICATE KEY UPDATE slug = slug;
