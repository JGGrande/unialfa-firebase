<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function __construct(private FirestoreClient $firestore) {}

    public function index()
    {
        $user = session('user');
        
        if (!$user) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado para acessar o painel.');
        }

        $users = [];
        
        if ($user['perfil'] === 'admin') {
            $usersCollection = $this->firestore->collection('users');
            $documents = $usersCollection->documents();
            
            foreach ($documents as $document) {
                if ($document->exists()) {
                    $userData = $document->data();
                    $userData['id'] = $document->id();
                    $users[] = $userData;
                }
            }
        } else {
            $user['id'] = session('user_id');
            $users[] = $user;
        }

        return view('painel.index', compact('user', 'users'));
    }

    public function show($id)
    {
        $currentUser = session('user');
        
        if (!$currentUser) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado.');
        }

        if ($currentUser['perfil'] !== 'admin' && session('user_id') !== $id) {
            return redirect('/painel')->with('error', 'Você não tem permissão para acessar esses dados.');
        }

        try {
            $document = $this
                ->firestore
                ->collection('users')
                ->document($id)
                ->snapshot();
            
            if (!$document->exists()) {
                return redirect('/painel')->with('error', 'Usuário não encontrado.');
            }
            
            $user = $document->data();
            $user['id'] = $document->id();
            
            return view('painel.show', compact('currentUser', 'user'));
        } catch (\Exception $e) {
            return redirect('/painel')->with('error', 'Erro ao carregar dados do usuário.');
        }
    }

    public function edit($id)
    {
        $currentUser = session('user');
        
        if (!$currentUser) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado.');
        }

        if ($currentUser['perfil'] !== 'admin' && session('user_id') !== $id) {
            return redirect('/painel')->with('error', 'Você não tem permissão para editar esses dados.');
        }

        try {
            $document = $this
                ->firestore
                ->collection('users')
                ->document($id)
                ->snapshot();
            
            if (!$document->exists()) {
                return redirect('/painel')->with('error', 'Usuário não encontrado.');
            }
            
            $user = $document->data();
            $user['id'] = $document->id();
            
            return view('painel.edit', compact('currentUser', 'user'));
        } catch (\Exception $e) {
            return redirect('/painel')->with('error', 'Erro ao carregar dados do usuário.');
        }
    }

    public function update(Request $request, $id)
    {
        $currentUser = session('user');
        
        if (!$currentUser) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado.');
        }

        if ($currentUser['perfil'] !== 'admin' && session('user_id') !== $id) {
            return redirect('/painel')->with('error', 'Você não tem permissão para editar esses dados.');
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if (
            $currentUser['perfil'] === 'admin' && 
            $request->has('perfil') &&
            in_array($request->input('perfil'), ['aluno', 'admin'])
        ) {
            $data['perfil'] = $request->input('perfil');            
        }

        try {
            $updateData = [];
            foreach ($data as $field => $value) {
                $updateData[] = ['path' => $field, 'value' => $value];
            }
            
            $this
                ->firestore
                ->collection('users')
                ->document($id)
                ->update($updateData);
            
            if (session('user_id') === $id) {
                $updatedUser = array_merge(session('user'), $data);
                session(['user' => $updatedUser]);
            }
            
            return redirect('/painel')->with('success', 'Dados atualizados com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar dados do usuário.');
        }
    }

    public function destroy($id)
    {
        $currentUser = session('user');
        
        if (!$currentUser || $currentUser['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para remover usuários.');
        }

        try {
            $this
                ->firestore
                ->collection('users')
                ->document($id)
                ->delete();

            return redirect('/painel')->with('success', 'Usuário removido com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover usuário.');
        }
    }
}