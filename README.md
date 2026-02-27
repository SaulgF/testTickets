# Sistema de Tickets

Sistema web para la gestión de incidencias técnicas internas.
Desarrollado como prueba técnica utilizando arquitectura monolítica
moderna.

---

## Stack Tecnológico

- Backend: Laravel 12
- Frontend: Inertia.js + Vue 3 (Composition API)
- Estilos: Tailwind CSS
- Componentes UI: shadcn-vue
- Autenticación: Laravel Breeze
- Autorización: Policies
- Base de Datos: MySQL / SQLite
- Manejo de Archivos: Laravel Storage
- Build Tool: Vite

---

## Roles

### Administrador

- Ver todos los tickets
- Cerrar tickets
- Ver métricas generales

### Usuario

- Crear tickets
- Ver únicamente sus tickets
- Adjuntar imagen
- Filtrar por estado

---

# Instalación

## 1️⃣ Clonar repositorio

```bash
git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git
cd TU_REPOSITORIO
```

## 2️⃣ Instalar dependencias

```bash
composer install
npm install
```

## 3️⃣ Configurar entorno

```bash
cp .env.example .env
php artisan key:generate
```

Configurar base de datos en `.env`.

## 4️⃣ Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

## 5️⃣ Crear enlace para imágenes

```bash
php artisan storage:link
```

## 6️⃣ Levantar servidores

```bash
php artisan serve
npm run dev
```

Abrir en navegador:

    http://127.0.0.1:8000

---

# Usuarios de Prueba

### Admin

Email: admin@test.com
Password: password

### Usuario 1

Email: user1@test.com
Password: password

### Usuario 2

Email: user2@test.com
Password: password

---

# 🛡 Seguridad

- Policies para autorización
- Validación con Form Requests
- Protección CSRF
- Manejo seguro de archivos

---

# ✨ Funcionalidades

- Login con roles
- Dashboard con métricas
- Creación de tickets en modal
- Subida y vista previa de imagen
- Filtro por estado (persistente en URL)
- Filtro server-side
- Confirmación antes de cerrar ticket
- Toast global reutilizable

---

# 📌 Notas Técnicas

- Filtro persistente vía query params (?status=open)
- Filtrado server-side
- Arquitectura desacoplada en frontend (composables)
- Diseño tipo SaaS moderno

---

Proyecto desarrollado con fines de evaluación técnica.
