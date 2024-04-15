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

class WelcomeController extends Controller
{
    // get cursos
    public function getCursos(){
        $cursos = Curs::where('visible', true)
            ->orderBy('nom')
            ->get();

        return response()->json($cursos);
    }
}