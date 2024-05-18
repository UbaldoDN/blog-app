
# Blog

Este proyecto es una aplicación de blog construida con Laravel para la API y HTML, TailwindCSS y JavaScript para el frontend. Incluye funcionalidad para la gestión de posts.

## Objetivo
El objetivo de la prueba es la demostración de conocimientos en Laravel y PHP, por lo que se
primará el cuidado de la estructura backend: aplicación de principios SOLID, la correcta separación
de servicios y responsabilidades, introducción de interfaces, tolerancia ante fallos, etc. Api
Plattform ofrece ciertos atajos que nos impiden ver cómo un desarrollador senior podría resolver
ciertas casuísticas, por lo que preferimos evitar su uso.

## Requisitos
- Docker
- PHP 8.0 o superior
- Composer y estructura PSR-4 en el proyecto
- La última versión estable de Laravel
- Testing unitario
- La API debe devolver y consumir los datos en formato JSON
- Programar en el idioma inglés

## Instalación

### Clonar el repositorio
1. Abre tu terminal o línea de comandos.
2. Navega a la ubicación donde deseas clonar el repositorio.
3. Ejecuta el siguiente comando:

```bash
git clone https://github.com/UbaldoDN/blog-app.git
```

### Inicio del contenedor Docker
```bash
cd blog-app/provision
docker compose up -d
```

##### Espera en lo que termina de instalar todo lo necesario para seguir
Cuando la terminal haya terminado vas a escribir los siguientes comandos

```bash
docker exec -it api composer install
docker exec -it api cp .env.example .env
docker exec -it api php artisan key:generate
```

## Correr pruebas unitarias
Con el siguiente comando vas a poder hacer un barrido de las pruebas unitarias y ver un poco de descripción

```bash
docker exec -it api php artisan test
```
## Ejecutar Frontend
Para poder visualizar una página sencilla en donde se van a mostrar una lista de Posts y un detalle haciendo click en el enlace "Read more" para ver un poco mostrar

- Abre tu navegador
- Escribe en la barra http://localhost:3000
- Veras un menu, selecciona la opción Posts
- Se te desplegara la información.

## Reporte de acciones
Al ver los requerimientos y demás puntos, esto fue a lo que conclui:

- Utilice el Patron Repository
- Cree 3 servicies: Logger, ApiClient (https://jsonplaceholder.typicode.com/) y Auth (Sessions)

- El reto de no tener una base de datos que me ayudara con el control de tokens para usuarios y demas, me hizo utilizar un mini servicio de auth con sesiones (Utilice el patron repository), esto solo funciona en las pruebas unitarias
- El hecho de tener una base de datos, se podria utilizar un paquete que tiene Laravel llamado Sanctum el cual ya tiene todo lo minimo necesario para realizar tokens.
- El reto de llevar una bitacora de acciones me hizo hacer otro mini servicio utilizando la misma logica del patron Repository para que un paso antes del retorno de la respuesta al cliente, este pudiera grabar en algun lugar, por el momento lo hice que grabara un archivo en la carpeta storage/logs
- El reto de tratar de simular la api de jsonplaceholder como una base de datos mas de recuersos que de seguridad, me hizo crear un cliente para los 3 tipos de acciones o roles generales Admin, Author y Guest, esto me ayudo a ser mucho mas facil la implementación.

## Funcionalidades

### Estructura del Proyecto
- backend: Contiene el código del servidor Laravel.
- frontend: Contiene el código HTML, TailwindCSS y JavaScript.

### Funcionalidades

#### Administradores:
- Login y Logout
- Gestión de autores y posts
- Aprobar posts

##### Autores:
- Login y Logout
- Gestión de sus propios posts

## Rutas de la API
### Posts:
- GET /api/v1/posts: Lista todos los posts.
- GET /api/v1/posts/{id}: Muestra el detalle de un post.

### Autores:
- POST /api/v1/authors/login: Inicia sesión como autor.
- POST /api/v1/authors/logout: Cierra sesión como autor.
- GET /api/v1/authors/posts: Lista todos los posts del autor.
- GET /api/v1/authors/posts/{id}: Muestra el detalle de un post del autor.
- POST /api/v1/authors/posts: Crea un nuevo post.
- PUT /api/v1/authors/posts/{id}: Actualiza un post existente.

### Administradores:
- POST /api/v1/admin/login: Inicia sesión como administrador.
- POST /api/v1/admin/logout: Cierra sesión como administrador.
- GET /api/v1/admin/authors: Lista todos los autores.
- GET /api/v1/admin/authors/{id}: Muestra el detalle de un autor.
- GET /api/v1/admin/authors/{id}/posts: Lista todos los posts de un autor.
- POST /api/v1/admin/authors: Crea un nuevo autor.
- PUT /api/v1/admin/authors/{id}: Actualiza un autor existente.
- PATCH /api/v1/admin/posts/{id}/approve: Aprueba un post.

## Conclusiones
- Desarrollo de la API: Se implementó una API en Laravel para gestionar los posts de un blog, así como la autenticación y autorización de administradores y autores.

- Frontend básico: Se creó un frontend sencillo utilizando HTML, Tailwind CSS y JavaScript puro para mostrar una lista de posts y su detalle. Sin embargo, quedaron pendientes las secciones para autores y administradores.

### Trabajo pendiente:
- Completar las funcionalidades para los autores y administradores en el frontend.
- Mejorar el diseño y la experiencia de usuario del frontend.
- Mejorar el diseño para una authorización mas facil y con una base de datos.
- Añadir más funcionalidades a la API según sea necesario, como la gestión de usuarios y la publicación de comentarios.

### Que aprendi
- Aprendizaje en algoritmia y patrones de diseño.
- Aprendizaje de Laravel para el desarrollo de APIs RESTful.
- Experiencia con el uso de Docker para la gestión de contenedores.
- Mejora de las habilidades en HTML, CSS y JavaScript.

En resumen, aunque quedaron algunas funcionalidades pendientes en el frontend, el proyecto logró implementar una parte importante de la lógica de negocio con la API y proporciona una base sólida para futuras mejoras y expansiones.

### ¡Gracias por usar nuestro Blog App!
