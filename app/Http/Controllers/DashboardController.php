<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Curs;
use App\Models\Recurs;

class DashboardController extends Controller
{
    // get cursos with resources
    public function getCursos(){
        $cursos = Curs::with('recursos')->get();
        return response()->json($cursos);
    }

    // delete curso
    public function deleteCurso($id){
        Recurs::where('curs_id', $id)->delete();
        Curs::where('id', $id)->delete();
      return response()->json(['message' => 'Curso eliminado']);
    }

    // delete resource
    public function deleteRecurso($id){
        Recurs::where('id', $id)->delete();
      return response()->json(['message' => 'Recurso eliminado']);
    }

    // add resource
    public function addRecurso(Request $request){
        $data = $request->all();
        Recurs::create($data);
        return response()->json(['message' => 'Recurso añadido']);
    }

    // add course
    public function addCurso(Request $request){
        $data = $request->all();
        Curs::create($data);
        return response()->json(['message' => 'Curso añadido']);
    }

    // edit course by data
    public function editCurso(Request $request){
        $data = $request->all();
        Curs::where('id', $data['id'])->update($data);
    }

    // edit recurso by data
    public function editRecurso(Request $request){
        $data = $request->all();
        Recurs::where('id', $data['id'])->update($data);
    }

    


}
