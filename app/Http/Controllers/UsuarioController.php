<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function enviar(Request $request){
        
    
    
    
        return response()->json([
                'nombre' => $request->nombre,
                'contraseña'=>$request->password
            ], 200);
        }
}
