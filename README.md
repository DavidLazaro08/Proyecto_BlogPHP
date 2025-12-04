# 🎵 Hidden Sound Atlas

> *Un atlas sonoro oculto dedicado a la música no convencional, donde cada publicación es un viaje a través de sonidos menos mainstream de cualquier género.*

**Proyecto Final - Grado Superior en Desarrollo de Aplicaciones Multiplataforma**  
**Autor:** David Gutiérrez Ortiz  
**Curso:** 2025-2026

---

## 📋 Descripción

**Hidden Sound Atlas** es una plataforma web tipo blog especializada en música alternativa y experimental. El proyecto implementa una arquitectura MVC completa con PHP y MySQL, combinando funcionalidad robusta con una experiencia visual inmersiva inspirada en ambientes submarinos y espaciales.

### ✨ Características Principales

- 🎨 **Diseño Visual Inmersivo** - Transiciones suaves y efectos que evocan sensaciones submarinas
- 🎵 **Música Ambiente** - Reproducción integrada de "Sirena" de Robert Rich y Alio Die
- 👥 **Sistema de Roles** - Jerarquía User → Editor → Admin con permisos diferenciados
- 📝 **Moderación de Contenido** - Sistema de aprobación de posts por administradores
- 🔐 **Seguridad Robusta** - Password hashing, prepared statements, validación de sesiones

---

## 🚀 Acceso para Revisión

### 🔑 Credenciales de Prueba

| Rol | Usuario | Contraseña | Descripción |
|-----|---------|------------|-------------|
| **Admin** | `admin@hatlas.com` | `1234` | Acceso completo al sistema |
| **Editor** | `Martin@hatlas.com` | `1234` | Puede crear posts (requieren aprobación) |
| **User** | `try@hatlas.com` | `1234` | Usuario básico con solicitud de editor pendiente |

### 🌐 URL de Acceso

```
http://localhost/Proyecto_BlogPHP/public/
```

---

## 🏗️ Arquitectura

### Patrón MVC

```
Usuario → Router → Controller → Model → Database
                       ↓
                     View
```

### Componentes Principales

- **Core** (2 clases)
  - `Router` - Enrutamiento dinámico de peticiones
  - `Database` - Conexión PDO con prepared statements

- **Models** (2 clases)
  - `User` - Gestión de usuarios, roles y solicitudes (17 métodos)
  - `Post` - Gestión de publicaciones y moderación (14 métodos)

- **Controllers** (6 clases)
  - `AuthController` - Autenticación y sesiones
  - `RegisterController` - Registro de usuarios
  - `HomeController` - Página pública y The Blue Room
  - `PostsController` - CRUD de publicaciones
  - `UsersController` - Perfiles de usuario
  - `PanelController` - Panel administrativo completo

---

## 👥 Sistema de Roles

### 🔵 User (Usuario Básico)
- ✅ Acceso a The Blue Room (zona privada)
- ✅ Lectura de posts aprobados
- ✅ Edición de perfil y avatar
- ✅ Solicitar convertirse en Editor
- ❌ No puede crear posts

### ✍️ Editor
- ✅ Todo lo anterior +
- ✅ Crear y editar posts propios
- ✅ Subir imágenes
- ⚠️ Posts requieren aprobación del Admin

### 👑 Admin
- ✅ Todo lo anterior +
- ✅ Aprobar/rechazar posts de Editores
- ✅ Gestionar usuarios (roles, suspensión, eliminación)
- ✅ Gestionar solicitudes de Editor
- ✅ Posts auto-aprobados (sin moderación)

---

## 💻 Tecnologías Utilizadas

### Backend
- **PHP 7.4+** - Lenguaje del servidor
- **MySQL** - Base de datos relacional
- **PDO** - Capa de abstracción con prepared statements

### Frontend
- **HTML5** - Estructura semántica
- **CSS3** - Estilos avanzados con animaciones
- **JavaScript** - Interactividad y efectos dinámicos

### Seguridad
- Password hashing (`password_hash()`)
- Prepared statements (anti SQL Injection)
- Validación de sesiones
- Control de acceso basado en roles
- Validación MIME de archivos

---

## 📁 Estructura del Proyecto

```
Proyecto_BlogPHP/
├── app/
│   ├── controllers/    # 6 controladores MVC
│   ├── models/         # User.php, Post.php
│   ├── core/           # Router.php, Database.php
│   └── views/          # Templates y layouts
├── config/
│   └── config.php      # Configuración de BD
├── public/
│   ├── index.php       # Entry point
│   ├── css/            # Estilos
│   ├── js/             # Scripts
│   ├── avatars/        # Avatares de usuarios
│   └── img_posts/      # Imágenes de posts
├── database/
│   └── schema.sql      # Estructura de BD
└── docs/
    └── *.md            # Documentación técnica
```

---

## 🗄️ Base de Datos

### Tablas Principales

- **users** - Usuarios del sistema (id, username, email, password, role, avatar, active)
- **posts** - Publicaciones (id, title, subtitle, slug, content, visibility, author_id, image, status, views)
- **editor_requests** - Solicitudes para ser Editor (id, user_id, status)

### Relaciones

- `posts.author_id` → `users.id`
- `editor_requests.user_id` → `users.id`

---

## 🔧 Instalación

### Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

### Pasos

1. **Configurar base de datos**
   ```sql
   CREATE DATABASE hidden_sound_atlas;
   ```
   - Importar `database/schema.sql`

2. **Configurar conexión**
   - Editar `config/config.php` con credenciales de BD

3. **Configurar permisos**
   ```bash
   chmod 755 public/avatars
   chmod 755 public/img_posts
   ```

4. **Acceder**
   - Navegar a `http://localhost/Proyecto_BlogPHP/public/`

---

## 🎯 Funcionalidades Destacadas

### The Blue Room
Sala principal privada donde los usuarios registrados pueden explorar el atlas sonoro completo.

### Sistema de Moderación
- Posts de Editores → Estado `pending`
- Admins aprueban/rechazan desde panel
- Posts de Admins → Auto-aprobados

### Gestión de Usuarios
- Cambio de roles dinámico
- Suspensión/activación de cuentas
- Sistema de solicitudes para ser Editor
- Protección del admin principal

### Personalización
- Avatares personalizados
- Edición de perfil (username, email)
- Estadísticas de posts propios

---

## 📊 Documentación Adicional

- **`docs/DOCUMENTACION_TECNICA.md`** - Documentación técnica completa
- **`docs/EVOLUCION_UML.md`** - Comparativa diseño inicial vs final
- **`docs/uml_class_diagram.png`** - Diagrama UML de clases
- **`docs/walkthrough.md`** - Resumen ejecutivo del proyecto

---

## 🎵 Créditos

### Música
- **"Sirena"** - Robert Rich & Alio Die
- Género: Dark Ambient / Drone

### Desarrollo
- **Concepto:** Blog de música no convencional
- **Arquitectura:** MVC con PHP y MySQL
- **Diseño:** Estética submarina/espacial inmersiva

---

## 📄 Licencia

Este proyecto es parte de un trabajo académico para el **Grado Superior en Programación**.

**Autor:** David Gutiérrez Ortiz  
**Año:** 2024-2025

---

**Hidden Sound Atlas** - *Explorando los confines de la música no convencional* 🎵🌊
