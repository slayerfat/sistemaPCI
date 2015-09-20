# Cambios en Documento de Especificacion de Diseño

En este archivo estaran los cambios pertinentes en el DED y el Documento de Especificacion de Requsitos (DER) del sistema, asi como notas, apuntes, reclamos y otros que sean pertinentes especificamente para estos documentos.

## Notas

Detalles, observaciones u otros:

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
