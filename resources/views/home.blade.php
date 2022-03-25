@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <h1>¡Hola! <br><br>Bienvenido(a), {{Auth::user()->name}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection
