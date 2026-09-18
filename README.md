# GENBU

Este proyecto presenta un sistema web enfocado en la deteccion temprana de dermatitis canina mediante tecnicas de deep learning.

Actualmente incluye el flujo completo de autenticacion, registro de usuarios con bifurcacion de rol, y la gestion CRUD de mascotas, todo con persistencia real en base de datos, como parte del primer incremento funcional de una plataforma orientada al apoyo veterinario.

## Contexto del proyecto

La dermatitis canina es una afeccion frecuente en perros y su identificacion oportuna puede mejorar el tratamiento y el bienestar animal.

El objetivo de este sistema web es servir como soporte digital para:

* Gestionar el registro de mascotas y sus tutores dentro de una clinica veterinaria.
* Centralizar la informacion de usuarios (veterinarios, secretarias y administradores) y sus roles dentro de una experiencia web organizada.
* Cargar y visualizar imagenes dermatologicas de pacientes caninos (proximo incremento).
* Aplicar un modelo de deep learning para apoyar la deteccion de posibles lesiones (proximo incremento).

## Estado actual

En esta version se encuentra implementado el primer incremento funcional del sistema:

* Inicio de sesion con autenticacion real contra la base de datos, con redireccion automatica al panel correspondiente segun el rol del usuario (Veterinario, Secretaria/Auxiliar o Administrador).
* Registro de usuario mediante codigo de acceso, con bifurcacion automatica de rol (los codigos de rol Veterinario solicitan datos profesionales adicionales antes de crear la cuenta).
* Gestion CRUD completa (crear, consultar, editar, eliminar) sobre la entidad Mascota.
* Middlewares de seguridad que protegen las rutas segun sesion activa y rol autorizado.
* Base de datos implementada en MySQL, con 10 entidades normalizadas, a partir del modelo Entidad-Relacion diseñado en StarUML.
* 11 pruebas unitarias automatizadas sobre la logica de negocio del sistema.

## Estructura del proyecto

```
genbu/
|- app/
|   |- Http/
|   |   |- Controllers/       # LoginController, RegistroController, MascotaController, DashboardController
|   |   `- Middleware/        # VerificarSesion, VerificarRol
|   `- Models/                # Usuario, Mascota, Veterinario, SecretariaAuxiliar, CodigoAcceso, etc.
|- database/
|   |- migrations/            # Script de creacion de las 10 tablas del sistema
|   `- seeders/                # AdminSeeder (datos de prueba)
|- public/
|   |- css/                    # Hojas de estilo de las vistas
|   `- images/                 # Recursos graficos usados por las interfaces
|- resources/
|   `- views/
|       |- auth/                # Vistas de login, registro y recuperacion de contraseña
|       `- dashboard/           # Paneles por rol y listado de mascotas
|- routes/
|   `- web.php                  # Definicion de rutas
|- tests/
|   `- Feature/
|       `- LogicaNegocioTest.php  # Pruebas unitarias
`- README.md
```

Nota: las vistas hacen referencia a imagenes como `images/logo.png`, `images/paw.png`, etc., ubicadas en `public/images/`. Asegurate de mantener esa carpeta y esos nombres de archivo para que las vistas carguen correctamente.

## Tecnologias usadas

* PHP + Laravel (backend, arquitectura por capas)
* HTML5, CSS3, JavaScript, Blade (frontend)
* MySQL (base de datos, gestionada con phpMyAdmin)
* XAMPP (Apache + MySQL, entorno de desarrollo local)
* Bootstrap 5 (CDN) y Google Fonts (CDN)
* Git y GitHub (control de versiones)
* PHPUnit (pruebas unitarias)

## Como ejecutar el proyecto

Este proyecto ya no corre de forma local sin servidor; requiere PHP, Composer y un servidor de base de datos MySQL en funcionamiento.

1. Clona el repositorio dentro de la carpeta `htdocs` de tu instalacion de XAMPP:
   ```bash
   cd C:\xampp\htdocs
   git clone <URL-del-repositorio> genbu
   cd genbu
   ```
2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```
3. Copia el archivo de entorno y genera la clave de la aplicacion:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configura la conexion a la base de datos en el archivo `.env` segun tu instalacion local de XAMPP:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=genbu
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Crea, desde phpMyAdmin, una base de datos vacia llamada exactamente `genbu` (cotejamiento `utf8mb4_unicode_ci`).
6. Ejecuta las migraciones para crear las 10 tablas del sistema:
   ```bash
   php artisan migrate
   ```
7. Carga los datos de prueba (incluye la primera cuenta de Administrador):
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```
8. Con Apache corriendo en XAMPP, accede desde el navegador a:
   ```
   http://localhost/genbu/public/login
   ```

### Usuarios de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | admin@genbu.com | admin1234 |
| Veterinario | valentina.torres@genbu.com | vet12345 |
| Secretaria | camila.rojas@genbu.com | sec12345 |

### Ejecutar las pruebas unitarias

```bash
php artisan test
```


