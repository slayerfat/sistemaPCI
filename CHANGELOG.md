##v0.0.4

Features:

- /status creado rudimentariamente.
- Añadido SEOtools para manipular meta-data en las vistas.
- Creadas clases relacionadas con las rutas del sistema.

Cambios:

- Como todos los seeds tienen namespace, es necesario usarlos con 
    `php src/artisan db:seed --class="PCI\Database\DatabaseSeeder"`
- Gran decepcion en el uso de artisan serve: por alguna razon, ya sea por mi ignorancia
o por algun otro motivo, el servidor de php no estaba funcionando correctamente 
para jalar algunos assets (bootstrap, jquery etc.) de forma normal, sin embargo 
por medio de apache2 funciona segun lo esperado.
    - problema: artisan serve no trae los scripts y css del directorio public. 
        apache2 si lo hace sin inconveniente.
    - solucion: se implemento servidor apache para desarrollo local, 
        no deberia afectar el shared hosting, sin embargo destruiria desarrollo por 
        medio de VB como vagrant o similares.
    - alternativa: devolver sistema a estructura original (ni se cuanto tiempo quitara).
    - alternativa: ver como desacoplar este asunto de laravel.

##v0.0.3 10-09-15

Features:

- ModelFactory, todos los modelos tienen fabricas.
- Creadas Migraciones de todos los modelos del sistema.
- Añadida entidad Perfil en el sistema.
- Creado TODO.md para control interno.

Mejoras:

- Reducido acoplamiento en Personal y ajustadas interacciones con Usuario.

bugfixes:

- migraciones deberian trabajar correctamente: ajuste en mig de usuario y perfiles.

##v0.0.2 07-09-15

Documentacion:

Se crearon documentacion segun aspectos clave del sistema, para ser referenciados facilmente, estos son:

1. CHANGELOG.md: cambios de version.
1. DATASTRUC.md: cambios dentro de la estructura de datos y entidades.
1. DEDCHANGE.md: cambios relevantes en el documento de especificacion de diseño (incluyendo doc. esp. requsitos) que no impactan en la estructura de datos.

Features:

  1. Modelos
    - Todos los modelos segun el diagrama de clases refinado completado.
    - creadas pruebas relacionadas a todos los modelos implementados. _incompletas, solo relaciones clave._
      
  1. Migraciones
    - todas las migraciones completadas.
    
  1. Integracion continua
    - primeros pasos establecidos para integracion continua por medio de travis y scrutinizer.
    
Bugfixes:
    
  - ajustado forma en la que se trabaja composer, phpunit y otros servicios.
  - `replace.php` deberia funcionar correctamente.
  - cypher deberia funcionar por cambio de strings de tamaño 32.
