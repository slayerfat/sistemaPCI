# sistemaPCI

[![Build Status](https://travis-ci.org/slayerfat/sistemaPCI.svg)](https://travis-ci.org/slayerfat/sistemaPCI)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/slayerfat/sistemaPCI/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/slayerfat/sistemaPCI/?branch=master)

Sistema de Gestion de Inventario Para la Division de Rehabilitacion Ocupacional.

Misión Alma Mater, Programa Nacional de Formación: Informatica, Trayecto 3, IUTOMS.

## Dependencias del Sistema

Para poder usar el software adecuadamente, es necesario instalar los siguientes paquetes de sofware y sus dependencias expresadas a continuacion.

### Node

Para usar este repositorio es necesario tener instalado en el sistema [node.js](http://nodejs.org/).


Para chequear que node esta instalado en tu sistema debes hacer un `node -v` en consola, el sistema dira `vX.YY.*` luego chequear que npm _(node package manager)_ este en el sistema con un `npm -v` en consola.

### Composer
Tambien es necesario instalar [composer](https://getcomposer.org/).

```
curl -sS https://getcomposer.org/installer │ php
mv composer.phar /usr/local/bin/composer
```

- si falla pueden `sudo !!`
- si falla porque no tienen curl
```
php -r "readfile('https://getcomposer.org/installer');" │ php
mv composer.phar /usr/local/bin/composer
```

Chequear que este instalado `composer -V` el sistema dira

`Composer version 1.0.-* (...) fecha`

si algo falla, chequear la documentacion de
[composer](https://getcomposer.org/)

## Contribuciones al Repositorio

1. Forkealo
2. Crea tu branch aleatorio (`git checkout -b mejoras-necesarias-e-importantes`)
3. Commit tus cambios (`git commit -am 'Estos son mis cambios!'`)
4. Push to the branch (`git push origin mejoras-necesarias-e-importantes`)
5. Crear nuevo Pull Request en Github

###Obtener las dependecias del sistema
_Desde la carpeta clonada:_

`composer install`

_sistemaPCI/src/:_

`npm install`
*si hace asi por el cambio de la estructura de archivos.*

Si composer se queja sobre mcrypt o mysql es probable que no tengan los modulos correspondentes activados/instalados.

Para ello deberan:

`sudo apt-get install php5-mcrypt`

`sudo apt-get install php5-mysql`

`sudo apt-get install php5-gd`

Si usan xampp, wampp, lampp, deberan referirse a la documentacion de php para esos paquetes, puesto que, si falla composer, es muy probable que sea debido a los binarios de PHP utilizados por su computadora.

Otra opcion es copiar el archivo de composer.phar a donde estan los archivos de php de xampp.

*google es tu aliado*

Si todo sale bien, debera generar las carpetas `vendor/` y `node_modules/` en donde estaran las dependecias.

###Sobre las dependencias

Es importante destacar que cada branch puede tener diferentes dependencias, lo que implica hacer installs adicionales segun el branch.

##La base de datos

Para instalar la base de datos en el sistema necesitan el archivo **.env** con la informacion de la base de datos.

En este archivo estan las variables usadas por mysql.

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=ALGUN_STRING_ALEATORIO_TAL...

#PARA EL ELEGIDO
APP_USER=SEUDONIMO_TAL...
APP_USER_EMAIL=CORREO_TAL...
APP_USER_PASSWORD=CLAVE_TAL...
APP_USERS_PASSWORD=CLAVE_TAL...

#PARA LA BASE DE DATOS
DB_HOST=HOST_TAL...
DB_DATABASE=NOMBRE_DE_LA_BASE_DE_DATOS_TAL...
DB_USERNAME=CLAVE_DE_LA_BASE_DE_DATOS_TAL...
DB_PASSWORD=USUARIO_DE_LA_BASE_DE_DATOS_TAL...

#DETALLES
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

#MAIL
MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

se hace de esta forma para mantener las claves seguras, etc, el pito y la guacharaca.

cuando tengan el archivo pueden hacer un simple:

`php src/artisan migrate`

y luego: `php src/artisan db:seed --class="PCI\Database\DatabaseSeeder"`

si por alguna razon eso falla, pueden `php artisan migrate:reset` --> `php artisan migrate` --> `php artisan db:seed`

y listo, la base de datos esta localmente en el sistema.

Si falla pueden hacer un `composer dump-autoload` y reintentarlo, si vuelve a falla puden crear un [problema (issue) en github](https://github.com/slayerfat/sistemaPCI/issues) con el error y la descripcion del mismo.

##Gulp

Se puede ejecutar simplemente `gulp` (dentro de la carpeta src) para copiar y compilar `sass` y otros archivos a la carpeta publica del sistema.

se vera:

```
[21:43:07] Using gulpfile ~/[...]/sistemaPCI/src/gulpfile.js
[21:43:07] Starting 'default'...
[21:43:07] Starting 'sass'...
[21:43:09] Finished 'default' after 2.05 s
[21:43:11] gulp-notify: [Laravel Elixir]
[21:43:11] Finished 'sass' after 3.79 s
[21:43:11] Starting 'copy'...
[21:43:11] Finished 'copy' after 159 ms
```

Tambien pueden hacer un `gulp watch` para autocompilar `scss` (sass).

##Artisan

Laravel viene con un CLI llamado artisan, este entre otras utilidades, sirve como interfaz para usar php como servidor local con el comando:

`php artisan serve` *(desde la carpeta del sistemaPCI/src/).*

_es decir:_ `php src/artisan serve` si estan fuera de src/

De ese comando saldra algo como:

`Laravel development server started on http://localhost:8000`

Si van a **localhost:8000** saldra una pagina de bienvenida.

*FELICIDADES, EL SISTEMA FUNCIONA!*

Adicionalmente tiene comandos de generacion de modelos, controladores, migraciones, etc. Pueden chequear los mismos con:

`php artisan`

Este comando botara la lista completa de comandos disponibles, todo documentado en [laravel.com](http://laravel.com/docs/5.0)

#Arbol de directorios simplificado

```
sistemaPCI
    ├── public
    │   ├── js y otros
    │   ├── css
    │   ├── vendor
    │   │   └── [Gulp clones] <- dependencias
    │   └── [los archivos al publico]
    ├── app
    │   ├── Http
    │   │   ├── Controllers
    │   │   │   └── [Los Controladores]
    │   │   ├── Middleware
    │   │   │   └── [Las Autentificaciones y otros]
    │   │   ├── Requests
    │   │   │   └── [las Validaciones]
    │   │   └── [El Router]
    │   ├── Models
    │   │   └── [Los Modelos]
    │   └── Repositories
    │       └── [Los Repositorios]
    ├── config
    │   └── [La configuracion del sistema]
    ├── database
    │   ├── migrations (la base de datos)
    │   └── seeds (los datos)
    ├── node_modules
    │   └── [Dependencias en NPM]
    ├── resources
    │   ├── assets
    │   ├── lang
    │   │   ├── es (traduccion completa)
    │   │   └── en (mensajes originales)
    │   └── views
    │       └── [Las Vistas]
    ├── storage
    │   └── logs (errores)
    ├── tests (las pruebas)
    └── vendor
        └── [Dependencias en Composer]
```


##PHP3D Technology Required

_PARA PODER MANIPULAR EL CODIGO FUENTE ES NECESARIO INSTALAR LA LIBRERIA PHP3D Y TENER AL MOMENTO DE MANIPULACION LOS LENTES ESPECIALES PARA ESTA GLORIOSA LABOR._

_ESTE CODIGO ESTA IMPLEMENTADO EN LOS TRES EJES ESPACIALES PRODUCIDOS EN PHP3D._

![PHP3D](https://codelab.files.wordpress.com/2010/01/nuc_shutter_glasses2.jpg)

_ADVERTENCIA: ESTE COGIDO FUENTE GENERA MIGRAÑA_

##Documentacion adicional

Dentro de este repositorio existen archivos complementarios que ayudaran en la documentacion del mismo, estos son:

CHANGELOG.md, DATASTRUC.md y DEDCHANGE.md.

##Laravel PHP Framework

Este sistema usa el framework Laravel de PHP [documentacion](http://laravel.com/docs/5.1)

###License

El framework Laravel es software codigo-abierto bajo [MIT license](http://opensource.org/licenses/MIT)
