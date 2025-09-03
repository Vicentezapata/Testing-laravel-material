# Historias de Usuario - TaskMaster

## Historia 1: Como usuario quiero ver la lista de tareas para gestionar mi trabajo

**Como** usuario
**Quiero** ver todas las tareas existentes en el sistema
**Para** poder gestionar y priorizar mi trabajo

### Criterios de aceptación (Gherkin)
```gherkin
Feature: Listado de tareas
  Scenario: Ver todas las tareas
    Given existen tareas registradas en el sistema
    When accedo a la página de listado de tareas
    Then veo una tabla con todas las tareas y sus detalles
```

---

## Historia 2: Como usuario quiero crear una nueva tarea para organizar mis pendientes

**Como** usuario
**Quiero** crear una nueva tarea
**Para** organizar mis pendientes y asignarla a un proyecto

### Criterios de aceptación (Gherkin)
```gherkin
Feature: Creación de tareas
  Scenario: Crear una tarea nueva
    Given estoy en la página de creación de tareas
    When completo el formulario con título, descripción y proyecto
    And presiono el botón "Guardar Tarea"
    Then la tarea se guarda y aparece en el listado
```

---

## Historia 3: Como usuario quiero editar una tarea para corregir o actualizar información

**Como** usuario
**Quiero** editar una tarea existente
**Para** corregir errores o actualizar información relevante

### Criterios de aceptación (Gherkin)
```gherkin
Feature: Edición de tareas
  Scenario: Editar una tarea existente
    Given existe una tarea creada
    When accedo a la opción de editar de esa tarea
    And modifico los campos necesarios
    And guardo los cambios
    Then la tarea se actualiza y los cambios se reflejan en el listado
```

---

## Historia 4: Como usuario quiero eliminar una tarea para mantener mi lista actualizada

**Como** usuario
**Quiero** eliminar una tarea
**Para** mantener mi lista de tareas actualizada y sin elementos innecesarios

### Criterios de aceptación (Gherkin)
```gherkin
Feature: Eliminación de tareas
  Scenario: Eliminar una tarea
    Given existe una tarea en el sistema
    When selecciono la opción de eliminar
    And confirmo la eliminación
    Then la tarea desaparece del listado
```

---

## Historia 5: Como usuario quiero ver a qué proyecto pertenece cada tarea

**Como** usuario
**Quiero** ver el nombre del proyecto asociado a cada tarea
**Para** identificar rápidamente el contexto de cada pendiente

### Criterios de aceptación (Gherkin)
```gherkin
Feature: Visualización de proyecto en tareas
  Scenario: Ver proyecto asociado en el listado
    Given existen tareas asociadas a proyectos
    When accedo al listado de tareas
    Then veo el nombre del proyecto junto a cada tarea
```

---

## Historia 6: Como usuario quiero consumir la API para integrar TaskMaster con otras aplicaciones

**Como** usuario desarrollador
**Quiero** acceder a la API RESTful de tareas
**Para** integrar TaskMaster con otras aplicaciones o automatizaciones

### Criterios de aceptación (Gherkin)
```gherkin
Feature: Consumo de API de tareas
  Scenario: Obtener todas las tareas vía API
    Given existen tareas en la base de datos
    When hago una petición GET a /api/tasks
    Then recibo un JSON con la lista de tareas y sus detalles
```
