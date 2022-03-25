<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flash;
use DataTables;
use App\Models\equipos;
use App\Models\ambientes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class equiposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('equipos.index');
    }
    public function listar(Request $request){
        //$equipos=equipos::all();
        if (Auth::user()->role=="Instructor") {
            /*consulta para que visualice los equipos que ha registrado a su nombre*/
            $equipos=equipos::select("equipos.*","ambientes.nombre", "users.name")
            ->join("ambientes","equipos.ambiente", "=", "ambientes.id")        
            ->join("users", function($join){
                $join->on("equipos.instructorAsignado", "=", "users.id")
                    ->where("users.name", Auth::user()->name);
            })
            ->get();
        } else {
            /*consulta para que veaa todo, admin*/
            $equipos=equipos::select("equipos.*","ambientes.nombre", "users.name")
            ->join("ambientes","equipos.ambiente", "=", "ambientes.id")
            ->join("users","equipos.instructorAsignado", "=", "users.id")
            ->get();
        }
        
        
        return DataTables::of($equipos)
        ->editColumn("estado", function($equipo){
            return $equipo->estado == 1 ? "Activo" : "Inactivo";
        })
        ->addColumn('editar', function ($equipo) {
            return '<a class="btn btn-sm btn-primary" href="/equipo/editar/'.$equipo->id.'"><i class="fas fa-edit"></i></a>';
        })
        ->addColumn('cambiarEstado', function ($equipo) {
            if ($equipo->estado==1) {
                return '<a class="btn btn-sm btn-danger" href="/equipo/cambiarEstado/'.$equipo->id.'/0"><i class="fas fa-eye-slash"></i></a>';
            }else {
                return '<a class="btn btn-sm btn-success" href="/equipo/cambiarEstado/'.$equipo->id.'/1"><i class="fas fa-eye"></i></a>';
            }
        })
        ->rawColumns(['editar', 'cambiarEstado'])
        ->make(true);
    }
    public function crear (){
        $ambientes=ambientes::all()->where("estado",1); //---->get();
        $instructores=User::all();
        return view('equipos.crear', compact("ambientes","instructores"));
    }
    public function guardar(Request $request){
        $request->validate(equipos::$rules); //-----------
        $equipo = equipos::select('*')->where('modelo',$request->modelo)->value('modelo');
        
        if ($equipo!=null) {
            $ambiente=equipos::select("ambientes.nombre")
            ->join("ambientes","equipos.ambiente", "=", "ambientes.id")
            ->value("ambientes.nombre");
            $instructor=equipos::select("users.name")
            ->join("users","equipos.instructorAsignado", "=", "users.id")
            ->value("users.name");
            Flash::error("El equipo $equipo ya está creado. Instructor(a) asignado es $instructor y se encuentra en el ambiente $ambiente");
            return redirect("/equipo/crear");
        }
        
        $input =$request->all();
        try {
            equipos::create([
                "modelo"=>$input["modelo"],
                "consec"=>$input["consec"],
                "descc"=>$input["descc"],
                "descripcionActual"=>$input["descripcionActual"],
                "tipoMod"=>$input["tipoMod"],
                "ambiente"=>$input["ambiente"],
                "instructorAsignado"=>$input["instructorAsignado"],
            ]);
            Flash::success("Se ha creado éxitosamente");
            return redirect("/equipo");
            //Flash::success();
        }catch(\Exception $e){
            Flash::error($e->getMessage());
            return redirect("/equipo/crear");
        }
    }
    public function editar($id){
        $ambientes=ambientes::all()->where("estado",1); //---->get();
        $instructores=User::all();

        $equipo = equipos::find($id);
        if ($equipo==null) {
            Flash::error("equipo no encontrado");
            return redirect("/equipo");
        }
        return view("equipos.editar", compact("equipo","ambientes","instructores"));
    }
    public function modificar(Request $request){
        $request->validate(equipos::$rules); //-----------
        $id=$request->id;
        /*$equipo = equipos::select('*')->where('modelo',$request->modelo)->value('modelo');
        
        if ($equipo!=null) {
            Flash::error("el equipo $equipo ya está creado");
            return redirect("/equipo/editar/$id");
        }*/

        $input =$request->all();

        try {

            $equipo = equipos::find($input["id"]);

            if ($equipo==null) {
                Flash::error("equipo no encontrado");
                return redirect("/equipo");
            }

            $equipo->update([
                "modelo"=>$input["modelo"],
                "consec"=>$input["consec"],
                "descc"=>$input["descc"],
                "descripcionActual"=>$input["descripcionActual"],
                "tipoMod"=>$input["tipoMod"],
                "ambiente"=>$input["ambiente"],
                "instructorAsignado"=>$input["instructorAsignado"],
            ]);

            Flash::success("Se modificó éxitosamente");
            return redirect("/equipo");
            //Flash::success();
        }catch(\Exception $e){
            Flash::error($e->getMessage());
            return redirect("/equipo");
        }
    }
    public function cambiarEstado($id,$estado){
        $equipo = equipos::find($id);
        if ($equipo==null) {
            Flash::error("equipo no encontrado");
            return redirect("/equipo");
        }
        try {
            $equipo->update(["estado" => $estado]);
            Flash::success("Se modificó el estado éxitosamente");
            return redirect("/equipo");
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect("/equipo");
        }

    }
}
