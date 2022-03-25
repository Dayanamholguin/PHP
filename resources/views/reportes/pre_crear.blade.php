@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <strong>Crear reporte</strong> / <a href="/reporte" class="alert-link">Ver reporte</a>
    </div>
    <div class="card-body container">
    @include('flash::message')
        <form action="/reporte/crear" method="post" autocomplete="on"><!--off-->
            @csrf
            <div class="container mt-1">
                <div class="row justify-content-center">
                    <div class="col-auto mt-5">
                        <div class="form-group">
                            <label for="">Ambiente: </label>
                            <select name="ambiente" id="ambiente" class="form-control">
                                <!--key ----( as $value )-->
                                @foreach($ambientes as $key => $value)
                                    <option value="{{$value->id}}">{{$value->nombre}}</option>
                                @endforeach
                            </select>
                            @error('ambiente')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="subtmit" class="btn btn-success float-center">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection