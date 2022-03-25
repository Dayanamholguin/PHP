<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flash;
use App\Models\equipos;
use App\Models\reportes;
use App\Models\reporteequipos;
use App\Models\ambientes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;

class reporteequiposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexAnulacion(Request $request){
        $id = $request->input("id");
        $equipos=[];
        if ($id!=null) {
            $equipos=equipos::select("reportes.id","equipos.modelo","ambientes.nombre","reporteequipos.descripcion","users.name","users.lastname")
            ->join("reporteequipos","equipos.id","=","reporteequipos.equipo")
            ->join("ambientes","equipos.ambiente","=","ambientes.id")
            ->join("reportes","reportes.id","=","reporteequipos.reporte")
            ->join("users","users.id","=","reportes.instructor")
            ->where("reporteequipos.reporte",$id)
            ->get();
        }
        return view('reportes.indexAnulacion' , compact("equipos"));
    }

    public function listarAnulados(){
        if (Auth::user()->role=="Instructor") {
            /*consulta para que visualice los reportes anulados que ha registró a su nombre*/
            $reportes=reportes::select("reportes.*","users.name")       
            ->join("users", function($join){
                $join->on("reportes.instructor", "=", "users.id")
                    ->where("users.name", Auth::user()->name);
            })
            ->where("estado",0)
            ->get();
        } else {
            /*consulta para que veaa todo, admin*/
            $reportes=reportes::select("reportes.*","users.name")
            ->join("users","reportes.instructor","=","users.id")
            ->where("estado",0)
            ->get();
        }
        

        return DataTables::of($reportes)
        ->addColumn("fecha", function($reporte){ 
            return '<p>'.substr($reporte->updated_at,0,10).'</p>';
        })
        ->editColumn("updated_at", function($reporte){
            return $reporte->updated_at->diffForHumans();
        })
        ->addColumn('ver', function ($reporte) {
            return '<a class="btn btn-sm btn-success" href="/reporte/anulado?id='.$reporte->id.'"><i class="fas fa-caret-down"></i> Ver</a>';
        })
        ->rawColumns(['ver','fecha'])
        ->make(true);
    }

    public function index(Request $request){
        $id = $request->input("id");
        $equipos=[];
        if ($id!=null) {
            $equipos=equipos::select("reportes.id","equipos.modelo","ambientes.nombre","reporteequipos.descripcion","users.name","users.lastname")
            ->join("reporteequipos","equipos.id","=","reporteequipos.equipo")
            ->join("ambientes","equipos.ambiente","=","ambientes.id")
            ->join("reportes","reportes.id","=","reporteequipos.reporte")
            ->join("users","users.id","=","reportes.instructor")
            ->where("reporteequipos.reporte",$id)
            ->get();
        }
        return view('reportes.index' , compact("equipos"));
    }

    public function listar(){
        if (Auth::user()->role=="Instructor") {
            /*consulta para que visualice los reportes que ha registrado a su nombre*/
            $reportes=reportes::select("reportes.*","users.name")       
            ->join("users", function($join){
                $join->on("reportes.instructor", "=", "users.id")
                    ->where("users.name", Auth::user()->name);
            })
            ->where("estado",1)
            ->get();
        } else {
            /*consulta para que veaa todo, admin*/
            $reportes=reportes::select("reportes.*","users.name")
            ->join("users","reportes.instructor","=","users.id")
            ->where("estado",1)
            ->get();
        }
        return DataTables::of($reportes)
        ->editColumn("created_at", function($reporte){
            return substr($reporte->created_at,0,10);
        })
        ->addColumn('ver', function ($reporte) {
            return '<a class="btn btn-sm btn-success" href="/reporte?id='.$reporte->id.'"><i class="fas fa-caret-down"></i> Ver</a>';
        })
        ->addColumn('cambiarEstado', function ($reporte) {
            while($reporte->created_at->diffInMinutes()<10){
                if ($reporte->estado==1) {
                    return '<a class="btn btn-sm btn-danger" href="/reporte/cambiarEstado/'.$reporte->id.'/0"><i class="fas fa-trash"></i></i></a>';
                }
            }
            return '<button type="button" class="btn btn-sm btn-danger" disabled><i class="fas fa-trash"></i></i></button>';
        })
        ->rawColumns(['ver', 'cambiarEstado'])
        ->make(true);
    }

    public function cambiarEstado($id,$estado){
        $reporte = reportes::find($id);
        if ($reporte==null) {
            Flash::error("reporte no encontrado");
            return redirect("/reporte");
        }
        try {
            $reporte->update(["estado" => $estado]);
            Flash::success("Se eliminó éxitosamente");
            return redirect("/reporte");
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect("/reporte");
        }

    }

    public function pre_crear(){
        $ambientes=ambientes::all()->where("estado",1);
        if ($ambientes) {
            return view('reportes.pre_crear', compact("ambientes"));
        }
        Flash::error("No se encontró el equipo");
        return redirect("/reporte/pre_crear");
    }

    public function crear(Request $request){
        $equipos = equipos::all()->where("ambiente", $request->ambiente)->where("estado",1);
        //$equipos=equipos::all()->where("estado",1);
        return view('reportes.crear', compact("equipos"));
    }

    public function guardar(Request $request){
        $request->validate(reportes::$rules);
        $input = $request->all();
        try{
            DB::beginTransaction();
            $reporte = reportes::create([
                "instructor"=>$input["instructor"],
                "descripcionGeneral"=>$input["descripcionGeneral"],
            ]);
            foreach ($input["id"] as $key => $value) {
                reporteequipos::create([
                    "reporte"=>$reporte->id,
                    "equipo"=>$value,
                    "descripcion"=>$input["descripcion"][$key]
                ]);
                $equi = equipos::find($value);
                $equi->update(["descripcionActual"=>$input["descripcion"][$key]]);
            }
            DB::commit();
            Flash::success("Se ha creado éxitosamente");
            return redirect("/reporte");
        }catch(\Exception $e){
            DB::rollBack();
            Flash::error($e->getMessage());
            return redirect("/reporte/crear");
        }
    }
}
