# Guía de Laboratorio Exhaustiva: Automatización de Pruebas Funcionales y de Rendimiento en Aplicaciones Laravel

## Parte I: Fundamentos y Preparación del Entorno

### Sección 1: El Ecosistema de Pruebas en Laravel: Un Enfoque Metodológico

#### Introducción a la Filosofía de Testing de Laravel

Laravel es un framework diseñado con la verificabilidad como pilar fundamental. Proporciona de fábrica un robusto conjunto de herramientas para la creación de pruebas, con soporte para PHPUnit integrado desde el inicio y un archivo de configuración phpunit.xml preconfigurado.<sup>1</sup> La filosofía subyacente no se limita a la detección de errores, sino que promueve la escritura de código más estable, mantenible y fiable a largo plazo. Las pruebas automatizadas actúan como una red de seguridad que permite a los desarrolladores refactorizar el código y añadir nuevas funcionalidades con la confianza de que las características existentes no se han visto comprometidas.<sup>3</sup>

#### La Dicotomía Fundamental: Pruebas Unitarias vs. Pruebas de Características

Una de las decisiones de diseño más importantes en el ecosistema de pruebas de Laravel es la estricta separación entre dos tipos de pruebas: Unitarias (Unit) y de Características (Feature). Esta distinción no es meramente organizativa; responde a una necesidad fundamental de optimizar el ciclo de desarrollo, equilibrando velocidad y confianza. La causa principal de esta separación es el coste computacional asociado al arranque del framework completo. Arrancar una aplicación Laravel implica cargar proveedores de servicios, configuraciones, y establecer conexiones, lo cual consume tiempo y recursos. Al permitir que ciertas pruebas se ejecuten sin este sobrecoste, se fomenta un ciclo de retroalimentación extremadamente rápido para la lógica de negocio central.

##### Pruebas Unitarias (Unit Tests)

Las pruebas unitarias están diseñadas para enfocarse en una porción muy pequeña y aislada del código, típicamente un único método.<sup>1</sup> La característica definitoria de las pruebas ubicadas en el directorio

tests/Unit es que **no arrancan el framework de Laravel** por diseño.<sup>2</sup> Como consecuencia directa, estas pruebas no tienen acceso a servicios del framework como la base de datos, el sistema de caché, o las sesiones. Su propósito es verificar la lógica pura de un componente en completo aislamiento, lo que las hace extremadamente rápidas de ejecutar. Son ideales para probar algoritmos, clases de servicio con lógica de negocio compleja pero sin dependencias externas, u objetos de valor.

##### Pruebas de Características (Feature Tests)

En contraste, las pruebas de características están diseñadas para verificar porciones más amplias del código, incluyendo la interacción entre múltiples objetos o, más comúnmente, una solicitud HTTP completa a un endpoint de la aplicación.<sup>1</sup> A diferencia de las pruebas unitarias, estas pruebas

**sí arrancan el framework Laravel**, lo que les otorga acceso completo a todos sus servicios. Esto permite simular peticiones web, interactuar con la base de datos, manipular sesiones y verificar las respuestas JSON de una API.<sup>7</sup> La documentación y las mejores prácticas sugieren que la mayoría de las pruebas de una aplicación deberían ser de este tipo, ya que proporcionan el mayor nivel de confianza en que el sistema, en su conjunto, funciona como se espera.<sup>2</sup>

#### Creación y Ejecución de Pruebas

Laravel simplifica la creación de archivos de prueba a través de comandos de Artisan. Para generar una nueva prueba, se utiliza el comando make:test. Por defecto, crea una prueba de características:

Bash

\# Crea una prueba en el directorio tests/Feature  
php artisan make:test UserTest  

Para crear una prueba unitaria, se debe añadir el flag --unit:

Bash

\# Crea una prueba en el directorio tests/Unit  
php artisan make:test UserTest --unit  

<sup>2</sup>

La ejecución de la suite de pruebas completa se puede realizar con el comando de Artisan test o directamente con el binario de PHPUnit:

Bash

php artisan test  
\# O alternativamente  
./vendor/bin/phpunit  

<sup>1</sup>

#### Configuración del Entorno de Pruebas

Al ejecutar las pruebas, Laravel establece automáticamente el entorno de configuración a testing. Esta configuración está definida en el archivo phpunit.xml, donde también se fuerza el uso del driver array para la sesión y la caché, asegurando que no se persistan datos entre ejecuciones de pruebas.<sup>2</sup> Para configuraciones más específicas, como una base de datos en memoria para las pruebas, se puede crear un archivo

.env.testing en la raíz del proyecto. Este archivo tendrá precedencia sobre el .env principal cuando se ejecute la suite de pruebas.<sup>1</sup>

| Característica | Pruebas Unitarias (Unit Tests) | Pruebas de Características (Feature Tests) |
| --- | --- | --- |
| **Propósito Principal** | Verificar una pequeña unidad de código aislada (ej. un método). | Verificar la interacción de varios componentes o un flujo completo. |
| --- | --- | --- |
| **¿Arranca el Framework Laravel?** | No.<sup>2</sup> | Sí.<sup>6</sup> |
| --- | --- | --- |
| **Acceso a la Base de Datos** | No disponible. | Disponible y comúnmente utilizado.<sup>7</sup> |
| --- | --- | --- |
| **Velocidad de Ejecución** | Muy alta. | Moderada (más lenta que las unitarias). |
| --- | --- | --- |
| **Caso de Uso Típico** | Probar un cálculo en una clase de servicio. | Probar un endpoint de una API REST, desde la petición hasta la respuesta. |
| --- | --- | --- |
| **Ubicación por Defecto** | tests/Unit | tests/Feature |
| --- | --- | --- |

