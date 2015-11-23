# Cambios en Documento de Especificacion de Diseño

En este archivo estaran los cambios pertinentes en el DED y el Documento de Especificacion de Requsitos (DER) del sistema, asi como notas, apuntes, reclamos y otros que sean pertinentes especificamente para estos documentos.

## Notas

Detalles, observaciones u otros:

#### 19-11-15

Aclaratoria de terminologia usada en el sistema:

1. La Existencia son las unidades como tal en inventario.
1. Las Reservas es lo que se aparta de las Existencias.
1. Stock se refiere a las unidades en Existencia menos las Reservaciones.
1. En los Almacenes hay Anaqueles, los Anaqueles tienen Alacenas.
1. Los Articulos en general son Items
1. Los Items tienen Existencia en algun Alacena de algun Anaquel de algun Almacen.
1. Los Items tienen Rubros, los Rubros pertenecen a una Categoria.

#### 17-10-15

Notas tiene el campo encargado repetido, en otras palabras parece ser redundante con el campo solicitado por.

en otras palabras: 

```php
<?php

// esto funciona perfectamente:
$nota = Nota::find(1);

$nota->solicitante  // el usuario que creo la nota (encargado/jefe/administrador)
$nota->dirigido     // usuario a donde va la nota (el que creo el pedido)

// para salvar la nota
$usuario = usuarioActualEnSistema();
$usuario->notas()->salvar($nota);

// si quiero el usuario que hizo
// el pedido a lo caiman:
$nota->pedido->usuario; // usuario que lo solicito
```

#### 16-10-15

Usuario no debe poder modificar/eliminar Pedido que ya haya sido aprobado/rechazado.
Usuario no debe poder modificar/eliminar Pedido que ya haya generado notas.

lo anterior aplica a Nota y Movimientos.

#### 15-10-15

usuario puede solicitar la aprobacion de pedido ya creado.

#### 12-10-15

¿Porque pedido tiene fecha de pedido si el mismo ya posee campos de creado y actualizado?
este campo es inutil bajo su proposito.

#### 27-09-15

Almacen necesita el numero de almacen (actualmente no lo tiene)

#### 22-09-15

Empleado es ahora 1 a 1 con direccion, explicacion:

Cuando se manipula una direccion, es mas conveniente generarla de 1 a 1 con empleado, porque si es por ejemplo una relacion 1 a N, entonces desde direccion, como se sabe el Id del usuario impactado por el cambio?

En otras palabras:

```php
<?php

// esto funciona perfectamente:
$empleado  = Empleado::find(1);
$direccion = $empleado->direccion;

$direccion->calle = 'tal calle';

$direccion->save();

$usuario = $empleado->usuario;

return $usuario instanceof Usuario; // verdadero
```

En cambio, a la inversa:

```php
<?php

$direccion = Direccion::find(1);
$direccion->calle = 'tal calle';

$direccion->save();

$usuario = $direccion->empleado->usuario;

// si la relacion de Direccion y Empleado es N a 1
// este retorno regresa una coleccion, no un modelo
return $usuario instanceof Usuario; // falso (instanceof Collection)

// si la relacion de Direccion y Empleado es 1 a 1
// este retorno regresa un modelo
return $usuario instanceof Usuario; // verdadero
```

como en los requerimientos del sistema no especifican nada sobre las direcciones y los empleados, este cambio es valido.

#### 17-09-15

Las entidades no poseen un campo que ayude a generar urls. (slugs).

Las siguientes entidades poseen un campo Slug: Categoria, Departamento, Genero, Item, Maker, Movimiento, Nacionalidad, Tipo de Nota, Tipo de Peticion, Perfil, SubCategoria.

#### 13-09-15

La entidad Usuario posee un campo status que parece redundante con Perfil: Desactivado.

#### 09-09-15

Faltan las instancias las siguientes entidades:

- Rubro.
- Cargo.
- Fabricante.
- Tipo de Moviento.

Las siguientes entidades poseen instancias incompletas:
- Categoria.
- Tipo de Nota.
- Tipo de Pedido.
- Departamento

## Errores

#### 08-09-15

Usuario no posee perfiles.

#### 07-09-15

Diagrama relacional:

- personal esta escrita como personales.
- departamentos: no posee campo telefono.
- la descripcion en fabricante, municipio, parroquia y rubro no puede ser unica.
- almacenes: el campo jefe_almace_cedula deberia ser jefe_almacen_id.
- item: almacen_numero esta de mas, asociacion no puede ser nula (por defecto 'c').
- almacen_item: __NO EXISTE en el diagrama.__ necesaria por el tipo de relacion.
- encargado_almacen: fecha_seleccion puede ser nula, status por defecto es true.
- movimiento: falta tipo_movimiento_id.

## Otros

### v0.0.3

#### 08-09-15

Creada entidad Perfil.
