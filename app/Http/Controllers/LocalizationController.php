<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    function index($locale){
        Session::put('locale',$locale);
        return redirect()->back();
    }
}
