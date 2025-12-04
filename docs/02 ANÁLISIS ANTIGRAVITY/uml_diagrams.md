# 📐 Diagrama UML Completo - Blog PHP

> [!NOTE]
> Este documento contiene los diagramas UML completos de tu proyecto Blog PHP, incluyendo todas las clases, métodos, propiedades y relaciones entre componentes.

---

## 🎨 Diagrama de Clases Visual

![Diagrama UML completo del sistema Blog PHP](./uml_class_diagram.png)

---

## 🎯 Diagrama de Clases Completo del Sistema

Este diagrama muestra la arquitectura completa del sistema con todas las relaciones entre modelos, controladores y componentes core.

```mermaid
classDiagram
    %% ============================================
    %% CORE INFRASTRUCTURE
    %% ============================================
    class Database {
        -PDO connection
        +__construct()
        +getConnection() PDO
    }

    class Router {
        +route() void
    }

    %% ============================================
    %% MODELS
    %% ============================================
    class User {
        -PDO conn
        +__construct()
        +findByEmail(email) array
        +verifyPassword(password, hash) bool
        +findById(id) array
        +create(username, email, password, role, avatar) int
        +getAllUsers() array
        +requestEditorRole(userId) bool
        +hasPendingEditorRequest(userId) array
        +getEditorRequests() array
        +approveEditorRequest(requestId) bool
        +rejectEditorRequest(requestId) bool
        +updateAvatar(userId, path) bool
        +updateRole(userId, newRole) bool
        +updateBasicData(id, username, email) bool
        +updateUserAdmin(id, username, email, role) bool
        +deleteUserById(id) bool
        +toggleActive(id, newState) bool
    }

    class Post {
        -PDO conn
        +__construct()
        +getPublicPosts() array
        +getPublicPostsLimited(limit) array
        +getAllPosts() array
        +getPostsByUser(userId) array
        +getPostsByRole(role, userId) array
        +createPost(title, subtitle, slug, content, visibility, author_id, image, status) bool
        +getPostById(id) array
        +getPendingPosts() array
        +approvePost(postId) bool
        +rejectPost(postId) bool
        +deletePost(postId) bool
        +getAllPostsForModeration() array
        +incrementViews(id) bool
    }

    %% ============================================
    %% CONTROLLERS
    %% ============================================
    class AuthController {
        +loginForm() void
        +login() void
        +logout() void
    }

    class RegisterController {
        +registerForm() void
        +register() void
    }

    class HomeController {
        +publicHome() void
        +index() void
        -renderPrivate(view, data) void
    }

    class PostsController {
        +index() void
        +createForm() void
        +store() void
        +view() void
        -render(layout, view, data) void
    }

    class UsersController {
        +profile() void
        +requestEditor() void
        +updateAvatar() void
        +editProfileForm() void
        +updateProfile() void
        -render(layout, view, data) void
    }

    class PanelController {
        -requireAdmin() void
        +dashboard() void
        +pendingPosts() void
        +approve() void
        +reject() void
        +delete() void
        +users() void
        +deleteUser() void
        +editUser() void
        +updateUser() void
        +editorRequests() void
        +approveEditor() void
        +rejectEditor() void
        +disableUser() void
        +enableUser() void
        -render(layout, view, data) void
    }

    %% ============================================
    %% RELATIONSHIPS
    %% ============================================
    
    %% Models use Database
    User ..> Database : uses
    Post ..> Database : uses
    
    %% Controllers use Models
    AuthController ..> User : uses
    RegisterController ..> User : uses
    HomeController ..> Post : uses
    PostsController ..> Post : uses
    UsersController ..> User : uses
    UsersController ..> Post : uses
    PanelController ..> User : uses
    PanelController ..> Post : uses
    
    %% Router manages Controllers
    Router ..> AuthController : instantiates
    Router ..> RegisterController : instantiates
    Router ..> HomeController : instantiates
    Router ..> PostsController : instantiates
    Router ..> UsersController : instantiates
    Router ..> PanelController : instantiates
```

---

## 🏗️ Diagrama de Arquitectura MVC

Este diagrama muestra cómo se organiza el patrón MVC en tu aplicación.

