<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public function index(){
        $respuesta = Http::get('http://127.0.0.1:8000/api/articulos/');
        $articulos = $respuesta->json();
        return view('home.index', compact('articulos'));
    }
}