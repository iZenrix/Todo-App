<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;

class TugasController extends Controller
{
    public function data(Request $request){
        if($request->key){
            $tugas = Tugas::where('nrp', 'like', '%'.$request->key. '%')->orWhere('nama', 'like', '%'.$request->key. '%')->orWhere('todo', 'like', '%'.$request->key. '%')->get();
            return response()->json($tugas);
        }else{
            $tugas = Tugas::get();
            return response()->json($tugas);
        }
    }

    public function index(){
        $title = "List Tugas";
        return view('tugas.index', [
            "title" => $title
        ]);
    }

    public function store(Request $request){
        $tugas = new Tugas();
        $tugas->nrp = $request->nrp;
        $tugas->nama = $request->nama;
        $tugas->todo = $request->todo;
        $tugas->save();

        return response()->json([
            'status' => 200
        ]);
    }

    public function updateStatus(Request $request, $id_tugas) {
        

        $tugas = Tugas::findOrFail($id_tugas);
        $status = $tugas -> is_active == 1 ? 1 : 0;
        $tugas -> is_done = $status;
        $tugas->is_active = $status == 1 ? 0 : 1;
        $tugas -> save();

        return response() -> json([
            'status' => 200
        ]);
    }

    public function destroy($id_tugas){
        $items = Tugas::findOrFail($id_tugas);
        $items->delete();

        if($items){
            return response() -> json([
                'status' => 200
            ]); 
        }else{
            return response() -> json([
                'status' => 500
            ]);
        }
    }

    public function show($id_tugas){
        $tugas = Tugas::where('id_tugas', $id_tugas)->first();
        return response() -> json($tugas);
    }

    public function update(Request $request, $id_tugas){
        $tugas = Tugas::findOrFail($id_tugas);
        $tugas->nrp = $request->nrp;
        $tugas->nama = $request->nama;
        $tugas->todo = $request->todo;
        $tugas->save();

        return response()->json([
            'status' => 200
        ]);
    }

    // public function updateActive($id_tugas) {
    //     /*$tugas = Tugas::findOrFail($id_tugas);
    //     $tugas -> is_active = $tugas -> is_active == 1 ? 0 : 1;
    //     $tugas -> save();

    //     $tugasCheck = Tugas::where('$id_tugas', $tugas->id_tugas)->where("is_active", 1)->get();
    //     $semuaTugas = Tugas::where('$id_tugas', $tugas->id_tugas)->get();
        
    //     if(count($tugasCheck)==count($semuaTugas)){
    //         Tugas::where('id_tugas', $tugas->id_tugas)->update([
    //             "is_active" => 1
    //         ]);
    //     }
        
        
    //     return response() -> json([
    //         'status' => 200
    //     ]);*/
      

    //     $tugas = Tugas::findOrFail($id_tugas);
    //     $status = $tugas -> is_done == 0 ? 1 : 0;
    //     $tugas -> is_active =$status;
    //     $tugas -> is_done = $status == 1 ? 0 : 1;
    //     $tugas -> save();

    //     return response() -> json([
    //         'statusActive' => 200
    //     ]);
    // }
}
