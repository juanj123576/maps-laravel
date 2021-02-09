<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PruebaController extends Controller
{
   public function index(Request $request)
{   
   $usuario = User::all();
   return $usuario;
}
public function home()
{
    return view('home');
} 
}
