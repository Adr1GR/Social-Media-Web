# Poner en marchar los contenedores
La **primera vez** tienes que ejecutar estos dos comandos en la raíz de este proyecto para crear los contenedores y levantarlos:
1. Ejecuta `docker build -t php-for-dwes-dwesgram .`
2. Ejecuta `docker compose up -d`

## Arrancar los contenedores
Una vez creado los contenedores, cuando quieras **arrancarlos** tan solo tienes que ejecutar el comando `docker compose start` en la raíz del proyecto.

## Parar lo contenedores
Si quieres **apagarlos** ejecuta `docker compose stop` en la raíz del proyecto.

# Poner en marcha la base de datos
Accede a MariaDB por medio de Adminer arrancando los contenedores y accediendo vía web a `localhost:8080`. Desde Adminer, crea las tablas que tienes en el fichero `./db/schema.sql`.

## Conectar a la base de datos
Para conectarte a la base de datos tienes que indicar:

- La dirección de la base de datos: `bd-dwesgram`
- El nombre de la base de datos, el usuario y la contraseña, que en todos los casos es `dwes`
- El puerto de la base de datos: `3306`

Ejemplo:

`$mysqli = new mysqli("db", "dwes", "dwes", "dwes", 3306);`

# Preparar la carpeta donde se subirán las imágenes
La carpeta donde se subirán las imágenes tiene que tener permisos de escritura. Te puedes asegurar que no tendrás problemas con un `chmod -R 0777 imagenes`.

# Configurar autocarga de clases con composer autload
Como puedes ver en la raíz del proyecto tienes el fichero `composer.json` y, por tanto, tan solo tienes que ejecutar el comando siguiente para poner en marcha el *autoloading* de clases (desde la raíz del proyecto, done está el fichero `composer.json`):

`composer dump-autoload`

# Depurar desde Visual Studio Code con xdebug
Una vez instalado el plugin de xdebug, puedes crear el fichero `.vscode/launch.json` con el siguiente contenido para lanzar el depurador:

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceRoot}/src"
            }
        }
    ]
}
```
