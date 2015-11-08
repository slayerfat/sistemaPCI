# Estructura de Datos del sistema

En este documento se pretende mantener la bitacora de cambios significativos en la estructura de datos del sistema.

## v0.4.3

Añadido campo perecible para determinar programaticamente si el tipo de item es perecedero o no.

## v0.4.2

Añadida relacion entre tipo de pedido/nota y tipo de movimiento para determinar programaticamente los movimientos que deben hacerse en notas.

Los Items son reservados al momento de crear una nota (para evitar sobrecarga), se añade campo reserva al item.

## v0.4.1

campo encargado_id removido de la Nota, redundante.

## v0.3.4

Entraron 10 arepas.

usuario hace peticion de 10 kilos de arepas.

usuario hace peticion de 10 toneladas de arepas.

usuario hace peticion de 10 guacales de arepas.

Creado en el sistema tipo de stock o cantidad en el sistema, para aliviar y ayudar a la manipulacion aritmetica del asunto.

Tipo de Cantidad esta asociada con: item-pedido, item-movimiento, item-depot, item, item-nota. ver d5dd258

## v0.3.2

Cantidad transladado de Item a la clase de asociacion almacen-item.

Entonces, el stock o cantidad del Item seria la sumatoria de las catidades relacionadas con el item en los distintos anaqueles.

```php
class Item extends ElPitoYLaGuacharaca
{
    // ...
    public function stock()
    {
        // $x = cantidades en el almacen del item tal
        return sum($x);
    }
    // ...
}
```

Soluciona https://github.com/slayerfat/sistemaPCI/issues/35

## v0.3.1

Tipo de cantidad añadido.

10 kilos.
10 paquetes.
10 toneladas.
10 latas.
10 etc.

### TL;DR

*campo fecha de vencimento* se movio de ITEM a item_movimiento.

### Por que?

Los items no deberian tener fecha de vencimiento como atributo, debido a que estos varian segun el bache de llegada, ejemplo:

registramos item:

id  | desc  | rubro_id | ... |fecha_vencimiento|
--- | ----- | -------- | --- | --------------- |
 1  | arepa | 1        | ... | 10-11-7999      |

suponiendo: si entran 10 toneladas de arepas, que vencen en 1 mes y lo registro hoy, mañana registro que entran 2 toneladas de arepas que vencen en 1 semana, donde escribo la fecha de vencimiento?

considerando fecha por movimiento, entonces:

Movimiento:

id  | tipo_id | nota_id  | ... |fecha_vencimiento| este item vence? |
--- | ------- | -------- | --- | --------------- | ---------------- |
 1  | 1       | 1        | ... | 10-11-7999      | sip.             |
 2  | 1       | 2        | ... | null            | no vence         |
 
**PERO ESO NO SIRVE PORQUE LOS ITEMS PERCIBEN MUCHOS MOVIMIENTOS!**

entonces:

Movimiento:

id  | tipo_id | nota_id  | ... |
--- | ------- | -------- | --- |
 1  | 1       | 1        | ... |
 2  | 1       | 2        | ... |
 
Item-Movimiento:

id  | item_id | mov_id   | cantidad | fecha_vencimiento |
--- | ------- | -------- | -------- | ----------------- |
 1  | 1       | 1        | 10000    | 10-11-7999        |
 2  | 1       | 2        | 2000     | 15-16-7999        |

Item:

id  | desc  | rubro_id | ... |fecha_vencimiento|
--- | ----- | -------- | --- | --------------- |
 1  | arepa | 1        | ... | se elimina      |
 
## v0.2.7

Almacen necesita el numero de almacen (actualmente no lo tiene)

## v0.2.1

Direccion tiene una relacion 1 a 1 con Empleado (queries mas faciles y no hay restriccion que diga que no se puede hacer).

## v0.1.3

Empleado puede tener cedula de identidad y nacionalidad nulos.

## v0.1.1

Las siguientes entidades poseen un campo Slug: Categoria, Departamento, Genero, Item, Maker, Movimiento, Nacionalidad, Tipo de Nota, Tipo de Peticion, Perfil, SubCategoria.

Este campo sirve para generar enlaces bonitos en el sistema, ej: usuarios/512 -> usuarios/seudonimo

## v0.0.6

### 15-09-15

Personal/Empleado:

- El campo direccion_id puede ser nulo.

## v0.0.4

### 14-09-15

Usuario:

- el campo status fue removido.

### 13-09-15

Usuario:

- el campo status parace redundante con Perfil: desactivado
- añadido campo confirmacion que contendra el codigo de confirmacion generado por el sistema al momento de registrarse en el mismo.

## v0.0.3

### 08-09-15

Usuario:

- La entidad usuario no posee relacion con Perfiles (porque no existe).

Perfiles:

- Se creo esta entidad de apoyo que contendran los diferentes perfiles (administrador, usuario, etc.)

### 07-09-15

Personal:

el acoplamiento en Personal era elevado, se ajusto de la siguiente forma:

- las relaciones fueron extirpadas, ahora relacionadas con __Usuario y con la misma cardinalidad__:
    - Notas.
    - Pedido.
    - Encargado de Almacen.

## v0.0.2

### 07-09-15

Pedidos:

- aprobado fue cambiado por status, esto se debe a que por logica se sabe si fue aprobado o no por medio de la generacion de nota.


(Entidad) Nota:

- el campo solicitado por fue removido ya que es redundante por la existencia de la entidad Pedido (relacion solicita con Personal).
- el campo aprobado se renombro a status.

### 06-09-15

Jefe de Almacen:

- Se elimino por redundancia inutil que quitara tiempo en el futuro inmediato.

Almacen:

- Incluida relacion entre Almacen (1) y Personal (N) de 1 a N, relacion designada como alcanza.

Encargado de Almacen:

- Posee ahora una relacion 1 a 1 ya que __una persona__ solo puede ser a la vez _un encargado_ y __un encargado__ puede ser solamente _una persona_.
- __TODO:__ hacer historial de encargado de almacen.
