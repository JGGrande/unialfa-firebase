<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function googleLogin(Request $request)
    {
        try {
            $userData = $request->validate([
                'uid' => 'nullable|string',
                'nome' => 'required|string',
                'email' => 'required|email',
                'photo_url' => 'nullable|string',
                'provider' => 'required|string'
            ]);

            $usersCollection = $this->firestore->collection('users');

            $query = $usersCollection->where('email', '=', $userData['email']);
            $documents = $query->documents();

            if (!$documents->isEmpty()) {
                //Se o usuário existe, atualiza com as informações do Google se necessário
                $existingUser = $documents->rows()[0]->data();
                $userId = $documents->rows()[0]->id();

                $updateData = [];
                if (!isset($existingUser['google_uid'])) {
                    $updateData['google_uid'] = $userData['uid'];
                }
                if (!isset($existingUser['photo_url']) && $userData['photo_url']) {
                    $updateData['photo_url'] = $userData['photo_url'];
                }
                if (!isset($existingUser['provider'])) {
                    $updateData['provider'] = $userData['provider'];
                }

                if (!empty($updateData)) {
                    $usersCollection
                        ->document($userId)
                        ->update($updateData, ['merge' => true]);
                    
                    $existingUser = array_merge($existingUser, $updateData);
                }

                session(['user' => $existingUser, 'user_id' => $userId]);

            } else {
                // Cria novo usuário
                $newUserData = [
                    'nome' => $userData['nome'],
                    'email' => $userData['email'],
                    'google_uid' => $userData['uid'],
                    'photo_url' => $userData['photo_url'] ?? null,
                    'provider' => $userData['provider'],
                    'perfil' => 'aluno', // Default role
                    'created_at' => now()->toISOString(),
                    'senha' => null // No password for Google users
                ];

                $docRef = $usersCollection->add($newUserData);
                $userId = $docRef->id();

                // Set session
                session(['user' => $newUserData, 'user_id' => $userId]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'redirect' => '/painel'
            ]);

        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor. Tente novamente.'
            ], 500);
        }
    }
}
