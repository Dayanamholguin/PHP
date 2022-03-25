<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Flash;
use DataTables;
use Illuminate\Support\Facades\Session;

use App\Models\ambientes;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class ambientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('ambientes.index');
    }
    public function listar(Request $request){
        $ambientes=ambientes::all();
        
        return DataTables::of($ambientes)
        ->editColumn("estado", function($ambiente){
            return $ambiente->estado == 1 ? "Activo" : "Inactivo";
        })
        ->addColumn('editar', function ($ambiente) {
            return '<a class="btn btn-sm btn-primary" href="/ambiente/editar/'.$ambiente->id.'"><i class="fas fa-edit"></i></a>';
        })
        ->addColumn('cambiarEstado', function ($ambiente) {
            if ($ambiente->estado==1) {
                return '<a class="btn btn-sm btn-danger" href="/ambiente/cambiarEstado/'.$ambiente->id.'/0"><i class="fas fa-eye-slash"></i></a>';
            }else {
                return '<a class="btn btn-sm btn-success" href="/ambiente/cambiarEstado/'.$ambiente->id.'/1"><i class="fas fa-eye"></i></a>';
            }
        })
        ->rawColumns(['editar', 'cambiarEstado'])
        ->make(true);
    }
    public function crear (){
        return view('ambientes.crear');
    }
    public function guardar(Request $request){
        $request->validate(ambientes::$rules); //-----------
        $ambiente = ambientes::select('*')->where('nombre',$request->nombre)->value('nombre');
        
        if ($ambiente!=null) {
            Flash::error("el ambiente $ambiente ya está creado");
            return redirect("/ambiente/crear");
        }
        
        $input =$request->all();
        try {
            ambientes::create([
                "nombre"=>$input["nombre"],
            ]);
            Flash::success("Se ha creado éxitosamente");
            return redirect("/ambiente");
            //Flash::success();
        }catch(\Exception $e){
            Flash::error($e->getMessage());
            return redirect("/ambiente/crear");
        }
    }
    public function editar($id){
        $ambiente = ambientes::find($id);
        if ($ambiente==null) {
            Flash::error("ambiente no encontrado");
            return redirect("/ambiente");
        }
        return view("ambientes.editar", compact("ambiente"));
    }
    public function modificar(Request $request){
        $request->validate(ambientes::$rules); //-----------
        $id=$request->id;
        $ambiente = ambientes::select('*')->where('nombre',$request->nombre)->value('nombre');
        
        if ($ambiente!=null) {
            Flash::error("el ambiente $ambiente ya está creado");
            return redirect("/ambiente/editar/$id");
        }

        $input =$request->all();

        try {

            $ambiente = ambientes::find($input["id"]);

            if ($ambiente==null) {
                Flash::error("ambiente no encontrado");
                return redirect("/ambiente");
            }

            $ambiente->update([
                "nombre"=>$input["nombre"],
            ]);
            Flash::success("Se modificó éxitosamente");
            return redirect("/ambiente");
            //Flash::success();
        }catch(\Exception $e){
            Flash::error($e->getMessage());
            return redirect("/ambiente");
        }
    }
    public function cambiarEstado($id,$estado){
        $ambiente = ambientes::find($id);
        if ($ambiente==null) {
            Flash::error("ambiente no encontrado");
            return redirect("/ambiente");
        }
        try {
            $ambiente->update(["estado" => $estado]);
            Flash::success("Se modificó el estado éxitosamente");
            return redirect("/ambiente");
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect("/ambiente");
        }

    }
}
