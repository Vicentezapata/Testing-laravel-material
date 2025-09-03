<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).
# TaskMaster

TaskMaster es una aplicación Laravel 12.x que provee una API RESTful y una interfaz web básica para la gestión de tareas y proyectos.

## Requisitos previos
- PHP >= 8.2
- Composer
- SQLite (o MySQL/PostgreSQL si lo prefieres)
- Node.js y npm (opcional, para assets front-end)

## Instalación y configuración paso a paso

1. **Clona el repositorio y entra al directorio:**
	```bash
	git clone <url-del-repo>
	cd Testing-laravel-material
	```

2. **Instala las dependencias de PHP:**
	```bash
	composer install
	```

3. **Copia el archivo de entorno y genera la clave de la app:**
	```bash
	cp .env.example .env
	php artisan key:generate
	```

4. **Configura la base de datos:**
	- Por defecto se recomienda SQLite para pruebas rápidas.
	- Crea el archivo vacío:
	  ```bash
	  mkdir -p database
	  type nul > database/database.sqlite
	  ```
	- Edita `.env` y ajusta:
	  ```env
	  DB_CONNECTION=sqlite
	  DB_DATABASE="/ruta/absoluta/a/tu/proyecto/database/database.sqlite"
	  ```

5. **Ejecuta migraciones y seeders:**
	```bash
	php artisan migrate --seed
	```

6. **(Opcional) Instala dependencias front-end y compila assets:**
	```bash
	npm install
	npm run dev
	```

7. **Inicia el servidor de desarrollo:**
	```bash
	php artisan serve
	```
	Accede a http://127.0.0.1:8000


## Rutas de acceso

### Interfaz web

- Listar tareas: [http://127.0.0.1:8000/tasks](http://127.0.0.1:8000/tasks)
- Crear tarea: [http://127.0.0.1:8000/tasks/create](http://127.0.0.1:8000/tasks/create)

### API RESTful

- Listar tareas: `GET http://127.0.0.1:8000/api/tasks`
- Crear tarea: `POST http://127.0.0.1:8000/api/tasks`
- Ver tarea: `GET http://127.0.0.1:8000/api/tasks/{id}`
- Actualizar tarea: `PUT/PATCH http://127.0.0.1:8000/api/tasks/{id}`
- Eliminar tarea: `DELETE http://127.0.0.1:8000/api/tasks/{id}`

## Pruebas

1. **Ejecutar pruebas unitarias y de características:**
	```bash
	php artisan test
	```

2. **Prueba de la API:**
	- El archivo `tests/Feature/TaskApiTest.php` incluye una prueba que verifica la obtención de todas las tareas.

## Estructura principal
- `app/Models/Project.php` y `Task.php`: Modelos Eloquent
- `database/migrations/`: Migraciones para `projects` y `tasks`
- `database/factories/`: Factories para datos de prueba
- `database/seeders/DatabaseSeeder.php`: Crea 3 proyectos y 5 tareas por proyecto
- `app/Http/Controllers/Api/TaskController.php`: API RESTful
- `app/Http/Resources/TaskResource.php`: Formato de respuesta JSON
- `app/Http/Controllers/WebTaskController.php`: Controlador web
- `resources/views/tasks/`: Vistas Blade para listar y crear tareas
- `routes/api.php` y `routes/web.php`: Rutas API y web

## Créditos
Desarrollado como ejemplo para laboratorio de automatización de pruebas en Laravel.
