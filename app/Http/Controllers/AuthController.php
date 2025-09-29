<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private FirestoreClient $firestore) {}
    
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'senha' => 'required|string',
        ]);

        $usersCollection = $this->firestore->collection('users');

        
        $query = $usersCollection->where('email', '=', $credentials['email']);
        
        $documents = $query->documents();

        if ($documents->isEmpty()) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        $user = $documents->rows()[0]->data();

        if (!password_verify($credentials['senha'], $user['senha'])) {
            return back()->withErrors(['senha' => 'Invalid credentials.'])->withInput();
        }

        session(['user' => $user, 'user_id' => $documents->rows()[0]->id()]);

        return redirect('/painel');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'senha' => 'required|string|min:6',
        ]);

        $data['senha'] = bcrypt($data['senha']);
        $data['perfil'] = 'aluno';

        $this
            ->firestore
            ->collection('users')
            ->add($data);

        return redirect('/painel')->with('success', 'Registration successful. Please log in.');
    }

    public function logout()
    {
        session()->forget(['user', 'user_id']);
        return redirect('/auth/login');
    }

}
