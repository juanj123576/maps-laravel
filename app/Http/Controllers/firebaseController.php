<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Factory;

class firebaseController extends Controller
{
    protected $db;
    public function __construct() {


        $factory = (new Factory)->withServiceAccount('/path/to/firebase_credentials.json');
        $this->db =new FirestoreClient([
            'projectId'=> 'laravel-61a96'
        ]);
    }
    public function store(Request $request){
        $docRef = $this->db->collection('usuarios');
        $docRef->add([
            'nombre' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password)
        ]);
    }
    //
}
