##Cambios en Documento de Especificacion de Diseño

En este archivo estaran los cambios pertinentes en el DED y el Documento de Especificacion de Requsitos (DER) del sistema.

##v0.0.3

####08-09-15

Creada entidad Perfil

###Errores

####08-09-15

Usuario no posee perfiles.

####07-09-15

Diagrama relacional:

- personal esta escrita como personales.
- departamentos: no posee campo telefono.
- la descripcion en fabricante, municipio, parroquia y rubro no puede ser unica.
- almacenes: el campo jefe_almace_cedula deberia ser jefe_almacen_id
- item: almacen_numero esta de mas, asociacion no puede ser nula (por defecto 'c').
- almacen_item: __NO EXISTE en el diagrama.__ necesaria por el tipo de relacion.
- encargado_almacen: fecha_seleccion puede ser nula, status por defecto es true.
- movimiento: falta tipo_movimiento_id
