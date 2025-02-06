@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Görevlerim</span>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">Yeni Görev</a>
                </div>

                <div class="card-body">
                    @foreach($tasks as $task)
                        <div class="task-item d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="{{ $task->status === 'completed' ? 'text-muted text-decoration-line-through' : '' }}">
                                    {{ $task->title }}
                                </h5>
                                <p class="mb-0">{{ $task->description }}</p>
                            </div>
                            <div class="btn-group">
                                <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        {{ $task->status === 'pending' ? 'Tamamla' : 'Geri Al' }}
                                    </button>
                                </form>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Düzenle</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Emin misiniz?')">Sil</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 