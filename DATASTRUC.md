#Estructura de Datos del sistema

En este documento se pretende mantener la bitacora de cambios significativos en la estructura de datos del sistema.

##v0.0.3

Personal:

- el acoplamiento en personal es elevado, se ajusto de la siguiente forma:
  - ...

##v0.0.2

###07-09-15

Pedidos:

- aprobado fue cambiado por status, esto se debe a que por logica se sabe si fue aprobado o no por medio de la generacion de nota.


(Entidad) Nota:

- el campo solicitado por fue removido ya que es redundante por la existencia de la entidad Pedido (relacion solicita con Personal). 
- el campo aprobado se renombro a status.

###06-09-15

Jefe de Almacen:

- Se elimino por redundancia inutil que quitara tiempo en el futuro inmediato. 

Almacen:

- Incluida relacion entre Almacen (1) y Personal (N) de 1 a N, relacion designada como alcanza.

Encargado de Almacen:

- Posee ahora una relacion 1 a 1 ya que __una persona__ solo puede ser a la vez _un encargado_ y __un encargado__ puede ser solamente _una persona_.
- __TODO:__ hacer historial de encargado de almacen. 
