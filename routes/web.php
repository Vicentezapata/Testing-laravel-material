
<?php

use Illuminate\Support\Facades\Route;


// Ruta raíz para facilitar el testeo manual
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Rutas principales de la interfaz web
use App\Http\Controllers\WebTaskController;
Route::get('/tasks', [WebTaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [WebTaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [WebTaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [WebTaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [WebTaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [WebTaskController::class, 'destroy'])->name('tasks.destroy');
// Ruta para obtener todas las tareas en formato JSON (para pruebas backend)
Route::get('/tasks-json', [WebTaskController::class, 'jsonIndex'])->name('tasks.json');