```mermaid
graph TB
    subgraph "🌐 Entry Point"
        INDEX[index.php]
    end
    
    subgraph "🎯 Core Layer"
        ROUTER[Router]
        DATABASE[Database]
    end
    
    subgraph "🎮 Controllers Layer"
        AUTH[AuthController]
        REG[RegisterController]
        HOME[HomeController]
        POSTS[PostsController]
        USERS[UsersController]
        PANEL[PanelController]
    end
    
    subgraph "📊 Models Layer"
        USER_MODEL[User Model]
        POST_MODEL[Post Model]
    end
    
    subgraph "🎨 Views Layer"
        VIEWS[Views/Templates]
    end
    
    subgraph "💾 Database Layer"
        DB[(MySQL Database)]
    end
    
    INDEX --> ROUTER
    ROUTER --> AUTH
    ROUTER --> REG
    ROUTER --> HOME
    ROUTER --> POSTS
    ROUTER --> USERS
    ROUTER --> PANEL
    
    AUTH --> USER_MODEL
    REG --> USER_MODEL
    HOME --> POST_MODEL
    POSTS --> POST_MODEL
    USERS --> USER_MODEL
    USERS --> POST_MODEL
    PANEL --> USER_MODEL
    PANEL --> POST_MODEL
    
    USER_MODEL --> DATABASE
    POST_MODEL --> DATABASE
    DATABASE --> DB
    
    AUTH --> VIEWS
    REG --> VIEWS
    HOME --> VIEWS
    POSTS --> VIEWS
    USERS --> VIEWS
    PANEL --> VIEWS
    
    style INDEX fill:#ff6b6b
    style ROUTER fill:#4ecdc4
    style DATABASE fill:#45b7d1
    style DB fill:#96ceb4
```

---

## 🔐 Diagrama de Flujo de Autenticación

```mermaid
sequenceDiagram
    participant U as Usuario
    participant AC as AuthController
    participant UM as User Model
    participant DB as Database
    participant S as Session
    
    U->>AC: loginForm()
    AC-->>U: Muestra formulario
    
    U->>AC: login(email, password)
    AC->>UM: findByEmail(email)
    UM->>DB: SELECT * FROM users
    DB-->>UM: user data
    UM-->>AC: user array
    
    alt Usuario suspendido
        AC-->>U: Alert: Cuenta suspendida
    else Credenciales válidas
        AC->>UM: verifyPassword()
        UM-->>AC: true
        AC->>S: Crear sesión
        S-->>AC: Sesión creada
        AC-->>U: Redirect a zona privada
    else Credenciales inválidas
        AC-->>U: Error: Credenciales incorrectas
    end
```

---

## 📝 Diagrama de Gestión de Posts

```mermaid
stateDiagram-v2
    [*] --> Creación
    
    Creación --> Pendiente : Editor crea post
    Creación --> Aprobado : Admin crea post
    
    Pendiente --> Aprobado : Admin aprueba
    Pendiente --> Rechazado : Admin rechaza
    Pendiente --> Eliminado : Admin/Editor elimina
    
    Aprobado --> Público : visibility=public
    Aprobado --> Privado : visibility=private
    Aprobado --> Eliminado : Admin/Editor elimina
    
    Rechazado --> Eliminado : Admin elimina
    
    Público --> [*]
    Privado --> [*]
    Eliminado --> [*]
    
    note right of Pendiente
        Estado por defecto
        para editores
    end note
    
    note right of Aprobado
        Estado automático
        para admins
    end note
```

---

## 👥 Diagrama de Roles y Permisos

```mermaid
graph TD
    subgraph "🎭 Sistema de Roles"
        USER[👤 User]
        EDITOR[✍️ Editor]
        ADMIN[👑 Admin]
    end
    
    subgraph "📋 Permisos User"
        U1[Ver posts públicos]
        U2[Ver perfil propio]
        U3[Editar perfil]
        U4[Solicitar rol Editor]
        U5[Cambiar avatar]
    end
    
    subgraph "📋 Permisos Editor"
        E1[Crear posts]
        E2[Editar posts propios]
        E3[Ver posts propios]
        E4[Subir imágenes]
    end
    
    subgraph "📋 Permisos Admin"
        A1[Aprobar/Rechazar posts]
        A2[Gestionar usuarios]
        A3[Cambiar roles]
        A4[Suspender usuarios]
        A5[Eliminar usuarios]
        A6[Ver panel de control]
        A7[Gestionar solicitudes Editor]
        A8[Posts auto-aprobados]
    end
    
    USER --> U1
    USER --> U2
    USER --> U3
    USER --> U4
    USER --> U5
    
    EDITOR --> E1
    EDITOR --> E2
    EDITOR --> E3
    EDITOR --> E4
    EDITOR -.hereda.-> USER
    
    ADMIN --> A1
    ADMIN --> A2
    ADMIN --> A3
    ADMIN --> A4
    ADMIN --> A5
    ADMIN --> A6
    ADMIN --> A7
    ADMIN --> A8
    ADMIN -.hereda.-> EDITOR
    
    style USER fill:#a8dadc
    style EDITOR fill:#457b9d
    style ADMIN fill:#e63946
```

---

## 🗄️ Diagrama de Entidades de Base de Datos

```mermaid
erDiagram
    USERS ||--o{ POSTS : creates
    USERS ||--o{ EDITOR_REQUESTS : submits
    
    USERS {
        int id PK
        string username
        string email
        string password
        enum role
        string avatar
        boolean active
        datetime created_at
    }
    
    POSTS {
        int id PK
        string title
        string subtitle
        string slug
        text content
        enum visibility
        int author_id FK
        string image
        enum status
        int views
        datetime created_at
        datetime updated_at
    }
    
    EDITOR_REQUESTS {
        int id PK
        int user_id FK
        enum status
        datetime created_at
    }
```

