<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Curso;
use App\CursoCadeira;
use App\GrauAcademico;
use App\Departamento;
use App\UserCadeira;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class AuthController extends Controller
{
    public function getLogin() {
        return view('auth.login');
    }

}

?>