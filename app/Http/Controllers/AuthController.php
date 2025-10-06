<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private FirestoreClient $firestore){}

    public function auth(Request $request)
    {   
        //Buscar com where
        $documents = $this
            ->firestore
            ->collection("users")
            ->where("email", "=", "joao@unialfa.com.br")
            ->documents();

        //Adicionar novo documento
        $user = [];
        $this
            ->firestore
            ->collection("users")
            ->add($user);
    }
    
    public function createUser(array $data)
    {
        return $this->firestore->collection('users')->add($data);
    }

    public function getUser(string $id)
    {
        return $this->firestore->collection('users')->document($id)->snapshot();
    }

    public function updateUser(string $id, array $data)
    {
        return $this->firestore->collection('users')->document($id)->set($data, ['merge' => true]);
    }

    public function deleteUser(string $id)
    {
        return $this->firestore->collection('users')->document($id)->delete();
    }
        
}
