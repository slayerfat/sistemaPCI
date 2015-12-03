# sistemaPCI

[![Build Status](https://travis-ci.org/slayerfat/sistemaPCI.svg?branch=master)](https://travis-ci.org/slayerfat/sistemaPCI)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/slayerfat/sistemaPCI/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/slayerfat/sistemaPCI/?branch=develop)
[![Code Climate](https://codeclimate.com/github/slayerfat/sistemaPCI/badges/gpa.svg)](https://codeclimate.com/github/slayerfat/sistemaPCI)
[![Codacy Badge](https://api.codacy.com/project/badge/a1d556b5463d4a58890659bab739e53e)](https://www.codacy.com/app/slayerfat/sistemaPCI)

Sistema de Gestión de Inventario Para la Division de Rehabilitación Ocupacional.

Misión Alma Mater, Programa Nacional de Formación: Informática, Trayecto 3, IUTOMS.

- [x] v0.1 Usuario
- [x] v0.2 Empleado
- [x] v0.3 Almacén
- [x] v0.3.x Item
- [x] v0.3.x Otros
- [x] v0.4 Pedidos
- [x] v0.4.x Notas
- [ ] v0.5 PDF
- [ ] v0.6 Carpintería
- [ ] v0.7 Eventos de negocio
- [ ] v1.0 Alfa

[Ver Bitacora](https://github.com/slayerfat/sistemaPCI/blob/master/CHANGELOG.md)

[Ver KanBan](https://huboard.com/slayerfat/sistemaPCI)

## Indice

- [sistemaPCI](https://github.com/slayerfat/sistemaPCI#sistemapci)
- [Indice](https://github.com/slayerfat/sistemaPCI#indice)
- [Documentacion](https://github.com/slayerfat/sistemaPCI#documentacion)
- [Instalacion Rapida](https://github.com/slayerfat/sistemaPCI#instalacion-rapida)
- [Dependencias del Sistema](https://github.com/slayerfat/sistemaPCI#dependencias-del-sistema)
    - [Node.js](https://github.com/slayerfat/sistemaPCI#node)
    - [Bower](https://github.com/slayerfat/sistemaPCI#bower)
    - [Composer](https://github.com/slayerfat/sistemaPCI#composer)
    - [Obtener las Dependencias](https://github.com/slayerfat/sistemaPCI#obtener-las-dependecias-del-sistema)
    - [Sobre las Dependencias](https://github.com/slayerfat/sistemaPCI#sobre-las-dependencias)
    - [Gulp](https://github.com/slayerfat/sistemaPCI#gulp)
    - [Permisos](https://github.com/slayerfat/sistemaPCI#permisos)
- [Base de Datos](https://github.com/slayerfat/sistemaPCI#base-de-datos)
    - [Migraciones](https://github.com/slayerfat/sistemaPCI#migraciones)
- [Homestead](https://github.com/slayerfat/sistemaPCI#homestead)
- [Arbol de Directorios](https://github.com/slayerfat/sistemaPCI#arbol-de-directorios-simplificado)
- [Diccionario](https://github.com/slayerfat/sistemaPCI#diccionario)
- [Libreria PHP3D](https://github.com/slayerfat/sistemaPCI#php3d-technology-required)
- [Caimaneitor](https://github.com/slayerfat/sistemaPCI#caimaneitorcaimanais)
- [Estatus Bio-Psico-Social](https://github.com/slayerfat/sistemaPCI#situacion-bio-psico-social)
- [Laravel PHP Framework](https://github.com/slayerfat/sistemaPCI#laravel-php-framework)
- [Contribuciones al Repositorio](https://github.com/slayerfat/sistemaPCI#contribuciones-al-repositorio)

## Documentacion

Dentro de este repositorio existen archivos complementarios que ayudaran en la documentacion del mismo, estos son:

[CHANGELOG.md](https://github.com/slayerfat/sistemaPCI/blob/master/CHANGELOG.md), 
[DATASTRUC.md](https://github.com/slayerfat/sistemaPCI/blob/master/DATASTRUC.md), 
[DEDCHANGE.md](https://github.com/slayerfat/sistemaPCI/blob/master/DEDCHANGE.md)
y [TODO.md](https://github.com/slayerfat/sistemaPCI/blob/master/TODO.md).

## Instalacion Rapida

```bash
git clone https://github.com/slayerfat/sistemaPCI sistemaPCI 

chmod u+x sistemaPCI/caimanismo.sh 

./sistemaPCI/caimanismo.sh
```

## Dependencias del Sistema

Para poder usar el software adecuadamente, es necesario instalar los siguientes paquetes de software y sus dependencias expresadas a continuación.

**NOTA:** una vez completado los pasos necesarios para instalar las dependencias, es necesario ejecutar `gulp` en el directorio del sistema, ej: `~/sistemaPCI/src/$ gulp` 

### Node

Para usar este repositorio es necesario tener instalado en el sistema [node.js](http://nodejs.org/).

Para chequear que node esta instalado en tu sistema debes hacer un `node -v` en consola, el sistema dira `vX.YY.*` luego chequear que npm _(node package manager)_ este en el sistema con un `npm -v` en consola.

### Bower

Una vez instalado Node: `npm install --global bower` y luego ejecutar `bower install` para instalar dependencias adicionales.

### Composer
También es necesario instalar [composer](https://getcomposer.org/).

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

Chequear que este instalado `composer -V` el sistema dirá

`Composer version 1.0.-* (...) fecha`

si algo falla, chequear la documentación de
[composer](https://getcomposer.org/)

### Obtener las dependecias del sistema
_Desde la carpeta clonada:_

`composer install`

_sistemaPCI/src/:_

`npm install`
*si hace asi por el cambio de la estructura de archivos.*

Si composer se queja sobre mcrypt o mysql es probable que no tengan los modulos correspondentes activados/instalados.

Para ello deberán:

`sudo apt-get install php5-mcrypt`

`sudo apt-get install php5-mysql`

`sudo apt-get install php5-gd`

**Es de suma importancia chequear capacidad de rewrite si se pretende usar apache:** 

para usar links amigables [es necesario configurar apache u otro servidor:](http://laraveles.com/docs/5.1/ "Documentación")

> El framework viene con un archivo public/.htaccess que se utiliza para permitir URLs sin index.php. 

> Si utilizas Apache para servir tu aplicación Laravel, asegúrate de activar el módulo mod_rewrite. Si el archivo .htaccess que viene con Laravel no funciona con tu instalación de Apache, prueba con éste:

> ```apache
> Options +FollowSymLinks
> RewriteEngine On
> 
> RewriteCond %{REQUEST_FILENAME} !-d
> RewriteCond %{REQUEST_FILENAME} !-f
> RewriteRule ^ index.php [L]
> ```

solución sencilla: `sudo a2enmod rewrite`

solución complicada: [este enlace es de ayuda](http://www.google.com "lo lamento")

Si usan xampp, wampp, lampp, deberán referirse a la documentación de php para esos paquetes, puesto que, si falla composer, es muy probable que sea debido a los binarios de PHP utilizados por su computadora.

Otra opción es copiar el archivo de composer.phar a donde están los archivos de php de xampp.

*google es tu aliado*

Si todo sale bien, debera generar las carpetas `vendor/` y `node_modules/` en donde estarán las dependencias.

### Sobre las dependencias

Es importante destacar que cada branch puede tener diferentes dependencias, lo que implica hacer installs adicionales según el branch.

### Gulp

**antes de ejecutar gulp es necesario instalar Bower!** `npm install --global bower` y luego ejecutar `bower install` para instalar dependencias adicionales.

Se puede ejecutar simplemente `gulp` (dentro de la carpeta src) para copiar y compilar `sass` y otros archivos a la carpeta publica del sistema.

**NOTA: verificar que tengan gulp instalado antes de ejecutar**

se vera:

```
[21:43:07] Using gulpfile ~/sistemaPCI/src/gulpfile.js
[21:43:07] Starting 'default'...
[21:43:07] Starting 'sass'...
[21:43:09] Finished 'default' after 2.05 s
[21:43:11] gulp-notify: [Laravel Elixir]
[21:43:11] Finished 'sass' after 3.79 s
[21:43:11] Starting 'copy'...
[21:43:11] Finished 'copy' after 159 ms
```

También pueden hacer un `gulp watch` para autocompilar `scss` (sass).

### Permisos

Es necesario cambiar los permisos en algunas carpetas del sistema, esto se debe a que Laravel necesta escribir sus logs y necesita compilar ciertas cosas.

Se debe otorgar la escritura a laravel en estos directorios:

```
~/sistemaPCI/src/storage
~/sistemaPCI/src/bootstrap
```

la forma mas fácil es: `chmod go+w -R src/storage && chmod go+w -R src/bootstrap`

Si se quieren poner exóticos con los permisos, o cambiar el dueño de las carpetas en el sistema operativo, lo pueden hacer.

## Base de datos

Para instalar la base de datos en el sistema necesitan el archivo **.env** con la información de la base de datos.

En este archivo están las variables usadas por mysql.

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=SomeRandomStringOf32CharOfLenght

APP_USER=SEUDONIMO_TAL...
APP_USER_EMAIL=CORREO_TAL...
APP_USER_PASSWORD=CLAVE_TAL...
APP_USERS_PASSWORD=CLAVE_TAL...

DB_HOST=localhost
DB_DATABASE=sistemaPCI
DB_USERNAME=homestead
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

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

si por alguna razón eso falla, pueden hacer un

```
php src/artisan migrate:reset && php src/artisan migrate && php src/artisan db:seed --class="PCI\Database\DatabaseSeeder"
```

y listo, la base de datos esta localmente en el sistema.

Si falla pueden hacer un `composer dump-autoload` y reintentarlo, si vuelve a falla pueden crear un [problema (issue) en github](https://github.com/slayerfat/sistemaPCI/issues) con el error y la descripción del mismo.

### Migraciones

```
php src/artisan migrate:reset && php src/artisan migrate && php src/artisan db:seed --class="PCI\Database\DatabaseSeeder"
```

## Homestead

El sistema funciona por medio de [Homestead](http://laravel.com/docs/5.1/homestead) o por medio de apache/nginx u otro.

`~/sistemaPCI/$ vagrant up`

ver: `~/sistemaPCI/Homestead.yaml`

## Arbol de directorios simplificado

```
sistemaPCI
    ├── public
    │   ├── js y otros
    │   ├── css
    │   ├── vendor
    │   │   └── [Gulp clones] <- dependencias
    │   └── [los archivos al publico]
    └── src
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
        │   │   └── [sass, js y otros]
        │   ├── lang
        │   │   ├── es (traduccion completa)
        │   │   └── en (mensajes originales)
        │   └── views
        │       └── [Las Vistas]
        ├── storage
        │   └── logs (errores)
        ├── tests
        │   └── PCI
        |       ├── Models
        |       └── ...
        └── vendor
            └── [Dependencias en Composer]
```

## Diccionario

1. La Existencia son las unidades como tal en inventario.
1. Las Reservas es lo que se aparta de las Existencias.
1. Stock se refiere a las unidades en Existencia menos las Reservaciones.
1. En los Almacenes hay Anaqueles, los Anaqueles tienen Alacenas.
1. Los Articulos en general son Items
1. Los Items tienen Existencia en algun Alacena de algun Anaquel de algun Almacen.
1. Los Items tienen Rubros, los Rubros pertenecen a una Categoria.

## PHP3D Technology Required

*PARA PODER MANIPULAR EL CÓDIGO FUENTE ES NECESARIO INSTALAR LA LIBRERÍA PHP3D Y TENER AL MOMENTO DE MANIPULACIÓN LOS LENTES ESPECIALES ADAPTADOS EN 3D PARA ESTA GLORIOSA LABOR.*

**ESTE CODIGO ESTA IMPLEMENTADO EN LOS TRES EJES ESPACIALES PRODUCIDOS EN PHP3D.**

![PHP3D](https://codelab.files.wordpress.com/2010/01/nuc_shutter_glasses2.jpg)

_ADVERTENCIA: ESTE COGIDO FUENTE GENERA MIGRAÑA_

## Caimaneitor::caimanais()

Se creo un mega comando por medio de `Caimaneitor` se puede usar directamente en artisan con: `php src/artisan inspirar`.

También puede ser incluido en el sistema por medio de:

```php
<?php

use PCI\Mamarrachismo\Caimaneitor\Caimaneitor;

echo Caimaneitor::caimanais();
```

también posee su Facade:

```php
<?php

echo Caimaneitor::caimanais();
```

o por medio de blade: `{{ Caimaneitor::caimanais() }}`

Esta compleja implementación fue inspirada por la inspiradora `Inspire: Inspired by Illuminate\Foundation\Inspiring`

## Situacion Bio-Psico-Social

[@slayerfat:](https://github.com/slayerfat)

![@slayerfat](http://www.careerrocketeer.com/wp-content/uploads/Weary-Job-Search.png "completamente normal")

[@Phantom66:](https://github.com/Phantom66)

![@Phantom66](http://i.imgur.com/in7VByo.png "sudo su rm -rf /bin")

[@githubbt:](https://github.com/githubbt)

![@githubbt](http://www.grammarly.com/blog/wp-content/uploads/2015/01/Silhouette-question-mark.jpeg "im helping")

## Laravel PHP Framework

Este sistema usa el framework Laravel de PHP [documentacion](http://laravel.com/docs/5.1)

El framework Laravel es software código-abierto bajo [MIT](http://opensource.org/licenses/MIT)

## Contribuciones al Repositorio

1. Forkealo
2. Crea tu branch aleatorio (`git checkout -b mejoras-necesarias-e-importantes`)
3. Commit tus cambios (`git commit -am 'Estos son mis cambios!'`)
4. Push to the branch (`git push origin mejoras-necesarias-e-importantes`)
5. Crear nuevo Pull Request en Github
