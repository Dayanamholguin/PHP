@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header text-center">
        <strong>Modificar equipo</strong> / <a href="/equipo" class="alert-link">Volver</a>
    </div>
    <div class="card-body container">
    @include('flash::message')
        <form action="/equipo/modificar" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$equipo->id}}">
            <div class="row">
                
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Modelo</label>
                        <input type="hidden" class="form-control @error('modelo') is-invalid @enderror" value="{{$equipo->modelo}}" name="modelo">
                        <input type="text" class="form-control" value="{{$equipo->modelo}}" readonly>
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
                        <input type="text" class="form-control @error('consec') is-invalid @enderror" value="{{$equipo->consec}}" name="consec">
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
                        <input type="text" class="form-control @error('descc') is-invalid @enderror" value="{{$equipo->descc}}" name="descc">
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
                        <input type="text" class="form-control @error('descripcionActual') is-invalid @enderror" value="{{$equipo->descripcionActual}}" name="descripcionActual">
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
                        <input type="text" class="form-control @error('tipoMod') is-invalid @enderror" value="{{$equipo->tipoMod}}" name="tipoMod">
                        @error('tipoMod')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                @if(Auth::user()->role=="Instructor")
                <div class="col-6" style="display: none;">
                    <div class="form-group">
                        <label for="">Ambiente</label>
                        <select name="ambiente" class="form-control" id="">
                            <option value="">Seleccione</option>
                            @foreach($ambientes as $key => $value)
                                <option {{$value->id==$equipo->ambiente ? 'selected' : ''}} value="{{$value->id}}">{{$value->nombre}}</option>
                            @endforeach
                        </select>
                        @error('ambiente')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-6" style="display: none;">
                    <div class="form-group">
                        <label for="">Instructor</label>
                        <!-- esto si es instructor
                        <input type="hidden" name="instructorAsignado" value="{{Auth::user()->id}}">
                        <input type="text" class="form-control" readonly value="{{Auth::user()->name}}">
                        -->
                        <select name="instructorAsignado" class="form-control" id="">
                            <option value="">Seleccione</option>
                            @foreach($instructores as $key => $value)
                                <option {{$value->id==$equipo->instructorAsignado ? 'selected' : ''}} value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                        @error('instructorAsignado')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div> 
                @endif 
                @if(Auth::user()->role=="Admin")
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Ambiente</label>
                        <select name="ambiente" class="form-control" id="">
                            <option value="">Seleccione</option>
                            @foreach($ambientes as $key => $value)
                                <option {{$value->id==$equipo->ambiente ? 'selected' : ''}} value="{{$value->id}}">{{$value->nombre}}</option>
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
                        <label for="">Instructor</label>
                        <!-- esto si es instructor
                        <input type="hidden" name="instructorAsignado" value="{{Auth::user()->id}}">
                        <input type="text" class="form-control" readonly value="{{Auth::user()->name}}">
                        -->
                        <select name="instructorAsignado" class="form-control" id="">
                            <option value="">Seleccione</option>
                            @foreach($instructores as $key => $value)
                                <option {{$value->id==$equipo->instructorAsignado ? 'selected' : ''}} value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                        @error('instructorAsignado')
                        <div class="alert alert-danger" role="alert">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div> 
                @endif              
            </div>
            <button type="submit" class="btn btn-success float-left">Guardar</button>
        </form>
        
    </div>
    
</div>

@endsection