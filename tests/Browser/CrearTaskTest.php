<?php

namespace Tests\Browser;

use App\Models\Project;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CrearTaskTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Prueba de creación de tarea desde la UI (traducción de Selenium IDE)
     */
    public function test_crear_tarea()
    {
        // Creamos el proyecto si no existe (idempotente)
        $project = Project::firstOrCreate(
            ['name' => 'Gusikowski-Marks'],
            ['description' => 'Proyecto de prueba para Dusk']
        );

        $this->browse(function (Browser $browser) use ($project) {
            $browser->visit('/tasks')
                ->waitForLink('Crear Nueva Tarea')
                ->clickLink('Crear Nueva Tarea')
                ->waitFor('#title')
                ->click('#title')
                ->type('title', 'Test tarea')
                ->click('#description')
                ->type('description', 'test')
                ->click('#project_id')
                ->select('project_id', $project->id)
                ->pause(300) // Espera breve para simular el click en el dropdown
                ->screenshot('crear_tarea_formulario')
                ->press('.btn') // Usar el selector CSS como en Selenium
                ->screenshot('crear_tarea')
                ->assertPathIs('/tasks')
                ->assertSee('Test tarea');
        });
    }
}
