<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PainelController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $user = session('user');

        if (!$user) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado para acessar o painel.');
        }

        if ($user['perfil'] === 'admin') {
            $users = User::orderBy('created_at', 'desc')->get()->map(function ($u) {
                return [
                    'id' => (string) $u->id,
                    'nome' => $u->name ?? '',
                    'email' => $u->email,
                    'perfil' => $u->perfil ?? 'aluno',
                ];
            })->toArray();
        } else {
            $user['id'] = (string) session('user_id');
            $users = [$user];
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

        $u = User::find($id);
        if (!$u) {
            return redirect('/painel')->with('error', 'Usuário não encontrado.');
        }
        $user = [
            'id' => (string) $u->id,
            'nome' => $u->name ?? '',
            'email' => $u->email,
            'perfil' => $u->perfil ?? 'aluno',
        ];
        return view('painel.show', compact('currentUser', 'user'));
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

        $u = User::find($id);
        if (!$u) {
            return redirect('/painel')->with('error', 'Usuário não encontrado.');
        }
        $user = [
            'id' => (string) $u->id,
            'nome' => $u->name ?? '',
            'email' => $u->email,
            'perfil' => $u->perfil ?? 'aluno',
        ];
        return view('painel.edit', compact('currentUser', 'user'));
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

        $u = User::find($id);
        if (!$u) {
            return back()->with('error', 'Usuário não encontrado.');
        }
        $u->name = $data['nome'];
        $u->email = $data['email'];
        if (isset($data['perfil'])) {
            $u->perfil = $data['perfil'];
        }
        $u->save();

        if ((string) session('user_id') === (string) $id) {
            $updatedUser = array_merge(session('user'), [
                'nome' => $u->name,
                'email' => $u->email,
                'perfil' => $u->perfil ?? (session('user')['perfil'] ?? 'aluno'),
            ]);
            session(['user' => $updatedUser]);
        }

        return redirect('/painel')->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy($id)
    {
        $u = User::find($id);
        if (!$u) {
            return back()->with('error', 'Usuário não encontrado.');
        }
        $u->delete();
        return redirect('/painel')->with('success', 'Usuário removido com sucesso!');
                ->document($id)
                ->delete();

            return redirect('/painel')->with('success', 'Usuário removido com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover usuário.');
        }
    }
}