---

## 🔄 Diagrama de Flujo de Registro

```mermaid
flowchart TD
    START([Usuario visita registro])
    FORM[Muestra formulario]
    INPUT[Usuario ingresa datos]
    VALIDATE{Validaciones}
    
    PASS_MATCH{¿Contraseñas coinciden?}
    EMAIL_VALID{¿Email válido?}
    EMAIL_EXISTS{¿Email ya existe?}
    
    CREATE[Crear usuario en BD]
    AUTO_LOGIN[Login automático]
    REDIRECT[Redirigir a zona privada]
    ERROR[Mostrar error]
    END([Fin])
    
    START --> FORM
    FORM --> INPUT
    INPUT --> VALIDATE
    
    VALIDATE --> PASS_MATCH
    PASS_MATCH -->|No| ERROR
    PASS_MATCH -->|Sí| EMAIL_VALID
    
    EMAIL_VALID -->|No| ERROR
    EMAIL_VALID -->|Sí| EMAIL_EXISTS
    
    EMAIL_EXISTS -->|Sí| ERROR
    EMAIL_EXISTS -->|No| CREATE
    
    CREATE --> AUTO_LOGIN
    AUTO_LOGIN --> REDIRECT
    REDIRECT --> END
    ERROR --> FORM
    
    style START fill:#96ceb4
    style CREATE fill:#ffeaa7
    style AUTO_LOGIN fill:#74b9ff
    style REDIRECT fill:#55efc4
    style ERROR fill:#ff7675
    style END fill:#96ceb4
```

---

## 📊 Resumen de Componentes

### 🎯 Core (2 clases)
- **Database**: Gestión de conexión PDO a MySQL
- **Router**: Enrutamiento dinámico de controladores y acciones

### 📦 Models (2 clases)
- **User**: 17 métodos para gestión completa de usuarios
- **Post**: 14 métodos para gestión completa de publicaciones

### 🎮 Controllers (6 clases)
- **AuthController**: Autenticación (3 métodos)
- **RegisterController**: Registro de usuarios (2 métodos)
- **HomeController**: Páginas principales (3 métodos)
- **PostsController**: Gestión de posts (5 métodos)
- **UsersController**: Perfil de usuario (6 métodos)
- **PanelController**: Panel administrativo (15 métodos)

### 📈 Estadísticas del Proyecto
- **Total de clases**: 10
- **Total de métodos públicos**: 51
- **Total de métodos privados**: 4
- **Líneas de código**: ~1,200 (aproximado)
- **Patrón de diseño**: MVC (Model-View-Controller)

---

## 🎨 Diagrama de Componentes Visuales

```mermaid
graph LR
    subgraph "🌍 Zona Pública"
        PUB_HOME[Home Pública]
        LOGIN[Login]
        REGISTER[Registro]
        VIEW_POST[Ver Post]
    end
    
    subgraph "🔒 Zona Privada"
        PRIV_HOME[Blue Room]
        MY_POSTS[Mis Posts]
        CREATE_POST[Crear Post]
        PROFILE[Mi Perfil]
        EDIT_PROFILE[Editar Perfil]
    end
    
    subgraph "👑 Panel Admin"
        DASHBOARD[Dashboard]
        MANAGE_POSTS[Gestionar Posts]
        MANAGE_USERS[Gestionar Usuarios]
        EDITOR_REQ[Solicitudes Editor]
    end
    
    PUB_HOME --> LOGIN
    PUB_HOME --> REGISTER
    PUB_HOME --> VIEW_POST
    
    LOGIN --> PRIV_HOME
    REGISTER --> PRIV_HOME
    
    PRIV_HOME --> MY_POSTS
    PRIV_HOME --> PROFILE
    MY_POSTS --> CREATE_POST
    PROFILE --> EDIT_PROFILE
    
    PRIV_HOME -.admin.-> DASHBOARD
    DASHBOARD --> MANAGE_POSTS
    DASHBOARD --> MANAGE_USERS
    DASHBOARD --> EDITOR_REQ
    
    style PUB_HOME fill:#a8dadc
    style PRIV_HOME fill:#457b9d
    style DASHBOARD fill:#e63946
```

---

> [!TIP]
> **Cómo usar estos diagramas:**
> - Los diagramas están en formato Mermaid y se renderizan automáticamente en GitHub, VS Code y muchas otras plataformas
> - Puedes copiar cualquier diagrama a tu documentación
> - Los colores ayudan a identificar diferentes capas de la arquitectura

> [!IMPORTANT]
> **Arquitectura del Proyecto:**
> - Sigue el patrón **MVC** estrictamente
> - Separación clara entre **lógica de negocio** (Models), **control de flujo** (Controllers) y **presentación** (Views)
> - Sistema de **roles jerárquico**: User → Editor → Admin
> - **Seguridad**: Validación de sesiones, sanitización de inputs, prepared statements PDO
