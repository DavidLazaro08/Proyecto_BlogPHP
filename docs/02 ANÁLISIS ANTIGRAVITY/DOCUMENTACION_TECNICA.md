# 🎵 Hidden Sound Atlas - Documentación Técnica

![The Blue Room](../public/img/logo.png)

> *"Un atlas sonoro oculto dedicado a la música no convencional, donde cada publicación es un viaje a través de sonidos menos mainstream de cualquier género."*

---

## 📖 Índice

1. [Descripción del Proyecto](#-descripción-del-proyecto)
2. [Concepto y Filosofía](#-concepto-y-filosofía)
3. [Arquitectura del Sistema](#-arquitectura-del-sistema)
4. [Sistema de Roles y Permisos](#-sistema-de-roles-y-permisos)
5. [Flujo de Usuario](#-flujo-de-usuario)
6. [Estructura del Proyecto](#-estructura-del-proyecto)
7. [Tecnologías Utilizadas](#-tecnologías-utilizadas)
8. [Características Principales](#-características-principales)
9. [Diagrama UML](#-diagrama-uml)

---

## 🎯 Descripción del Proyecto

**Hidden Sound Atlas** es una plataforma web tipo blog especializada en música no convencional y géneros menos mainstream. El proyecto combina una arquitectura técnica robusta basada en el patrón MVC con una experiencia visual inmersiva que evoca sensaciones submarinas y espaciales.

### Características Clave
- 🎨 **Diseño Visual Inmersivo**: Transiciones suaves y efectos lentos que crean una atmósfera única
- 🎵 **Música Ambiente Integrada**: Reproducción de "Sirena" de Robert Rich y Alio Die
- 🔐 **Sistema de Roles Jerárquico**: User → Editor → Admin
- 📝 **Moderación de Contenido**: Sistema de aprobación de posts
- 👤 **Gestión de Usuarios**: Perfiles personalizables y solicitudes de permisos

---

## 🌊 Concepto y Filosofía

### The Blue Room

**The Blue Room** es el corazón de Hidden Sound Atlas, la sala principal a la que acceden los usuarios registrados. Este espacio representa un refugio sonoro donde los exploradores musicales pueden:

- Descubrir publicaciones sobre música alternativa y experimental
- Sumergirse en una experiencia visual que complementa el contenido auditivo
- Contribuir al atlas con sus propios hallazgos musicales (según permisos)

### Estética Visual

El diseño del proyecto está inspirado en:
- 🌊 **Ambientes submarinos**: Movimientos fluidos y orgánicos
- 🌌 **Espacios cósmicos**: Profundidad y misterio
- 🎵 **Música ambient**: Calma, contemplación y descubrimiento

Las transiciones lentas y efectos visuales crean una experiencia que invita a la exploración pausada, perfecta para contenido musical que requiere atención y apreciación.

---

## 🏗️ Arquitectura del Sistema

Hidden Sound Atlas está construido siguiendo el patrón **MVC (Model-View-Controller)**, garantizando una separación clara de responsabilidades y facilitando el mantenimiento y escalabilidad.

```
┌─────────────────────────────────────────────────────────┐
│                    USUARIO / NAVEGADOR                   │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                   public/index.php                       │
│                   (Entry Point)                          │
└─────────────────────┬───────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────┐
│                    ROUTER (Core)                         │
│   Enruta peticiones a controladores específicos         │
└─────────────────────┬───────────────────────────────────┘
                      │
        ┌─────────────┼─────────────┐
        ▼             ▼             ▼
┌──────────────┐ ┌──────────┐ ┌──────────────┐
│ Controllers  │ │ Controllers│ │ Controllers  │
│   Auth       │ │   Posts   │ │   Panel      │
│   Register   │ │   Users   │ │   Home       │
└──────┬───────┘ └─────┬────┘ └──────┬───────┘
       │               │              │
       └───────────────┼──────────────┘
                       ▼
              ┌─────────────────┐
              │     MODELS      │
              │   User / Post   │
              └────────┬────────┘
                       │
                       ▼
              ┌─────────────────┐
              │    DATABASE     │
              │  (MySQL + PDO)  │
              └─────────────────┘
```

### Componentes Principales

#### 🎯 Core (Infraestructura)
- **Router**: Gestiona el enrutamiento dinámico de peticiones
- **Database**: Maneja la conexión PDO a MySQL con prepared statements

#### 📦 Models (Capa de Datos)
- **User**: Gestión completa de usuarios (17 métodos)
- **Post**: Gestión de publicaciones (14 métodos)

#### 🎮 Controllers (Capa de Lógica)
- **AuthController**: Autenticación y sesiones
- **RegisterController**: Registro de nuevos usuarios
- **HomeController**: Páginas principales (pública y The Blue Room)
- **PostsController**: Gestión de publicaciones
- **UsersController**: Perfiles y configuración de usuario
- **PanelController**: Panel administrativo (15 métodos)

#### 🎨 Views (Capa de Presentación)
- Layouts públicos y privados
- Vistas específicas por funcionalidad
- Sistema de renderizado con buffering

---

## 👥 Sistema de Roles y Permisos

Hidden Sound Atlas implementa un sistema jerárquico de tres niveles de acceso:

### 🔵 User (Usuario Básico)

**Acceso tras registro**

Permisos:
- ✅ Ver la página pública de Hidden Sound Atlas
- ✅ Leer todos los posts aprobados y públicos
- ✅ Acceder a The Blue Room (zona privada)
- ✅ Ver su perfil personal
- ✅ Editar información básica (username, email)
- ✅ Cambiar avatar personal
- ✅ Solicitar convertirse en Editor

Restricciones:
- ❌ No puede crear posts
- ❌ No puede moderar contenido
- ❌ No puede gestionar otros usuarios

### ✍️ Editor

**Acceso mediante solicitud aprobada por Admin**

Permisos heredados de User +
- ✅ Crear nuevos posts sobre música
- ✅ Subir imágenes para posts
- ✅ Ver sus propios posts (pendientes, aprobados, rechazados)
- ✅ Editar sus posts propios

Restricciones:
- ❌ Posts creados requieren aprobación del Admin
- ❌ No puede aprobar/rechazar posts de otros
- ❌ No puede gestionar usuarios

### 👑 Admin (Administrador)

**Acceso completo al sistema**

Permisos heredados de Editor +
- ✅ **Posts auto-aprobados**: No requieren moderación
- ✅ Aprobar o rechazar posts de Editores
- ✅ Eliminar cualquier post
- ✅ Ver panel de moderación completo
- ✅ Gestionar todos los usuarios del sistema
- ✅ Cambiar roles de usuarios
- ✅ Suspender/activar cuentas de usuario
- ✅ Eliminar usuarios (excepto admin principal)
- ✅ Gestionar solicitudes de Editor
- ✅ Acceso al dashboard administrativo

---

## 🔄 Flujo de Usuario

### 1️⃣ Visitante Anónimo

```
Página Pública → Ver posts destacados → [Registro] o [Login]
```

**Experiencia**:
- Visualiza la landing page de Hidden Sound Atlas
- Puede leer un número limitado de posts públicos
- Acceso a formularios de registro y login

### 2️⃣ Usuario Registrado (User)

```
Login → The Blue Room → Explorar posts → Leer contenido → Editar perfil
                                                         ↓
                                                  [Solicitar ser Editor]
```

**Experiencia**:
- Acceso completo a The Blue Room
- Lectura ilimitada de posts aprobados
- Personalización de perfil y avatar
- Posibilidad de solicitar permisos de Editor

### 3️⃣ Editor

```
The Blue Room → [+ Crear nuevo post] → Escribir contenido → Enviar
                                                              ↓
                                                    Estado: PENDIENTE
                                                              ↓
                                              [Espera aprobación Admin]
                                                              ↓
                                                    APROBADO / RECHAZADO
```

**Experiencia**:
- Puede crear posts con título, subtítulo, contenido e imagen
- Los posts pasan por moderación
- Recibe feedback sobre aprobación/rechazo
- Puede ver estadísticas de sus publicaciones

### 4️⃣ Admin

```
The Blue Room → Panel Admin → [Gestionar Posts] → Aprobar/Rechazar
                            ↓
                     [Gestionar Usuarios] → Cambiar roles / Suspender
                            ↓
                  [Solicitudes Editor] → Aprobar/Rechazar solicitudes
```

**Experiencia**:
- Dashboard completo con estadísticas
- Control total sobre contenido y usuarios
- Posts propios se publican automáticamente
- Moderación eficiente con vistas especializadas

---

## 📁 Estructura del Proyecto

```
Proyecto_BlogPHP/
│
├── 📂 app/
│   ├── 📂 controllers/          # Controladores MVC
│   │   ├── AuthController.php
│   │   ├── RegisterController.php
│   │   ├── HomeController.php
│   │   ├── PostsController.php
│   │   ├── UsersController.php
│   │   └── PanelController.php
│   │
│   ├── 📂 models/               # Modelos de datos
│   │   ├── User.php
│   │   └── Post.php
│   │
│   ├── 📂 core/                 # Infraestructura
│   │   ├── Database.php
│   │   └── Router.php
│   │
│   └── 📂 views/                # Vistas y templates
│       ├── 📂 layout/           # Layouts base
│       ├── 📂 auth/             # Login/Registro
│       ├── 📂 home/             # Páginas principales
│       ├── 📂 posts/            # Gestión de posts
│       ├── 📂 users/            # Perfiles
│       └── 📂 panel/            # Panel admin
│
├── 📂 config/
│   └── config.php               # Configuración BD
│
├── 📂 public/                   # Archivos públicos
│   ├── index.php                # Entry point
│   ├── 📂 css/                  # Estilos
│   ├── 📂 js/                   # JavaScript
│   ├── 📂 img_posts/            # Imágenes de posts
│   ├── 📂 avatars/              # Avatares de usuarios
│   └── 📂 audio/                # Música ambiente
│
├── 📂 database/
│   └── schema.sql               # Estructura de BD
│
└── 📂 docs/                     # Documentación
    ├── README.md
    ├── DOCUMENTACION_TECNICA.md
    ├── uml_diagrams.md
    ├── uml_class_diagram.png
    └── walkthrough.md
```

---

## 💻 Tecnologías Utilizadas

### Backend
- **PHP 7.4+**: Lenguaje principal del servidor
- **MySQL**: Base de datos relacional
- **PDO**: Capa de abstracción de base de datos con prepared statements

### Frontend
- **HTML5**: Estructura semántica
- **CSS3**: Estilos avanzados con transiciones y animaciones
- **JavaScript**: Interactividad y efectos dinámicos
- **Responsive Design**: Adaptable a diferentes dispositivos

### Arquitectura
- **MVC Pattern**: Separación de responsabilidades
- **Session Management**: Control de autenticación
- **File Upload System**: Gestión segura de imágenes

### Seguridad
- **Password Hashing**: `password_hash()` y `password_verify()`
- **Prepared Statements**: Protección contra SQL Injection
- **Session Security**: Validación de sesiones en cada petición
- **File Validation**: Verificación MIME de archivos subidos
- **Role-Based Access Control**: Permisos según rol de usuario

---

## ✨ Características Principales

### 🎨 Experiencia Visual Única

**Diseño Inmersivo**
- Transiciones suaves entre secciones
- Efectos de movimiento lento que evocan ambientes submarinos
- Paleta de colores inspirada en profundidades oceánicas y espacios cósmicos
- Tipografía cuidadosamente seleccionada para legibilidad y estética

**Música Ambiente**
- Botón de reproducción integrado
- "Sirena" de Robert Rich y Alio Die como banda sonora
- Control de volumen y reproducción

### 📝 Sistema de Publicaciones

**Creación de Posts**
- Editor de contenido rico
- Campos: Título, Subtítulo, Contenido, Imagen
- Sistema de slugs únicos automáticos
- Visibilidad configurable (público/privado)

**Moderación Inteligente**
- Posts de Editores → Estado `pending`
- Posts de Admin → Estado `approved` automáticamente
- Sistema de aprobación/rechazo con feedback
- Vista de moderación centralizada

**Estadísticas**
- Contador de visualizaciones por post
- Fecha de creación y actualización
- Autor y estado visible

### 👤 Gestión de Usuarios

**Perfiles Personalizables**
- Avatar personalizado (upload de imágenes)
- Información básica editable
- Visualización de posts propios (para Editores/Admins)

**Sistema de Solicitudes**
- Users pueden solicitar ser Editores
- Admins gestionan solicitudes desde panel
- Estados: pending, approved, rejected
- Prevención de solicitudes duplicadas

**Administración Avanzada**
- Listado completo de usuarios
- Edición de roles en tiempo real
- Suspensión/activación de cuentas
- Eliminación segura (protección del admin principal)

### 🔐 Seguridad Robusta

**Autenticación**
- Login con email y contraseña
- Hashing seguro de contraseñas
- Validación de cuentas suspendidas
- Sesiones persistentes

**Validaciones**
- Sanitización de inputs
- Validación de formatos de email
- Verificación de contraseñas coincidentes
- Comprobación de emails duplicados

**Protección de Datos**
- Prepared statements en todas las queries
- Validación MIME de archivos
- Control de acceso basado en roles
- Protección contra inyección SQL

---

## 📊 Diagrama UML

### Diagrama de Clases Completo

El siguiente diagrama muestra la arquitectura completa del sistema, incluyendo todas las clases, sus métodos y las relaciones entre componentes:

![Diagrama UML de Clases - Hidden Sound Atlas](./uml_class_diagram.png)

**Componentes visualizados**:
- 🔵 **Core Layer**: Database y Router
- 🟢 **Models Layer**: User y Post
- 🟠 **Controllers Layer**: 6 controladores especializados

Para ver diagramas adicionales (flujos de autenticación, estados de posts, arquitectura MVC, etc.), consulta el documento completo: [`uml_diagrams.md`](./uml_diagrams.md)

### Estadísticas del Sistema

| Componente | Cantidad |
|------------|----------|
| **Clases totales** | 10 |
| **Modelos** | 2 |
| **Controladores** | 6 |
| **Métodos públicos** | 51 |
| **Métodos privados** | 4 |
| **Archivos PHP** | 28 |
| **Vistas** | 16 |

---

## 🗄️ Base de Datos

### Tablas Principales

#### `users`
Almacena información de todos los usuarios del sistema.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT (PK) | Identificador único |
| `username` | VARCHAR | Nombre de usuario |
| `email` | VARCHAR (UNIQUE) | Correo electrónico |
| `password` | VARCHAR | Hash de contraseña |
| `role` | ENUM | user, editor, admin |
| `avatar` | VARCHAR | Ruta del avatar |
| `active` | BOOLEAN | Estado de la cuenta |
| `created_at` | TIMESTAMP | Fecha de registro |

#### `posts`
Almacena todas las publicaciones del blog.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT (PK) | Identificador único |
| `title` | VARCHAR | Título del post |
| `subtitle` | VARCHAR | Subtítulo |
| `slug` | VARCHAR (UNIQUE) | URL amigable |
| `content` | TEXT | Contenido completo |
| `visibility` | ENUM | public, private |
| `author_id` | INT (FK) | ID del autor |
| `image` | VARCHAR | Ruta de imagen |
| `status` | ENUM | pending, approved, rejected |
| `views` | INT | Contador de visitas |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Última actualización |

#### `editor_requests`
Gestiona solicitudes para convertirse en Editor.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | INT (PK) | Identificador único |
| `user_id` | INT (FK) | ID del usuario solicitante |
| `status` | ENUM | pending, approved, rejected |
| `created_at` | TIMESTAMP | Fecha de solicitud |

### Relaciones

- `posts.author_id` → `users.id` (Muchos a Uno)
- `editor_requests.user_id` → `users.id` (Muchos a Uno)

---

## 🚀 Instalación y Configuración

### Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Extensión PDO de PHP

### Pasos de Instalación

1. **Clonar el proyecto**
   ```bash
   git clone [repository-url]
   cd Proyecto_BlogPHP
   ```

2. **Configurar base de datos**
   - Crear base de datos MySQL
   - Importar `database/schema.sql`
   - Editar `config/config.php` con credenciales

3. **Configurar permisos**
   ```bash
   chmod 755 public/avatars
   chmod 755 public/img_posts
   ```

4. **Acceder a la aplicación**
   - Navegar a `http://localhost/Proyecto_BlogPHP/public/`

### Usuario Admin por Defecto
Crear manualmente en la base de datos o mediante el primer registro con rol 'admin'.

---

## 📝 Notas de Desarrollo

### Convenciones de Código
- **PSR-1**: Estándar básico de código
- **Nombres descriptivos**: Métodos y variables auto-explicativos
- **Comentarios**: Secciones claramente delimitadas
- **Prepared Statements**: Obligatorio en todas las queries

### Buenas Prácticas Implementadas
- ✅ Separación de responsabilidades (MVC)
- ✅ Validación de datos en servidor
- ✅ Sanitización de inputs
- ✅ Manejo de errores
- ✅ Código reutilizable (métodos render)
- ✅ Seguridad por diseño

---

## 🎵 Créditos

### Música
- **"Sirena"** - Robert Rich & Alio Die
- Género: Dark Ambient / Drone

### Desarrollo
- **Proyecto**: Hidden Sound Atlas
- **Subtítulo**: The Blue Room
- **Concepto**: Blog de música no convencional
- **Arquitectura**: MVC con PHP y MySQL

---

## 📄 Licencia

Este proyecto es parte de un trabajo académico para el Grado Superior en Programación.

---

## 📞 Soporte

Para más información sobre la arquitectura técnica, consulta:
- [`uml_diagrams.md`](./uml_diagrams.md) - Diagramas UML completos
- [`walkthrough.md`](./walkthrough.md) - Resumen ejecutivo del análisis

---

**Hidden Sound Atlas** - *Explorando los confines de la música no convencional* 🎵🌊
