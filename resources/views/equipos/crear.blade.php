@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header text-center">
        <strong>Crear equipo</strong> / <a href="/equipo" class="alert-link">Volver</a>
    </div>
    <div class="card-body container">
    @include('flash::message')
        <form action="/equipo/guardar" method="post" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Modelo</label>
                        <input type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{old('modelo')}}">
                        @error('modelo')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Consec</label>
                        <input type="text" class="form-control @error('consec') is-invalid @enderror" name="consec" value="{{old('consec')}}">
                        @error('consec')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Descc</label>
                        <input type="text" class="form-control @error('descc') is-invalid @enderror" name="descc" value="{{old('descc')}}">
                        @error('descc')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Descripción actual</label>
                        <input type="text" class="form-control @error('descripcionActual') is-invalid @enderror" name="descripcionActual" value="{{old('descripcionActual')}}">
                        @error('descripcionActual')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Tipo Mod</label>
                        <input type="text" class="form-control @error('tipoMod') is-invalid @enderror" name="tipoMod" value="{{old('tipoMod')}}">
                        @error('tipoMod')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Ambiente</label>
                        <select name="ambiente" class="form-control" id="">
                            <option value="">Seleccione</option>
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
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Instructor asignado del equipo</label>
                        @if(Auth::user()->role=="Instructor")
                            <!-- esto si es instructor-->
                            <input type="hidden" name="instructorAsignado" value="{{Auth::user()->id}}">
                            <input type="text" class="form-control" readonly value="{{Auth::user()->name}}">
                        @else
                            <select name="instructorAsignado" class="form-control" id="">
                                <option value="">Seleccione</option>
                                @foreach($instructores as $key => $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('instructorAsignado')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                        @endif
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-left">Guardar</button>
        </form>
    </div>
</div>

@endsection