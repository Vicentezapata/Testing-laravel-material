@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Tarea</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="project_id" class="form-label">Proyecto</label>
            <select class="form-control" id="project_id" name="project_id" required>
                <option value="">Seleccione un proyecto</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar Tarea</button>
    </form>
</div>
@endsection
