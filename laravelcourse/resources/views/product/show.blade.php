
@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')

<div class="card mb-4">
    <div class="row g-0">
        <div class="col-md-4">
            <img
                src="https://laravel.com/img/logotype.min.svg"
                class="img-fluid rounded-start"
                alt="Laravel"
            >
        </div>

        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $viewData["product"]["name"] }}
                </h5>

                <p class="card-text">
                    Precio: {{ $viewData["product"]["price"] }}
                </p>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="card mb-4">
    <div class="card-header">
        Comentarios
    </div>

    <div class="card-body">
        @forelse ($viewData["product"]->comments as $comment)
            <p class="mb-2">
                {{ $comment->getDescription() }}
            </p>
        @empty
            <p class="text-muted">
                Este producto todavía no tiene comentarios.
            </p>
        @endforelse
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        Agregar un comentario
    </div>

    <div class="card-body">
        <form
            action="{{ route('product.comment.save', ['id' => $viewData['product']->id]) }}"
            method="POST"
        >
            @csrf

            <div class="mb-3">
                <label for="description" class="form-label">
                    Tu comentario
                </label>

                <textarea
                    id="description"
                    name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="4"
                    maxlength="2000"
                    required
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar comentario
            </button>
        </form>
    </div>
</div>

@endsection
