@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Tareas</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Crear Nueva Tarea</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha Límite</th>
                <th>Proyecto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->project->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta tarea?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
