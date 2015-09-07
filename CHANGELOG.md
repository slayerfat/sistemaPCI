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
