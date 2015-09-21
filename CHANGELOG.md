## v0.1.2

Features:

- navbar mejorado
- implementados a la lsita de recursos genericos: Genero, Tipo de Item

Mejoras:

- Las siguientes entidades poseen un campo Slug: Cargo

## v0.1.1 19-07-15

Features:

- Recursos genericos/Auxiliares completos (gestion de Categoria, Perfiles, etc.), todos estos pueden cumplir las actividades basicas:
    1. consultar listado
    1. consultar singular
    1. crear
    1. actualizar
    1. eliminar
- creados Repositorios, Proveedores y otros necesarios para: Categoria, Departamento
- creadas algunas pruebas de integracion.

Mejoras:

- Mejorada interfaces de repos, un poco mas abstracto.
- creada funcion mamarrachamente que genera el directorio publico de la aplicacion.
- Las siguientes entidades poseen un campo Slug: Categoria, Departamento, Genero, Item, Maker, Movimiento, Nacionalidad, Tipo de Nota, Tipo de Peticion, Perfil, SubCategoria.

## v0.0.6 17-09-15

Features:

- modulo esencial de usuario completado.
- creado PhoneParser: manipula telefonos segun formato venezolano, (`Mamarrachamente`).
- **Caimaneitor** posee sus propios **JIUNITESS**.

Mejoras:

- restructurada carpeta de tests.
- creadas pruebas adicionales.
- creada polizas de usuario: UserPolicy.
- Middleware: creado RedirectIfNotAdmin, para chequear el perfil de adiministrador del usuario.
- Providers: UserDeletingServiceProvider, para manipular de ser necesario al usuario cuando es eliminado.

## v0.0.5 14-09-15

Features:

- **Caimaneitor: ENJANST!**
- implementacion parcial de modulo de usuarios.

Mejoras:

- añadidas algunas pruebas del repositorio de usuarios y el modelo de usuarios.

## v0.0.4 13-09-15

Features:

- **Creado Caimaneitor:** `php artisan inspirar`
- Creadp Repositorio parcial de Usuario.
- /status creado rudimentariamente.
- Añadido SEOtools para manipular meta-data en las vistas.
- Creadas clases relacionadas con las rutas del sistema.
- Creados archivos relacionados a mensajes en español en el sistema, tambien incluidos mensajes globales.
- Creado proceso de Autenticacion y Autorizacion de Usuario.
- creado evento de registro de nuevo usuario (enviar email, codigo de autorizacion, etc...)
- flujo completo de Usuario se registra, Usuario necesita verificacion, Usuario verifica.

Cambios:

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

## v0.0.3 10-09-15

Features:

- ModelFactory, todos los modelos tienen fabricas.
- Creadas Migraciones de todos los modelos del sistema.
- Añadida entidad Perfil en el sistema.
- Creado TODO.md para control interno.

Mejoras:

- Reducido acoplamiento en Personal y ajustadas interacciones con Usuario.

bugfixes:

- migraciones deberian trabajar correctamente: ajuste en mig de usuario y perfiles.

## v0.0.2 07-09-15

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
