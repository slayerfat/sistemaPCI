#Estructura de Datos del sistema

En este documento se pretende mantener la bitacora de cambios significativos en la estructura de datos del sistema.

##v0.0.2-0 06-09-15

- Se elimino jefe de almacen y fue incluida esta relacion en la entidad almacen en donde esta posee personal_id para ser una relacion 1 a n.
- Ecargado de almacen posee ahora una relacion 1 a 1 ya que __una persona__ solo puede ser a la vez _un encargado_ y __un encargado__ puede ser solamente _una persona_. __TODO:__ hacer historial de encargado de almacen. 
