# Change Log

Todos los cambios significativos en este proyecto estaran documentados en este archivo. Este proyecto intenta seguir el [Versionamiento Semantico](http://semver.org/).

## [En Desarrollo][unrele]

### Añadido

- Tipo de items poseen atributo por defecto no perecedero (es necesario para determinar si un item es o no perecedero si el usuario crea tipo de items adicionales).
- Fecha de vencimiento relacionada con items en notas (y en movimientos).

## [v0.4.2] - 2015-11-07

### Añadido

- Creacion de Nota/movimientos y correos relacionados a estos.
- Item posee campo reserva (de stock).

### Arreglado

- Notas necesitan usuario dirigido a, seeding actualizado para eso.
- Envio de correos por defecto desactivado en el sistema.
- Relacion entre Tipo de Pedido y Tipo de Movimiento (para saber si es entrada o salida)
- Relacion entre Tipo de Nota y Tipo de Movimiento (para saber si es entrada o salida)
- Pedido debe permitir nuevo si es entrada y stock es 0

## [v0.4.1] - 2015-10-18

### Añadido

- Index y Creacion de Notas con eventos de Email.

## [v0.4.0] - 2015-10-16

### Añadido

- Documentacion

## [v0.3.6] - 2015-10-16

### Añadido

- Nuevas Peticiones, estas pueden enviar correos a todas las partes interesadas en la creacion de una nueva.
- Apis de pedido y tipo de stock (necesario para crear/actualizar pedido).

### Cambiado

- Modelos tienen campos ocultos de creado/actualizado en/por por defecto, ver AbstractBaseModel.
- Eventos y Listeners parcialmente jerarquizados.

### Arreglado

- Pivote de Pedido no tenia tipo de stock.
- Añadido trans en algunas vistas.

## [v0.3.5] - 2015-10-03

### Añadido

- Inflector para manejo de plurales en tipo de stock.

## [v0.3.4] - 2015-10-02

### Añadido

- Tipo de Cantidad.

## [v0.3.3] - 2015-10-02

### Añadido

- Cargos completamente olvidados, ya añadidos al sistema.

## [v0.3.2] - 2015-10-02

### Añadido

- Parciales adicionales, ver resources/partials

### Cambiado

- Stock de Item a depot-item.

## [v0.3.1] - 2015-10-01

### Añadido

- Recurso completo de item.

## [v0.3.0] - 2015-09-29

### Cambiado

- Almacenes, parcialmente mejorado, preparando para item.

## [v0.2.7] - 2015-09-29

### Añadido

- Recurso de Almacen **parcialmente.** Faltan detalles antes de hacer algunas interacciones entre almacen/item/pedidos, etc.

### Cambiado

- Mejorado navbar: chequea al usuario y brinda links segun el perfil.

## [v0.2.6] - 2015-09-26

### Cambiado

Pruebas de navbar.

## [v0.2.5] - 2015-09-26

### Añadido

- Recurso de Datos Laborales.

## [v0.2.4] - 2015-09-25

### Añadido

- Pruebas, Pruebas, Pruebas.

## [v0.2.3] - 2015-09-24

### Añadido

- Ampliada documentacion en polizas, Controllers, Repos, etc..

## [v0.2.2] - 2015-09-24

### Añadido:

- Mejor documentacion interna en las clases de Providers y Repositories

### Cambiado:

- Mejorado ModelFactory
- Carpinteria en app/Providers y app/Repositories
- El Changelog con [este 'standard'](https://github.com/olivierlacan/keep-a-changelog)

## [v0.2.1] - 2015-09-23

### Añadido:

- creada direccion de Empleado.
- creado api interno de Estados, Municpios, Parroquias.

### Cambiado:

- Direcciones cambiado 1 a 1 con Empleado. (ver DEDCHANGE.md 22-09-15)

## [v0.2.0] - 2015-09-22

### Añadido:

- creado recurso de Empleados.

### Cambiado:

- actualizado resources/lang/es/models.php
- Carpinteria genderal en src/app/

## v0.1.2 - 2015-09-21

### Añadido:

- navbar mejorado
- implementados a la lista de recursos genericos: todos excepto Estado, Municipio, Parroquia

### Cambiado:

- Las siguientes entidades poseen un campo Slug: Cargo

## [v0.1.1] - 2015-09-19

### Añadido:

- Recursos genericos/Auxiliares completos (gestion de Categoria, Perfiles, etc.), todos estos pueden cumplir las actividades basicas:
    1. consultar listado
    1. consultar singular
    1. crear
    1. actualizar
    1. eliminar
- creados Repositorios, Proveedores y otros necesarios para: Categoria, Departamento
- creadas algunas pruebas de integracion.

### Cambiado:

- Mejorada interfaces de repos, un poco mas abstracto.
- creada funcion mamarrachamente que genera el directorio publico de la aplicacion.
- Las siguientes entidades poseen un campo Slug: Categoria, Departamento, Genero, Item, Maker, Movimiento, Nacionalidad, Tipo de Nota, Tipo de Peticion, Perfil, SubCategoria.

## [v0.1.0] - 2015-09-17

### Añadido:

- modulo esencial de usuario completado.
- creado PhoneParser: manipula telefonos segun formato venezolano, (`Mamarrachamente`).
- **Caimaneitor** posee sus propios **JIUNITESS**.

### Cambiado:

- restructurada carpeta de tests.
- creadas pruebas adicionales.
- creada polizas de usuario: UserPolicy.
- Middleware: creado RedirectIfNotAdmin, para chequear el perfil de adiministrador del usuario.
- Providers: UserDeletingServiceProvider, para manipular de ser necesario al usuario cuando es eliminado.

## [v0.0.5] - 2015-09-14

### Añadido:

- **Caimaneitor: ENJANST!**
- implementacion parcial de modulo de usuarios.

### Cambiado:

- añadidas algunas pruebas del repositorio de usuarios y el modelo de usuarios.

## [v0.0.4] - 2015-09-13

### Añadido:

- **Creado Caimaneitor:** `php artisan inspirar`
- Creadp Repositorio parcial de Usuario.
- /status creado rudimentariamente.
- Añadido SEOtools para manipular meta-data en las vistas.
- Creadas clases relacionadas con las rutas del sistema.
- Creados archivos relacionados a mensajes en español en el sistema, tambien incluidos mensajes globales.
- Creado proceso de Autenticacion y Autorizacion de Usuario.
- creado evento de registro de nuevo usuario (enviar email, codigo de autorizacion, etc...)
- flujo completo de Usuario se registra, Usuario necesita verificacion, Usuario verifica.

### Cambiado:

- Como todos los seeds tienen namespace, es necesario usarlos con `php src/artisan db:seed --class="PCI\Database\DatabaseSeeder"`
- Gran decepcion en el uso de artisan serve: por alguna razon, ya sea por mi ignorancia o por algun otro motivo, el servidor de php no estaba funcionando correctamente para jalar algunos assets (bootstrap, jquery etc.) de forma normal, sin embargo por medio de apache2 funciona segun lo esperado.
    - problema: artisan serve no trae los scripts y css del directorio public.
        apache2 si lo hace sin inconveniente.
    - **solucion:** utilizando Homestead.
    - alternativa: se implemento servidor apache para desarrollo local,
        no deberia afectar el shared hosting, sin embargo destruiria desarrollo por
        medio de VB como vagrant o similares.
    - alternativa: devolver sistema a estructura original (no se cuanto tiempo quitara).
    - alternativa: ver como desacoplar este asunto de laravel (tiempo?).

## [v0.0.3] - 2015-09-10

### Añadido:

- ModelFactory, todos los modelos tienen fabricas.
- Creadas Migraciones de todos los modelos del sistema.
- Añadida entidad Perfil en el sistema.
- Creado TODO.md para control interno.

### Cambiado:

- Reducido acoplamiento en Personal y ajustadas interacciones con Usuario.

Arreglado:

- migraciones deberian trabajar correctamente: ajuste en mig de usuario y perfiles.

## [v0.0.2] - 2015-09-07

### Documentacion:

Se crearon documentacion segun aspectos clave del sistema, para ser referenciados facilmente, estos son:

1. CHANGELOG.md: cambios de version.
1. DATASTRUC.md: cambios dentro de la estructura de datos y entidades.
1. DEDCHANGE.md: cambios relevantes en el documento de especificacion de diseño (incluyendo doc. esp. requsitos) que no impactan en la estructura de datos.

### Añadido:

  1. Modelos
    - Todos los modelos segun el diagrama de clases refinado completado.
    - creadas pruebas relacionadas a todos los modelos implementados. _incompletas, solo relaciones clave._

  1. Migraciones
    - todas las migraciones completadas.

  1. Integracion continua
    - primeros pasos establecidos para integracion continua por medio de travis y scrutinizer.

### Arreglado:

  - ajustado forma en la que se trabaja composer, phpunit y otros servicios.
  - `replace.php` deberia funcionar correctamente.
  - cypher deberia funcionar por cambio de strings de tamaño 32.

[unrele]: https://github.com/slayerfat/sistemaPCI/compare/v0.4.5...develop
[v0.4.5]: https://github.com/slayerfat/sistemaPCI/compare/v0.4.4...v0.4.5
[v0.4.4]: https://github.com/slayerfat/sistemaPCI/compare/v0.4.3...v0.4.4
[v0.4.3]: https://github.com/slayerfat/sistemaPCI/compare/v0.4.2...v0.4.3
[v0.4.2]: https://github.com/slayerfat/sistemaPCI/compare/v0.4.1...v0.4.2
[v0.4.1]: https://github.com/slayerfat/sistemaPCI/compare/v0.4.0...v0.4.1
[v0.4.0]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.6...v0.4.0
[v0.3.6]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.5...v0.3.6
[v0.3.5]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.4...v0.3.5
[v0.3.4]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.3...v0.3.4
[v0.3.3]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.2...v0.3.3
[v0.3.2]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.1...v0.3.2
[v0.3.1]: https://github.com/slayerfat/sistemaPCI/compare/v0.3.0...v0.3.1
[v0.3.0]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.7...v0.3.0
[v0.2.7]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.6...v0.2.7
[v0.2.6]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.5...v0.2.6
[v0.2.5]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.4...v0.2.5
[v0.2.4]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.3...v0.2.4
[v0.2.3]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.2...v0.2.3
[v0.2.2]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.1...v0.2.2
[v0.2.1]: https://github.com/slayerfat/sistemaPCI/compare/v0.2.0...v0.2.1
[v0.2.0]: https://github.com/slayerfat/sistemaPCI/compare/v0.1.2...v0.2.0
[v0.1.2]: https://github.com/slayerfat/sistemaPCI/compare/v0.1.1...v0.1.2
[v0.1.1]: https://github.com/slayerfat/sistemaPCI/compare/v0.1.0...v0.1.1
[v0.1.0]: https://github.com/slayerfat/sistemaPCI/compare/v0.0.5...v0.1.0
[v0.0.5]: https://github.com/slayerfat/sistemaPCI/compare/v0.0.4...v0.0.5
[v0.0.4]: https://github.com/slayerfat/sistemaPCI/compare/v0.0.3...v0.0.4
[v0.0.3]: https://github.com/slayerfat/sistemaPCI/compare/v0.0.2...v0.0.3
[v0.0.2]: https://github.com/slayerfat/sistemaPCI/compare/v0.0.1...v0.0.2
[v0.0.1]: https://github.com/slayerfat/sistemaPCI/compare/v0.0.1-0...v0.0.1
