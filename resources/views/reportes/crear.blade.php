@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header text-center">
        <strong>Crear reporte</strong> / <a href="/reporte" class="alert-link">Ver reporte</a>
    </div>
    <div class="card-body container">
    @include('flash::message')
        <form action="/reporte/guardar" method="post" autocomplete="on"><!--off-->
            @csrf
            <div class="row">
                <div class="col-6">
                    <h6 class="text-center"><strong>1. Reporte</strong></h6>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Instructor que hace el reporte: </label>
                            <input type="hidden" name="instructor" value="{{Auth::user()->id}}">
                            <input type="text" class="form-control" readonly value="{{Auth::user()->name}}">
                            @error('instructor')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label for="">Descripción general: </label>
                            <input type="text" class="form-control @error('descripcionGeneral') is-invalid @enderror" value="{{old('descripcionGeneral')}}" name="descripcionGeneral">
                            @error('descripcionGeneral')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-3" >
                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h6 class="text-center"><strong>2. Equipos</strong></h6>
                    <input type="hidden" value="{{count($equipos)}}" id="contE"/>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="">Equipo: </label>
                            <select name="equipo" id="equipo" class="form-control">
                                <!--key ----( as $value )-->
                                @foreach($equipos as $key => $value)
                                    <option value="{{$value->id}}">{{$value->modelo}}</option>
                                @endforeach
                            </select>
                            @error('equipo')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label for="">Descripción del equipo: </label>
                            <select name="descripcion" id="descripcion" class="form-control">
                                <option value="Bueno">Bueno</option>
                                <option value="Malo">Malo</option>
                            </select>
                            @error('descripcion')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button onclick="agregarEquipo()" type="button" class="btn btn-success float-right">Agregar</button>
                        </div>
                    </div>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>Descripción</th>
                                <th>Opción</th>
                            </tr>
                        </thead>
                        <tbody id="tblEquipos">

                        </tbody>
                        
                    </table>
                    <div class="text-center mt-3" id="alerta"></div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>        
        let equipos = [];
        let contEquipos = $("#contE").val();
        let index=0;
        function agregarEquipo(){
            let id = $("#equipo option:selected").val();
            let equipo = $("#equipo option:selected").text();
            let descripcion = $("#descripcion option:selected").val();
            const equi = equipos.find(elemento=>elemento == equipo);
            if (equipos!=null) {
                if (equi) {
                    //alert("Ya se ingresó ese equipo");
                    swal({
                        title: "¡Alerta!",
                        text: "Ya se ingresó ese equipo",
                        icon: "error",
                        button: null,
                    });
                }else {
                    equipos.push(equipo);
                    $("#tblEquipos").append(`
                        <tr id="tr-${id}">
                            <td>
                                <input type="hidden" name="id[]" value="${id}"/>
                                <input type="hidden" name="descripcion[]" value="${descripcion}"/>
                                ${equipo}
                            </td>
                            <td>
                                ${descripcion}
                            </td>
                            <td>
                                <button type="button" onclick="eliminar_equipo(${id}, '${equipo}')" class="btn btn-danger"><i class="fas fa-ban"></i></button>
                            </td>
                        </tr>
                    `);
                }
            }
            if (equipos.length==contEquipos) {
                index++;
                console.log(index);
                swal({
                    title: "¡Listo!",
                    text: "Ya agregaste todos los equipos",
                    icon: "success",
                    button: null,
                });
            }
        }
        
        function eliminar_equipo(id, equipo){
            $("#tr-"+id).remove();
            const equi = equipos.indexOf(equipo);
            if (equi!=-1) {
                equipos.splice(equi,1);
            }
        }
        
    </script>
@endsection