### Sección 2: Creación de la Aplicación de Muestra para el Laboratorio (SUT)

Para llevar a cabo las prácticas de este laboratorio, se requiere una aplicación Laravel que sirva como "Sistema Bajo Prueba" (SUT, por sus siglas en inglés). A continuación, se proporciona una plantilla de especificaciones detallada para ser utilizada con una IA de programación, seguida de las instrucciones para la configuración manual del proyecto resultante.

#### Subsección 2.1: Plantilla de Especificaciones para la IA de Programación

Actúa como un desarrollador senior de Laravel. Genera el código completo para una aplicación Laravel 12.x llamada 'TaskMaster'. La aplicación será una API RESTful simple para gestionar tareas de proyectos, con una interfaz web básica para la interacción manual. Sigue estrictamente estas especificaciones:  
<br/>1\. \*\*Modelo de Datos y Migraciones:\*\*  
\* Crea un modelo Eloquent \`Project\` con los campos: \`name\` (string), \`description\` (text).  
\* Crea un modelo Eloquent \`Task\` con los campos: \`title\` (string), \`description\` (text), \`status\` (enum: 'pending', 'in_progress', 'completed', con 'pending' como valor por defecto), \`due_date\` (date, nullable).  
\* Establece una relación \`belongsTo\` desde \`Task\` hacia \`Project\`.  
\* Genera los archivos de migración correspondientes para crear las tablas \`projects\` y \`tasks\` con sus respectivos campos y la clave foránea.  
<br/>2\. \*\*Factories y Seeders:\*\*  
\* Crea un \`ProjectFactory\` y un \`TaskFactory\` utilizando datos ficticios realistas.  
\* Crea un \`DatabaseSeeder\` que genere 3 proyectos y asigne 5 tareas a cada proyecto.  
<br/>3\. \*\*API RESTful:\*\*  
\* Genera un \`TaskController\` para la API usando el comando \`php artisan make:controller Api/TaskController --api\`.  
\* Implementa los métodos estándar (index, store, show, update, destroy) para las tareas.  
\* Genera un \`TaskResource\` para estandarizar la salida JSON de la API, asegurando que las respuestas sean consistentes.\[9\]  
\* Define las rutas en \`routes/api.php\` utilizando \`Route::apiResource('tasks', TaskController::class)\`.  
<br/>4\. \*\*Interfaz de Usuario (UI) Básica:\*\*  
\* Genera un \`WebTaskController\` con dos métodos: \`index\` y \`create\`.  
\* Crea una vista Blade en \`resources/views/tasks/index.blade.php\` que muestre una tabla con todas las tareas existentes.  
\* Crea una vista Blade en \`resources/views/tasks/create.blade.php\` con un formulario simple para crear una nueva tarea. El formulario debe tener campos para \`title\`, \`description\` y un \`select\` para el proyecto al que pertenece.  
\* Define las rutas correspondientes en \`routes/web.php\`.  
<br/>5\. \*\*Pruebas Iniciales:\*\*  
\* Genera una prueba de características en \`tests/Feature/TaskApiTest.php\`.  
\* Añade un método de prueba \`test_can_get_all_tasks\` que haga una petición GET a \`/api/tasks\` y verifique que la respuesta tenga un código de estado 200 y la estructura JSON esperada.  

#### Subsección 2.2: Guía de Instalación y Configuración Manual

Una vez que la IA ha generado el código base, los estudiantes deben seguir estos pasos para poner en marcha la aplicación.

1. **Prerrequisitos:** Asegurarse de tener un entorno de desarrollo PHP funcional, con Composer instalado.<sup>10</sup> Para este laboratorio, se recomienda configurar una base de datos SQLite para simplificar el proceso.
2. **Instalación del Proyecto:** Clonar el repositorio generado por la IA y, desde la terminal en el directorio raíz del proyecto, instalar las dependencias de PHP:  
    Bash  
    composer install  
    <br/><sup>11</sup>
3. **Configuración del Entorno:**
    - Copiar el archivo de configuración de ejemplo:  
        Bash  
        cp.env.example.env  

    - Generar la clave de encriptación de la aplicación:  
        Bash  
        php artisan key:generate  

.<sup>11</sup>

- - Editar el archivo .env para configurar la conexión a la base de datos. Para SQLite, se puede crear un archivo vacío y especificar su ruta:  
        DB_CONNECTION=sqlite  
        DB_DATABASE=/ruta/absoluta/a/tu/proyecto/database/database.sqlite  

1. **Migración de la Base de Datos:** Crear la estructura de la base de datos y poblarla con los datos de prueba definidos en los seeders:  
    Bash  
    \# Si se usa SQLite, crear primero el archivo  
    touch database/database.sqlite  
    \# Ejecutar migraciones y seeders  
    php artisan migrate --seed  

2. **Servir la Aplicación:** Iniciar el servidor de desarrollo local de Laravel:  
    Bash  
    php artisan serve  
    <br/>La aplicación estará disponible, por defecto, en <http://127.0.0.1:8000>.<sup>10</sup>

## Parte II: Pruebas de Interfaz de Usuario (UI Testing)

### Sección 3: Automatización Exploratoria con Selenium IDE

Antes de escribir código de automatización, es fundamental comprender el flujo de usuario y los elementos con los que se interactúa. Selenium IDE es una herramienta de "grabación y reproducción" que sirve como un excelente punto de partida. Su valor pedagógico radica en su capacidad para desmitificar la automatización, traduciendo visualmente las acciones humanas en una secuencia de comandos ejecutables. Esto proporciona un andamiaje conceptual indispensable antes de abordar la abstracción del código.

#### Instalación

Selenium IDE es una extensión de navegador disponible para los navegadores más populares.

- **Para Google Chrome:** Instalar desde la Chrome Web Store.
- Para Mozilla Firefox: Instalar desde Firefox Browser ADD-ONS.  
    <br/><sup>12</sup>

#### Grabación de un Flujo de Usuario

1. **Iniciar un Nuevo Proyecto:** Abrir Selenium IDE desde la barra de extensiones del navegador. Seleccionar "Record a new test in a new project". Asignar un nombre al proyecto (ej. "TaskMaster Tests") y establecer la URL base de la aplicación Laravel en ejecución (ej. <http://127.0.0.1:8000>).<sup>13</sup>
2. **Grabar el Proceso:** Selenium IDE abrirá una nueva ventana del navegador en la URL base y comenzará a grabar. Realizar las siguientes acciones:
    - Navegar a la página del formulario de creación de tareas (ej. /tasks/create).
    - Hacer clic en el campo "Title" e introducir un texto como "Revisar informe de laboratorio".
    - Hacer clic en el campo "Description" e introducir "Detallar los resultados de las pruebas de rendimiento".
    - Seleccionar un proyecto del menú desplegable.
    - Hacer clic en el botón "Guardar Tarea".
3. **Detener la Grabación:** Volver a la ventana de Selenium IDE y hacer clic en el botón rojo de "Stop recording". Se observará una lista de comandos que representan cada acción realizada.<sup>13</sup>

#### Añadir Aserciones (Validaciones)

Una prueba no está completa sin una verificación. Después de crear la tarea, se debe asegurar que esta aparece en la página principal.

1. En la ventana del navegador, navegar a la página principal de tareas (/tasks).
2. Volver a Selenium IDE. Hacer clic derecho en el último paso de la prueba grabada y seleccionar "Insert new command".
3. En el nuevo comando, establecer:
    - **Command:** assert text
    - **Target:** Un selector que apunte al lugar donde se listan las tareas (ej. css=table).
    - Value: Revisar informe de laboratorio.  
        Este comando le indica a Selenium que verifique que el texto "Revisar informe de laboratorio" existe dentro de la tabla de la página, confirmando que la creación fue exitosa.13

#### Guardar y Reproducir

1. **Guardar el Proyecto:** Hacer clic en el icono de guardar (disquete) en la esquina superior derecha de Selenium IDE. Guardar el proyecto como un archivo .side.<sup>13</sup>
2. **Reproducir la Prueba:** Con la prueba seleccionada en el panel izquierdo, hacer clic en el botón "Run current test" (icono de play). Selenium IDE ejecutará automáticamente todos los pasos grabados, incluyendo la aserción, y marcará cada paso en verde si tiene éxito o en rojo si falla.<sup>13</sup>

### Sección 4: Integración de Pruebas de Navegador con Laravel Dusk

Si bien Selenium IDE es excelente para la exploración, sus pruebas pueden ser frágiles y difíciles de mantener. Laravel Dusk ofrece una API de automatización de navegador robusta, expresiva y escrita en PHP, que se integra perfectamente con el resto de la aplicación. La transición de Selenium IDE a Dusk representa un paso crucial: pasar de una automatización basada en la implementación (selectores específicos que pueden cambiar) a una automatización basada en el comportamiento (acciones que un usuario realizaría, como presionar un botón con un texto específico). Este enfoque hace que las pruebas sean mucho más resistentes a los cambios en la interfaz de usuario y, por lo tanto, más valiosas a largo plazo.

#### Introducción a Laravel Dusk

Laravel Dusk es un paquete oficial que proporciona una API fluida para la automatización y pruebas de navegador. Por defecto, utiliza una instalación independiente de ChromeDriver, lo que elimina la necesidad de instalar un entorno Java (JDK) o un servidor Selenium completo, simplificando enormemente la configuración.<sup>17</sup>

#### Instalación y Configuración

1. **Requerir el Paquete:** Añadir Dusk como una dependencia de desarrollo a través de Composer:  
    Bash  
    composer require --dev laravel/dusk  
    <br/><sup>20</sup>
2. **Instalar Dusk:** Ejecutar el comando de Artisan para instalar los archivos y directorios necesarios:  
    Bash  
    php artisan dusk:install  
    <br/>Este comando creará un directorio tests/Browser con un test de ejemplo.<sup>17</sup>
3. **Configurar el Entorno:** Es fundamental que la variable APP_URL en el archivo .env coincida con la URL del servidor de desarrollo (ej. <http://127.0.0.1:8000>). Para configuraciones específicas de Dusk, se puede crear un archivo .env.dusk.local, que será utilizado automáticamente al ejecutar las pruebas de Dusk.<sup>17</sup>

#### Traducción del Script de Selenium IDE a Dusk

El siguiente paso es codificar el flujo de usuario grabado previamente en una prueba de Dusk.

1. **Generar el Archivo de Prueba:** Crear un nuevo archivo de prueba de Dusk:  
    Bash  
    php artisan dusk:make CreateTaskTest  
    <br/><sup>17</sup>
2. **Escribir la Prueba:** Abrir el archivo tests/Browser/CreateTaskTest.php y modificar el método de prueba para replicar el flujo. La sintaxis de Dusk es altamente legible y encadenable:  
    PHP  
    <?php  
    <br/>namespace Tests\\Browser;  
    <br/>use Illuminate\\Foundation\\Testing\\DatabaseMigrations;  
    use Laravel\\Dusk\\Browser;  
    use Tests\\DuskTestCase;  
    use App\\Models\\Project;  
    <br/>class CreateTaskTest extends DuskTestCase  
    {  
    use DatabaseMigrations; // Reinicia la base de datos para cada prueba  
    <br/>/\*\*  
    \* A Dusk test to create a new task.  
    \*  
    \* @return void  
    \*/  
    public function test_user_can_create_a_new_task(): void  
    {  
    // Crear un proyecto de prueba para poder asignarlo a la tarea  
    $project = Project::factory()->create();  
    <br/>$this->browse(function (Browser $browser) use ($project) {  
    $browser->visit('/tasks/create')  
    \->type('title', 'Nueva Tarea desde Dusk') // Rellenar el campo 'title'  
    \->type('description', 'Descripción detallada de la tarea.') // Rellenar 'description'  
    \->select('project_id', $project->id) // Seleccionar el proyecto  
    \->press('Guardar Tarea') // Hacer clic en el botón con el texto 'Guardar Tarea'  
    \->assertPathIs('/tasks') // Verificar que se ha redirigido a la lista de tareas  
    \->assertSee('Nueva Tarea desde Dusk'); // Verificar que el título de la nueva tarea es visible  
    });  
    }  
    }  
    <br/><sup>18</sup>

#### Ejecución de Pruebas Dusk

Para ejecutar todas las pruebas de Dusk, se utiliza el siguiente comando de Artisan:

Bash

php artisan dusk  

<sup>17</sup>

Es importante gestionar el estado de la base de datos durante las pruebas de Dusk. El trait RefreshDatabase no funciona con Dusk porque las transacciones de base de datos que utiliza no persisten a través de las múltiples peticiones HTTP que realiza una prueba de navegador. En su lugar, se deben utilizar traits como DatabaseMigrations (que ejecuta las migraciones antes de cada prueba) o DatabaseTruncation (que trunca las tablas) para asegurar un estado limpio de la base de datos en cada ejecución.<sup>21</sup>

## Parte III: Pruebas de Rendimiento de la API REST

### Sección 5: Introducción a las Pruebas de Carga con k6

Las pruebas funcionales y de interfaz de usuario verifican que la aplicación se comporta correctamente, es decir, que "hace lo que se supone que debe hacer". Sin embargo, esto no es suficiente para garantizar una experiencia de usuario de calidad en el mundo real. Las pruebas de rendimiento amplían la definición de calidad para incluir aspectos no funcionales cruciales como la **velocidad, la escalabilidad y la fiabilidad**. Responden a la pregunta: "¿Puede la aplicación hacer lo que se supone que debe hacer de manera eficiente y bajo una carga de usuarios realista?".<sup>23</sup> La introducción de estas pruebas enseña a los estudiantes a adoptar una visión holística de la calidad del software.

#### Presentación de k6

k6 es una herramienta de pruebas de carga moderna, de código abierto y orientada a desarrolladores, mantenida por Grafana Labs. Se destaca por su facilidad de uso, su alto rendimiento y el uso de JavaScript (ES2015/ES6) para la escritura de scripts, lo que la hace accesible para desarrolladores web.<sup>23</sup>

#### Instalación

k6 se puede instalar fácilmente en los principales sistemas operativos.

- **Linux (Debian/Ubuntu):**  
    Bash  
    sudo gpg -k  
    sudo gpg --no-default-keyring --keyring /usr/share/keyrings/k6-archive-keyring.gpg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C5AD17C747E3415A3642D57D77C6C491D6AC1D69  
    echo "deb \[signed-by=/usr/share/keyrings/k6-archive-keyring.gpg\] <https://dl.k6.io/deb> stable main" | sudo tee /etc/apt/sources.list.d/k6.list  
    sudo apt-get update  
    sudo apt-get install k6  

- **Linux (Fedora/CentOS):**  
    Bash  
    sudo dnf install <https://dl.k6.io/rpm/repo.rpm>  
    sudo dnf install k6  

- **macOS (vía Homebrew):**  
    Bash  
    brew install k6  

- **Windows (vía Chocolatey o Winget):**  
    Bash  
    \# Usando Chocolatey  
    choco install k6  
    \# Usando Windows Package Manager  
    winget install k6 --source winget  

<sup>27</sup>

### Sección 6: Diseño y Ejecución de Escenarios de Carga

Una prueba de carga efectiva no consiste simplemente en enviar un gran número de peticiones simultáneas. Requiere un diseño cuidadoso que simule patrones de uso realistas para identificar cómo y cuándo el rendimiento del sistema se degrada.

#### Anatomía de un Script de k6

Un script de k6 tiene tres componentes principales:

1. **import:** Se importan los módulos necesarios de la biblioteca de k6, como http para realizar peticiones, check para las aserciones y sleep para introducir pausas.<sup>26</sup>
2. **export const options:** Un objeto JavaScript que define la configuración de la prueba. Aquí se especifican los usuarios virtuales (vus), la duración (duration) o, para escenarios más complejos, las etapas (stages) de la prueba.<sup>27</sup>
3. **export default function ():** El cuerpo principal de la prueba. El código dentro de esta función es ejecutado repetidamente por cada usuario virtual durante la prueba.<sup>30</sup>

#### Creación del Script de Prueba de API

Se creará un script llamado api-load-test.js para probar la API de TaskMaster.

1. **Peticiones GET y POST:** El script realizará dos acciones: obtener la lista de tareas y crear una nueva tarea. La petición POST incluirá las cabeceras adecuadas y un cuerpo (payload) en formato JSON.<sup>31</sup>
2. **Validaciones (checks):** Después de cada petición, se usarán checks para verificar que la respuesta del servidor es la esperada (código de estado 200 para GET y 201 para POST). Los checks son similares a las aserciones pero no detienen la ejecución de la prueba si fallan, lo que permite recopilar estadísticas completas.<sup>24</sup>
3. **Configuración de Carga (stages):** En lugar de una carga constante, se definirá un escenario con etapas para simular un pico de tráfico. Este enfoque es fundamental porque permite observar cómo se comporta el sistema al aumentar la carga, bajo estrés y durante la recuperación. Permite identificar el punto exacto en el que el rendimiento se degrada (el "cuello de botella"), una información mucho más valiosa que un simple resultado de "pasa/falla".
    - **Ramp-up:** Aumento gradual de usuarios para ver cómo el sistema escala.
    - **Sustained Load:** Mantenimiento de la carga máxima para probar la estabilidad bajo estrés.
    - **Ramp-down:** Reducción gradual para verificar si el sistema se recupera correctamente.<sup>24</sup>

#### Ejemplo de Script Completo

JavaScript

import http from 'k6/http';  
import { check, sleep } from 'k6';  
<br/>// 1. Configuración de la prueba con etapas  
export const options = {  
stages:,  
thresholds: {  
http_req_failed: \['rate<0.01'\], // La tasa de errores debe ser menor al 1%  
http_req_duration: \['p(95)<500'\], // El 95% de las peticiones deben completarse en menos de 500ms  
},  
};  
<br/>const BASE_URL = '<http://127.0.0.1:8000/api>';  
<br/>// 2. Función principal de la prueba  
export default function () {  
// --- Petición GET para obtener todas las tareas ---  
let getRes = http.get(\`${BASE_URL}/tasks\`);  
<br/>check(getRes, {  
'GET /tasks status is 200': (r) => r.status === 200,  
});  
<br/>sleep(1); // Pausa de 1 segundo  
<br/>// --- Petición POST para crear una nueva tarea ---  
const headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };  
const payload = JSON.stringify({  
title: \`Nueva Tarea k6 - ${\__VU}-${\__ITER}\`, // Título único por VU e iteración  
description: 'Tarea creada durante la prueba de carga.',  
project_id: 1, // Asumimos que el proyecto con ID 1 existe  
});  
<br/>let postRes = http.post(\`${BASE_URL}/tasks\`, payload, { headers: headers });  
<br/>check(postRes, {  
'POST /tasks status is 201': (r) => r.status === 201,  
});  
<br/>sleep(1); // Pausa de 1 segundo  
}  

<sup>32</sup>

#### Ejecución de la Prueba de Carga

Para ejecutar el script, se utiliza el siguiente comando en la terminal, desde el directorio donde se guardó el archivo:

Bash

k6 run api-load-test.js  

<sup>28</sup>

k6 mostrará en tiempo real las métricas de la prueba y, al finalizar, presentará un resumen detallado del rendimiento.

## Parte IV: Análisis de Resultados y Conceptos Avanzados

### Sección 7: Generación e Interpretación de Informes de Pruebas

La ejecución de pruebas automatizadas genera una gran cantidad de datos. El verdadero valor de estas pruebas se materializa en la capacidad de analizar estos datos para obtener conclusiones accionables sobre la calidad del software.

#### Subsección 7.1: Informes de Pruebas Funcionales y Cobertura de Código

##### Concepto de Cobertura de Código

La cobertura de código es una métrica que mide el porcentaje del código fuente de una aplicación que ha sido ejecutado durante la ejecución de la suite de pruebas.<sup>33</sup> Es una herramienta de diagnóstico crucial: aunque un 100% de cobertura no garantiza la ausencia de errores, una baja cobertura es una señal inequívoca de que existen partes del código que no han sido verificadas en absoluto, representando un riesgo potencial.<sup>34</sup>

##### Generación de Informes

Para generar un informe de cobertura, es necesario tener instalada una extensión de PHP como Xdebug o PCOV.<sup>34</sup> Una vez configurado, se puede generar un informe en formato HTML, que es muy visual e interactivo, añadiendo un flag al comando de ejecución de pruebas:

Bash

\# Con Xdebug 3, es necesario establecer la variable de entorno  
XDEBUG_MODE=coverage php artisan test --coverage-html reports/coverage  

<sup>34</sup>

Este comando ejecutará las pruebas y creará un directorio reports/coverage con el informe HTML.

##### Interpretación del Informe HTML

Al abrir el archivo index.html del informe, se presenta un resumen de la cobertura por directorios y archivos. Al navegar a un archivo específico, se puede ver el código fuente con cada línea coloreada:

- **Verde:** La línea fue ejecutada por al menos una prueba.
- **Rojo:** La línea no fue ejecutada por ninguna prueba.
- **Amarillo/Naranja:** Indica código que es imposible de cubrir (ej. else en un if que siempre es verdadero).

| Métrica | Descripción | ¿Qué Indica un Buen Valor? | ¿Qué Indica un Mal Valor? |
| --- | --- | --- | --- |
| **Cobertura de Líneas** | Porcentaje de líneas de código ejecutables que fueron ejecutadas. | Un alto porcentaje (ej. > 80%) sugiere que la mayoría de la lógica ha sido probada. | Un bajo porcentaje indica grandes áreas de código sin probar, con alto riesgo de errores ocultos. |
| --- | --- | --- | --- |
| **Cobertura de Métodos** | Porcentaje de métodos/funciones que fueron invocados. | Todos los métodos públicos importantes están siendo llamados por las pruebas. | Hay métodos que ninguna prueba está utilizando, lo que podría indicar código muerto o funcionalidades no probadas. |
| --- | --- | --- | --- |
| **Cobertura de Clases** | Porcentaje de clases que fueron instanciadas o utilizadas. | Las clases principales del dominio de la aplicación están cubiertas por las pruebas. | Hay clases enteras que no se están probando, lo que representa un punto ciego significativo en la calidad. |
| --- | --- | --- | --- |

#### Subsección 7.2: Informes de Rendimiento de k6

##### Análisis de la Salida de la Consola

Al finalizar una ejecución, k6 presenta un resumen en la consola con métricas clave. Es vital saber interpretar estos números.<sup>27</sup>

##### Generación de Informes HTML

Aunque la salida de la consola es útil, un informe HTML es más fácil de compartir y analizar. La comunidad de k6 ha desarrollado herramientas para esto. Una de las más populares es k6-reporter. Para utilizarla, se debe modificar el script de k6 para incluir una función handleSummary que procesa los datos al final de la prueba y genera el archivo HTML.<sup>37</sup>

JavaScript

// Añadir esta importación al inicio del script de k6  
import { htmlReport } from "<https://raw.githubusercontent.com/benc-uk/k6-reporter/main/dist/bundle.js>";  
<br/>// Añadir esta función al final del script de k6  
export function handleSummary(data) {  
return {  
"summary-report.html": htmlReport(data),  
};  
}  

<sup>37</sup>

Al ejecutar la prueba de nuevo, k6 creará un archivo summary-report.html con los resultados visualizados.

| Métrica de k6 | Descripción | ¿Qué Pregunta Responde? |
| --- | --- | --- |
| **http_req_duration { p(95) }** | El percentil 95 del tiempo de duración de las peticiones HTTP. | ¿Cuál es el tiempo de respuesta en el peor de los casos para el 95% de los usuarios? |
| --- | --- | --- |
| **http_req_failed** | La tasa de peticiones que resultaron en un error (ej. timeout, status > 399). | ¿Qué tan fiable es la API bajo carga? ¿Cuántas peticiones están fallando? |
| --- | --- | --- |
| **iterations** | El número total de veces que la función default fue ejecutada. | ¿Cuántas transacciones completas pudo procesar el sistema durante la prueba? |
| --- | --- | --- |
| **vus** | El número de usuarios virtuales activos. | ¿Cuántos usuarios concurrentes estaban simulando la prueba en un momento dado? |
| --- | --- | --- |
| **checks** | La tasa de éxito de las validaciones (check) definidas en el script. | ¿La API está devolviendo las respuestas correctas incluso bajo carga? |
| --- | --- | --- |

#### Subsección 7.3: Hacia un Informe Consolidado: El Arte de la Síntesis

No existe una herramienta estándar que combine automáticamente un informe de cobertura de PHPUnit con un informe de rendimiento de k6. La generación de un "informe consolidado" es, en esencia, un ejercicio de **síntesis analítica**. La habilidad que se debe desarrollar es la de interpretar los resultados de diferentes tipos de pruebas y combinarlos en una narrativa coherente sobre la calidad del software.

Un informe de calidad efectivo podría resumir los hallazgos de la siguiente manera:

"La suite de pruebas funcionales para la API de 'TaskMaster' presenta una cobertura de código del 87%, con todos los tests pasando exitosamente. Esto indica una alta confianza en la corrección funcional de las operaciones CRUD. Sin embargo, las pruebas de rendimiento ejecutadas con k6 revelan un posible cuello de botella. La métrica http_req_duration (p95) se mantiene por debajo de los 200 ms con hasta 40 usuarios virtuales concurrentes, pero se degrada rápidamente a más de 800 ms al superar los 45 usuarios. Esto sugiere que, aunque la lógica es correcta, la implementación actual podría no escalar eficientemente, recomendándose una revisión de las consultas a la base de datos en el endpoint POST /api/tasks."

<sup>38</sup>

### Sección 8: Integración Continua (CI/CD) - Automatizando la Automatización

El verdadero poder de las pruebas automatizadas se desbloquea cuando se integran en el flujo de trabajo de desarrollo. La Integración Continua (CI) es la práctica de automatizar la ejecución de la suite de pruebas cada vez que un desarrollador integra un cambio de código en el repositorio principal. Esto transforma las pruebas de una tarea manual y esporádica en una red de seguridad activa y constante. Esta automatización es el prerrequisito para una CI/CD efectiva; sin pruebas fiables, la "integración continua" se convierte en "integración continua de errores".

#### GitHub Actions como Herramienta de CI

GitHub Actions es un sistema de CI/CD integrado en GitHub que permite automatizar flujos de trabajo directamente desde el repositorio. Estos flujos se definen en archivos YAML ubicados en el directorio .github/workflows.

#### Creación de un Flujo de Trabajo para Laravel

El siguiente es un ejemplo de un flujo de trabajo para una aplicación Laravel que se activa en cada push, instala las dependencias y ejecuta la suite de pruebas de PHPUnit, incluyendo la generación de cobertura.

**Archivo: .github/workflows/laravel-tests.yml**

YAML

name: Laravel Tests  
<br/>on: \[push\]  
<br/>jobs:  
build:  
name: Run PHPUnit Tests  
runs-on: ubuntu-latest  
<br/>steps:  
\- name: Checkout code  
uses: actions/checkout@v3  
<br/>\- name: Setup PHP  
uses: shivammathur/setup-php@v2  
with:  
php-version: '8.2' # Asegurarse de que coincida con la versión del proyecto  
extensions: mbstring, xml, sqlite, pdo_sqlite # Extensiones necesarias  
coverage: xdebug # O pcov, para la cobertura de código  
<br/>\- name: Copy.env  
run: php -r "file_exists('.env') |  
<br/>| copy('.env.example', '.env');"  
<br/>\- name: Install Composer Dependencies  
run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist  
<br/>\- name: Generate application key  
run: php artisan key:generate  
<br/>\- name: Create Database  
run: |  
mkdir -p database  
touch database/database.sqlite  
<br/>\- name: Run Migrations  
run: php artisan migrate  
<br/>\- name: Execute tests (with coverage)  
env:  
XDEBUG_MODE: coverage  
run:./vendor/bin/phpunit --coverage-text  
<br/>

<sup>40</sup>

Este flujo de trabajo codifica la política de calidad del equipo. Asegura que cada cambio propuesto sea validado automáticamente, detectando regresiones de manera inmediata y proporcionando una retroalimentación rápida y constante que es esencial para el desarrollo de software moderno y ágil.

### Conclusión

Este laboratorio guía a los estudiantes a través de un viaje completo por el espectro del testing de software moderno en el contexto de Laravel. Partiendo de los fundamentos teóricos, como la distinción estratégica entre pruebas unitarias y de características, se avanza hacia la aplicación práctica de herramientas clave.

El recorrido comienza con la automatización de la interfaz de usuario, donde se demuestra la transición desde una herramienta exploratoria y visual como **Selenium IDE** hacia una solución robusta y mantenible integrada en el framework con **Laravel Dusk**. Este paso enseña el principio fundamental de probar el comportamiento del usuario en lugar de los detalles de implementación.

Posteriormente, el enfoque se expande más allá de la corrección funcional para abarcar el rendimiento y la fiabilidad con **k6**. Los estudiantes aprenden a diseñar y ejecutar pruebas de carga que simulan condiciones del mundo real, identificando cuellos de botella y asegurando que la aplicación no solo funcione, sino que funcione bien bajo estrés.

Finalmente, el ciclo se cierra con la generación de informes y la **Integración Continua**. Se enseña a los estudiantes a interpretar métricas de calidad como la cobertura de código y los percentiles de tiempo de respuesta, y a sintetizar estos datos en un análisis coherente. La integración con **GitHub Actions** demuestra cómo estas prácticas se convierten en una red de seguridad automatizada, garantizando que la calidad sea una parte integral y constante del ciclo de vida del desarrollo de software. Al completar este laboratorio, los estudiantes no solo habrán aprendido a usar un conjunto de herramientas, sino que habrán internalizado una metodología de testing moderna y holística, esencial para la ingeniería de software profesional.

#### Obras citadas

1. Testing: Getting Started - Laravel 7.x - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/7.x/testing>
2. Testing: Getting Started - Laravel 12.x - The PHP Framework For ..., fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/12.x/testing>
3. ¿Qué son las pruebas unitarias? - AWS, fecha de acceso: agosto 25, 2025, <https://aws.amazon.com/es/what-is/unit-testing/>
4. 9 testing best practices for Laravel in 2025 - Benjamin Crozat, fecha de acceso: agosto 25, 2025, <https://benjamincrozat.com/laravel-testing-best-practices>
5. Unit, Integration or Feature Test? - laravel - Stack Overflow, fecha de acceso: agosto 25, 2025, <https://stackoverflow.com/questions/55636697/unit-integration-or-feature-test>
6. Feature Testing in Laravel — Beginner's Guide | by Zubair Idris Aweda | Medium, fecha de acceso: agosto 25, 2025, <https://zubairidrisaweda.medium.com/feature-testing-in-laravel-beginners-guide-d2cb4498acee>
7. Database Testing - Laravel 12.x - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/12.x/database-testing>
8. HTTP Tests - Laravel 12.x - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/12.x/http-tests>
9. Installation - Laravel 12.x - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/12.x/installation>
10. Cómo instalar proyectos existentes de Laravel - Styde.net, fecha de acceso: agosto 25, 2025, <https://styde.net/como-instalar-proyectos-existentes-de-laravel/>
11. Selenium IDE, fecha de acceso: agosto 25, 2025, <https://www.selenium.dev/documentation/ide/>
12. Pruebas en el navegador con Selenium IDE. Testing - Eniun, fecha de acceso: agosto 25, 2025, <https://www.eniun.com/pruebas-navegador-selenium-ide-testing-web/>
13. Selenium IDE – Get this Extension for Firefox (en-US), fecha de acceso: agosto 25, 2025, <https://addons.mozilla.org/en-US/firefox/addon/selenium-ide/>
14. Selenium IDE · Open source record and playback test automation for the web, fecha de acceso: agosto 25, 2025, <https://www.selenium.dev/selenium-ide/>
15. Install Selenium IDE in Chrome, Firefox, Edge Chromium and Record, Play, Save, Import script - YouTube, fecha de acceso: agosto 25, 2025, <https://www.youtube.com/watch?v=GYXJXAWBjc4>
16. Laravel Dusk - Laravel 5.7 - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/5.7/dusk>
17. Browser Tests (Laravel Dusk) - Laravel 5.5 - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/5.5/dusk>
18. laravel/dusk - Packagist, fecha de acceso: agosto 25, 2025, <https://packagist.org/packages/laravel/dusk>
19. Laravel Dusk: Automate Your Web Application Testing | by Mohammad Roshandelpoor, fecha de acceso: agosto 25, 2025, <https://medium.com/@mohammad.roshandelpoor/laravel-dusk-automate-your-web-application-testing-7dbfe86a1476>
20. Laravel Dusk - Laravel 12.x - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/12.x/dusk>
21. Browser Tests (Laravel Dusk) - Laravel 5.4 - The PHP Framework For Web Artisans, fecha de acceso: agosto 25, 2025, <https://laravel.com/docs/5.4/dusk>
22. las 10 mejores plataformas de pruebas de carga de API para mejorar el rendimiento, fecha de acceso: agosto 25, 2025, <https://geekflare.com/es/api-load-testing-platforms/>
23. API Performance Testing with k6 - A Quick Start Guide - DEV Community, fecha de acceso: agosto 25, 2025, <https://dev.to/nadirbasalamah/api-performance-testing-with-k6-a-quick-start-guide-2ngc>
24. Selenium Automation Testing With Laravel Dusk Framework - LambdaTest, fecha de acceso: agosto 25, 2025, <https://www.lambdatest.com/selenium-automation-testing-with-laravel-dusk-framework>
25. Grafana k6: Load testing for engineering teams, fecha de acceso: agosto 25, 2025, <https://k6.io/>
26. How to Execute Load Tests Using the k6 Framework - Baeldung, fecha de acceso: agosto 25, 2025, <https://www.baeldung.com/k6-framework-load-testing>
27. Step-by-Step Guide to Load Testing with k6 | by Ravi Patel | Medium, fecha de acceso: agosto 25, 2025, <https://medium.com/@ravipatel.it/step-by-step-guide-to-load-testing-with-k6-5afb625e231a>
28. Install k6 | Grafana k6 documentation, fecha de acceso: agosto 25, 2025, <https://grafana.com/docs/k6/latest/set-up/install-k6/>
29. Get Started with k6 for Load Testing - Ultimate QA, fecha de acceso: agosto 25, 2025, <https://ultimateqa.com/k6-for-load-testing/>
30. API load testing using k6 - Binod Mahto - Medium, fecha de acceso: agosto 25, 2025, <https://binodmahto.medium.com/api-load-testing-using-k6-91cd475a68a7>
31. APIs load testing using K6. We will go through the load testing… | by ..., fecha de acceso: agosto 25, 2025, <https://aymalla.medium.com/apis-load-testing-using-k6-4498be4089e6>
32. medium.com, fecha de acceso: agosto 25, 2025, <https://medium.com/devopslatam/todo-lo-que-necesita-saber-sobre-la-cobertura-del-c%C3%B3digo-e7216ae1d255#:~:text=La%20cobertura%20de%20c%C3%B3digo%20es,exhaustivamente%20se%20verifica%20un%20software>.
33. Determining Code Coverage With PHPUnit | PHP Architect, fecha de acceso: agosto 25, 2025, <https://www.phparch.com/2023/03/determining-code-coverage-with-phpunit/>
34. Test Coverage | Pest - The elegant PHP Testing Framework, fecha de acceso: agosto 25, 2025, <https://pestphp.com/docs/test-coverage>
35. Generate Code Coverage Report in Laravel and make it 100% score easily - Medium, fecha de acceso: agosto 25, 2025, <https://medium.com/@anowarhossain/code-coverage-report-in-laravel-and-make-100-coverage-of-your-code-ce27cccbc738>
36. benc-uk/k6-reporter: Output K6 test run results as formatted ... - GitHub, fecha de acceso: agosto 25, 2025, <https://github.com/benc-uk/k6-reporter>
37. Revisar los resultados de la prueba - Azure Pipelines | Microsoft Learn, fecha de acceso: agosto 25, 2025, <https://learn.microsoft.com/es-es/azure/devops/pipelines/test/review-continuous-test-results-after-build?view=azure-devops>
38. Informes de prueba para la integración de Engineering Test Management - IBM, fecha de acceso: agosto 25, 2025, <https://www.ibm.com/docs/es/engineering-lifecycle-management-suite/doors/9.7.2?topic=management-test-reports-engineering-test-integration>
39. A simple Laravel testing workflow for GitHub Actions · GitHub, fecha de acceso: agosto 25, 2025, <https://gist.github.com/rubenvanassche/4fa2a9ab58454e77ba8a457941ffc0c5>
40. Github actions for Laravel dusk - GitHub Gist, fecha de acceso: agosto 25, 2025, <https://gist.github.com/zaratedev/e385c948d0344fc69c5ecc275df9d34a>