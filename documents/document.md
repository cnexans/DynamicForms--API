# Diseño de api


## Requerimientos iniciales
- Crear instancia de respuesta de formulario, devolver id. 
    + answer/create -> id
- Insertar respuesta a un campo.  
    + id -> answer/field  -> sucess!
- Eliminar respuesta a formulario dado un id. 
    + id -> answer/delete -> sucess!
- Devolver id de respuestas, dado un id de formulario.
    + id_form o id_usuario -> [id_form_resp]
- Dada un id de resp de formulario, entregar ids de respuesta.
    +  id_form_resp -> {resultados}
- Dado un id de estructura de formulario, entregar estructura y nombre
    + id_form -> {estructura}
- Crear nuevo tipo de formulario
- Crear usuario indicando rol y datos
- Asociar usuario con 'puede_responder' a un formulario 
- Lista usuarios (todos o por rol)
- lista de formularios que puedo responde [ids]
- eliminar usuario
- password reset

## Permisos
1 . empleado
2 . empleado
3 . empleado,gerente(sus formulario), presidente(universo)
4 . gerente(sus formulario), presidente(universo)
5 . gerente(sus formulario), presidente(universo)
6 . gerente, presidente
7 . todos
8 . gerente,presidente
9 . gerente(empleados),presidente(empleados, gerentes)
10. gerente,presidente
11. gerente,presidente
12. empleado
13. gerente(empleados),presidente(empleados, gerentes)
14. todo

Notas: TODOS LOS DELETE deben ser soft


# Inicio de swagger
Markup :  `code()`
{
    "swagger": "2.0",
    "schemes": [
        "http"
    ],
    "host": "localhost:8000",
    "info": {
        "version": "",
        "title": "Laravel api server",
        "description": "## Welcome\n\nThis is a place to put general notes and extra information, for internal use.\n\nTo get started designing/documenting this API, select a version on the left."
    },
    "paths": {},
    "definitions": {
        "form": {
            "type": "object",
            "description": "Form identity",
            "properties": {
                "id": {
                    "type": "integer"
                },
                "created_at": {
                    "type": "string",
                    "description": "When it was created",
                    "format": "date-time"
                },
                "created_by": {
                    "type": "object"
                }
            },
            "required": [
                "created_at",
                "created_by"
            ]
        }
    }
}
Markup : ```javascript
         ```