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
}
