@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header text-center">
        <strong>Modificar ambiente</strong> / <a href="/ambiente" class="alert-link">Volver</a>
    </div>
    <div class="card-body container">
    @include('flash::message')
        <form action="/ambiente/modificar" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$ambiente->id}}">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Nombre del ambiente</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{$ambiente->nombre}}" name="nombre">
                        @error('nombre')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-left">Guardar</button>
        </form>
        
    </div>
    
</div>

@endsection