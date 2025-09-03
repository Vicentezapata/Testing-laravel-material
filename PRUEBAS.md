# Instalación de Dusk y k6

## Laravel Dusk

1. Instala Dusk como dependencia de desarrollo:
  ```bash
  composer require --dev laravel/dusk
  ```
2. Instala el scaffolding de Dusk:
  ```bash
  php artisan dusk:install
  ```
3. (Opcional) Si tienes problemas con ChromeDriver, descárgalo manualmente y colócalo en `vendor/laravel/dusk/bin/`.

## k6

En Windows, puedes instalarlo con uno de estos comandos:

- Usando Chocolatey:
  ```bash
  choco install k6
  ```
- Usando Winget:
  ```bash
  winget install k6
  ```

# Requerimientos Generales

Antes de ejecutar cualquier prueba, asegúrate de tener:

- **PHP >= 8.2**
- **Composer** (para dependencias de Laravel)
- **Node.js y npm** (solo si quieres reporte HTML de k6)
- **k6 instalado** (`choco install k6` o `winget install k6` en Windows)
- **Google Chrome instalado** (para Dusk)
- **Dependencias del proyecto instaladas:**
  ```bash
  composer install
  ```
- **Servidor de Laravel corriendo** (para Dusk y k6):
  ```bash
  php artisan serve
  ```

# Guía Paso a Paso: Pruebas Automatizadas en Laravel (PHPUnit, Dusk y k6)

## 1. Pruebas de Backend con PHPUnit

### a) Ejecutar pruebas y exportar reporte
```bash
php artisan test --log-junit reports/phpunit-report.xml
```
- Esto ejecuta todos los tests y genera un reporte en formato XML en `reports/phpunit-report.xml`.

### b) Interpretar resultados
- El archivo XML puede abrirse en herramientas de CI/CD o editores compatibles para ver el detalle de cada test.

---

## 2. Pruebas de Interfaz con Laravel Dusk

### a) Ejecutar pruebas y exportar reporte
```bash
php artisan dusk --log-junit reports/dusk-report.xml
```
- Esto ejecuta los tests de navegador y genera un reporte XML en `reports/dusk-report.xml`.
- Si quieres ver el navegador en acción, asegúrate de que Dusk esté configurado en modo visible (no headless).

### b) Interpretar resultados
- El XML puede abrirse en herramientas de CI/CD o editores compatibles.
- Las capturas de pantalla de fallos se guardan en `tests/Browser/screenshots/`.

---

## 3. Pruebas de Rendimiento con k6

### a) Crear el script de prueba
Ejemplo: `api-tasks-json-load-test.js`
```js
import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 20,
  duration: '15s',
};

export default function () {
  const res = http.get('http://testing-laravel-material.test/tasks-json');
  check(res, {
    'status is 200': (r) => r.status === 200,
    'response is array': (r) => Array.isArray(r.json()),
  });
  sleep(1);
}
```

### b) Ejecutar la prueba y exportar resultados
```bash
k6 run C:\laragon\www\Testing-laravel-material\api-tasks-json-load-test.js --out json=C:\laragon\www\Testing-laravel-material\reports/k6-report.json
```
- Esto ejecuta la prueba de carga y guarda los resultados en `reports/k6-report.json`.

### c) (Opcional) Generar reporte HTML con k6-reporter
1. Instala k6-reporter:
   ```bash
   npm install -g k6-reporter
   ```
2. Genera el HTML:
   ```bash
   k6-reporter reports/k6-report.json
   ```
   Esto crea `reports/k6-report.html`.

---

## 4. Consejos Generales
- Asegúrate de tener las rutas y datos de prueba necesarios antes de ejecutar los tests.
- Usa bases de datos separadas para pruebas automatizadas.
- Los reportes generados pueden ser compartidos o subidos a plataformas de CI/CD para análisis automático.

---

**¡Listo! Así tus alumnos podrán ejecutar, exportar y analizar pruebas automatizadas de backend, frontend y rendimiento en Laravel.**
