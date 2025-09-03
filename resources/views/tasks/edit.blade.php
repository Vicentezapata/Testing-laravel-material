@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Tarea</h1>
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description', $task->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="project_id" class="form-label">Proyecto</label>
            <select class="form-control" id="project_id" name="project_id" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @if($project->id == old('project_id', $task->project_id)) selected @endif>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
