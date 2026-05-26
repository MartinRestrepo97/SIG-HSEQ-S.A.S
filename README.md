# SIG-HSEQ S.A.S — Backend (Laravel + Filament)

Sistema de gestión de certificados HSEQ (Seguridad, Salud, Medio Ambiente y Calidad) para la empresa SIG-HSEQ S.A.S. Backend construido con **Laravel 10**, panel administrativo con **Filament 3**, y API REST para el frontend React.

---

## Tabla de Contenidos

- [Requisitos](#requisitos)
- [Instalación y Ejecución](#instalación-y-ejecución)
  - [Con Docker (recomendado)](#con-docker-recomendado)
  - [Sin Docker (local)](#sin-docker-local)
- [Comandos Útiles](#comandos-útiles)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Arquitectura y Componentes](#arquitectura-y-componentes)
  - [Modelos (Models)](#modelos-models)
  - [Controladores API (Controllers)](#controladores-api-controllers)
  - [Recursos Filament (Admin Panel)](#recursos-filament-admin-panel)
  - [Rutas API](#rutas-api)
  - [Migraciones](#migraciones)
- [Variables de Entorno](#variables-de-entorno)

---

## Requisitos

- **PHP** >= 8.1
- **Composer** >= 2.x
- **Node.js** >= 16.x y **npm**
- **MySQL** 8.0
- **Docker** y **Docker Compose** (para la opción con contenedores)

---

## Instalación y Ejecución

### Con Docker (recomendado)

Este método levanta automáticamente el backend Laravel, MySQL y Mailpit.

```bash
# 1. Clonar el repositorio
git clone https://github.com/MartinRestrepo97/SIG-HSEQ-S.A.S.git
cd SIG-HSEQ-S.A.S

# 2. Copiar el archivo de variables de entorno
cp .env.example .env

# 3. Construir y levantar los contenedores
docker compose up -d --build

# 4. Instalar dependencias de Composer dentro del contenedor
docker exec laravel_app composer install --no-interaction

# 5. Configurar .env dentro del contenedor (ajustar host y credenciales de DB)
docker exec laravel_app sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' /var/www/html/.env
docker exec laravel_app sed -i 's/DB_DATABASE=sig-hseq_s.a.s/DB_DATABASE=sig_hseq_sas/' /var/www/html/.env
docker exec laravel_app sed -i 's/DB_PASSWORD=$/DB_PASSWORD=root/' /var/www/html/.env

# 6. Generar la clave de la aplicación
docker exec laravel_app php artisan key:generate

# 7. Crear el enlace simbólico de storage
docker exec laravel_app php artisan storage:link

# 8. Ejecutar las migraciones
docker exec laravel_app php artisan migrate --force

# 9. Configurar permisos de storage
docker exec laravel_app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
docker exec laravel_app chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
```

**Servicios disponibles:**

| Servicio | URL | Descripción |
|----------|-----|-------------|
| Backend Laravel | http://localhost:8000 | API REST y panel Filament |
| Panel Admin (Filament) | http://localhost:8000/dashboard | Panel de administración |
| API Certificados | http://localhost:8000/api/certificados | Endpoint de certificados |
| Mailpit (Web UI) | http://localhost:8025 | Visor de correos de prueba |

```bash
# Detener los contenedores
docker compose down

# Ver logs del contenedor
docker logs laravel_app

# Acceder al contenedor
docker exec -it laravel_app bash
```

### Sin Docker (local)

Requiere PHP 8.1+, Composer, Node.js 16+, MySQL 8.0 instalados localmente.

```bash
# 1. Clonar el repositorio
git clone https://github.com/MartinRestrepo97/SIG-HSEQ-S.A.S.git
cd SIG-HSEQ-S.A.S

# 2. Copiar y configurar las variables de entorno
cp .env.example .env
# Editar .env con las credenciales de tu base de datos local

# 3. Instalar dependencias de PHP
composer install

# 4. Generar la clave de la aplicación
php artisan key:generate

# 5. Crear el enlace simbólico de storage
php artisan storage:link

# 6. Crear la base de datos MySQL
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS \`sig-hseq_s.a.s\`;"

# 7. Ejecutar las migraciones
php artisan migrate

# 8. Instalar dependencias de npm y compilar assets
npm install
npm run build    # Compilación para producción
npm run dev      # Servidor de desarrollo con HMR (Vite)

# 9. Iniciar el servidor de desarrollo de Laravel
php artisan serve
# El backend estará disponible en http://127.0.0.1:8000
```

---

## Comandos Útiles

| Comando | Descripción |
|---------|-------------|
| `php artisan serve` | Inicia el servidor de desarrollo Laravel en `http://127.0.0.1:8000` |
| `php artisan migrate` | Ejecuta las migraciones pendientes |
| `php artisan migrate:fresh` | Elimina todas las tablas y re-ejecuta las migraciones |
| `php artisan migrate:rollback` | Revierte la última migración |
| `php artisan make:filament-user` | Crea un usuario administrador para Filament |
| `php artisan storage:link` | Crea el enlace simbólico `public/storage` → `storage/app/public` |
| `php artisan key:generate` | Genera la clave de cifrado de la aplicación |
| `php artisan tinker` | Abre la consola interactiva de Laravel |
| `php artisan route:list` | Lista todas las rutas registradas |
| `npm run dev` | Inicia Vite en modo desarrollo con HMR |
| `npm run build` | Compila los assets para producción |
| `docker compose up -d --build` | Construye y levanta los contenedores en segundo plano |
| `docker compose down` | Detiene y elimina los contenedores |
| `docker exec -it laravel_app bash` | Accede al shell del contenedor de la aplicación |
| `docker exec laravel_app php artisan migrate` | Ejecuta migraciones dentro del contenedor |

---

## Estructura del Proyecto

```
SIG-HSEQ-S.A.S/
├── app/
│   ├── Console/                        # Comandos Artisan personalizados
│   ├── Exceptions/                     # Manejadores de excepciones
│   ├── Filament/
│   │   └── Resources/                  # Recursos del panel admin Filament
│   │       ├── CertificadosResource.php
│   │       ├── ClientesResource.php
│   │       └── UserResource.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/                    # Controladores de la API REST
│   │   │       ├── CertificadosController.php
│   │   │       └── ClientesController.php
│   │   └── Middleware/                 # Middleware HTTP
│   ├── Models/                         # Modelos Eloquent
│   │   ├── Certificados.php
│   │   ├── CertificadosClientes.php
│   │   ├── Clientes.php
│   │   └── User.php
│   └── Providers/                      # Service Providers
│       └── Filament/
│           └── DashboardPanelProvider.php
├── config/                             # Archivos de configuración Laravel
├── database/
│   └── migrations/                     # Migraciones de base de datos
├── public/                             # Punto de entrada web (index.php)
├── resources/                          # Vistas, CSS y JS del frontend Laravel
├── routes/
│   ├── api.php                         # Rutas de la API REST
│   └── web.php                         # Rutas web
├── storage/                            # Archivos generados, logs, cache
├── tests/                              # Tests unitarios y de integración
├── .env.example                        # Plantilla de variables de entorno
├── artisan                             # CLI de Laravel
├── composer.json                       # Dependencias PHP
├── docker-compose.yml                  # Configuración Docker Compose
├── Dockerfile                          # Imagen Docker de la aplicación
├── package.json                        # Dependencias npm (Vite)
└── vite.config.js                      # Configuración de Vite
```

---

## Arquitectura y Componentes

### Modelos (Models)

#### `Certificados` (`app/Models/Certificados.php`)

Representa un tipo de certificado/curso HSEQ.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | Identificador único |
| `imagen` | string (nullable) | Imagen del certificado |
| `curso` | string (unique) | Nombre del curso |
| `fecha_inicio` | date | Fecha de inicio del curso |
| `fecha_fin` | date | Fecha de fin del curso |
| `norma_cumplida` | string | Norma que cumple (ej: ISO 45001) |
| `estado` | string | Estado: `Activo` o `Vencido` |
| `documento_pdf` | string (nullable) | Ruta al PDF del certificado |

**Relaciones:**
- `clientes()`: BelongsToMany con `Clientes` a través de `certificados_clientes`
- `certificadosClientes()`: HasMany con `CertificadosClientes`

#### `Clientes` (`app/Models/Clientes.php`)

Representa un cliente de la empresa.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | Identificador único |
| `nombre` | string | Nombre del cliente |
| `apellido` | string | Apellido del cliente |
| `cedula` | text | Documento de identidad |
| `correo` | string (unique) | Correo electrónico |
| `telefono` | string (nullable) | Teléfono |
| `codigo` | string | Código interno del cliente |

**Relaciones:**
- `certificados()`: HasMany con `CertificadosClientes`

#### `CertificadosClientes` (`app/Models/CertificadosClientes.php`)

Tabla pivote que relaciona clientes con certificados. Contiene los datos específicos de validez de cada certificado asignado a un cliente.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | bigint | Identificador único |
| `clientes_id` | foreignId | FK a `clientes` |
| `certificados_id` | foreignId | FK a `certificados` |
| `estado_validez` | string | Estado de validez: `Activo` o `Vencido` |
| `fecha_inicio_validez` | date (nullable) | Inicio de validez para este cliente |
| `fecha_fin_validez` | date (nullable) | Fin de validez para este cliente |
| `documento_pdf_validez` | string (nullable) | PDF específico del cliente |

**Relaciones:**
- `cliente()`: BelongsTo `Clientes`
- `certificados()`: BelongsTo `Certificados`

#### `User` (`app/Models/User.php`)

Modelo estándar de Laravel para usuarios del panel admin Filament. Usa Sanctum para autenticación de API tokens.

---

### Controladores API (Controllers)

#### `CertificadosController` (`app/Http/Controllers/Api/CertificadosController.php`)

CRUD completo de certificados + consulta por cédula del cliente.

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `index()` | `GET /api/certificados` | Lista todos los certificados |
| `store()` | `POST /api/certificados` | Crea un nuevo certificado |
| `show($id)` | `GET /api/certificados/{id}` | Obtiene un certificado por ID |
| `update($id)` | `PUT /api/certificados/{id}` | Actualiza un certificado |
| `destroy($id)` | `DELETE /api/certificados/{id}` | Elimina un certificado |
| `testMartin($doc)` | `GET /api/constultar/{clientesId}` | Busca un cliente por cédula con sus certificados |

#### `ClientesController` (`app/Http/Controllers/Api/ClientesController.php`)

Gestión de clientes y descarga de certificados.

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `index()` | via `apiResource` | Lista todos los clientes |
| `store()` | via `apiResource` | Crea un nuevo cliente |
| `show($id)` | via `apiResource` | Obtiene un cliente con sus certificados |
| `update($id)` | via `apiResource` | Actualiza un cliente |
| `destroy($id)` | via `apiResource` | Elimina un cliente |
| `donwloadCertificadoCliente($id)` | `GET /api/descargar-certificado-cliente/{id}` | Descarga el PDF de un certificado asignado |

---

### Recursos Filament (Admin Panel)

El panel administrativo se accede en `/dashboard` y usa **Filament 3** para gestionar los recursos:

#### `CertificadosResource`
- **CRUD completo** de certificados con formularios para: imagen, curso, fechas, norma, estado, PDF.
- **Tabla** con columnas: imagen (circular), curso, fechas, norma, estado (con iconos de color), PDF.
- **RelationManager** (`ClientesRelationManager`): gestiona los clientes asignados a cada certificado.

#### `ClientesResource`
- **CRUD completo** de clientes con formularios para: nombre, apellido, cédula, correo, teléfono, código.
- **Tabla** con columnas buscables y ordenables.
- **RelationManager** (`CertificadosRelationManager`): asigna certificados a cada cliente con datos de validez (estado, fechas, PDF).

#### `UserResource`
- **CRUD** de usuarios administradores del panel.
- Campos: nombre, email, contraseña.

---

### Rutas API

Archivo `routes/api.php`:

| Método | Ruta | Controlador | Acción |
|--------|------|-------------|--------|
| GET | `/api/certificados` | CertificadosController | `index` |
| POST | `/api/certificados` | CertificadosController | `store` |
| GET | `/api/certificados/{id}` | CertificadosController | `show` |
| PUT | `/api/certificados/{id}` | CertificadosController | `update` |
| DELETE | `/api/certificados/{id}` | CertificadosController | `destroy` |
| GET | `/api/constultar/{clientesId}` | CertificadosController | `testMartin` |
| GET | `/api/descargar-certificado-cliente/{id}` | ClientesController | `donwloadCertificadoCliente` |

Archivo `routes/web.php`:

| Método | Ruta | Controlador | Acción |
|--------|------|-------------|--------|
| GET | `/descargar-certificado-cliente/{id}` | ClientesController | `donwloadCertificadoCliente` |
| GET | `/constultar/{clientesId}` | CertificadosController | `testMartin` |
| GET | `/` | Closure | Ruta raíz |

---

### Migraciones

| Archivo | Tabla | Descripción |
|---------|-------|-------------|
| `2014_10_12_000000_create_users_table.php` | `users` | Tabla de usuarios |
| `2014_10_12_100000_create_password_reset_tokens_table.php` | `password_reset_tokens` | Tokens de reseteo de contraseña |
| `2019_08_19_000000_create_failed_jobs_table.php` | `failed_jobs` | Jobs fallidos |
| `2019_12_14_000001_create_personal_access_tokens_table.php` | `personal_access_tokens` | Tokens Sanctum |
| `2024_12_24_011309_create_certificados_table.php` | `certificados` | Certificados/cursos HSEQ |
| `2024_12_24_011759_create_clientes_table.php` | `clientes` | Clientes de la empresa |
| `2024_12_25_011434_create_certificados_clientes_table.php` | `certificados_clientes` | Tabla pivote certificados-clientes |
| `2025_02_20_024957_add_imagen_to_certificados_table.php` | `certificados` | Agrega campo `imagen` |

---

## Variables de Entorno

Las variables principales en `.env`:

| Variable | Descripción | Valor por defecto |
|----------|-------------|-------------------|
| `APP_NAME` | Nombre de la aplicación | `SIG-HSEQ-SAS` |
| `APP_ENV` | Entorno (`local`, `production`) | `local` |
| `APP_DEBUG` | Modo debug | `true` |
| `APP_URL` | URL base de la app | `http://127.0.0.1:8000/dashboard` |
| `DB_CONNECTION` | Driver de base de datos | `mysql` |
| `DB_HOST` | Host de MySQL | `127.0.0.1` (local) / `db` (Docker) |
| `DB_PORT` | Puerto de MySQL | `3306` |
| `DB_DATABASE` | Nombre de la base de datos | `sig-hseq_s.a.s` |
| `DB_USERNAME` | Usuario de MySQL | `root` |
| `DB_PASSWORD` | Contraseña de MySQL | (vacío local) / `root` (Docker) |
| `FILESYSTEM_DISK` | Disco de archivos | `public` |
