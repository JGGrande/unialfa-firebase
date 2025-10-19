<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CursoController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $user = session('user');
        
        if (!$user) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        // Apenas admins podem gerenciar cursos
        if ($user['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para gerenciar cursos.');
        }

        try {
            $cursos = Curso::orderBy('created_at', 'desc')->get()->map(fn($c) => [
                'id' => $c->id,
                'nome' => $c->nome,
                'descricao' => $c->descricao,
                'image_url' => $c->image_url,
            ])->toArray();
            return view('cursos.index', compact('user', 'cursos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar cursos: ' . $e->getMessage());
            return redirect('/painel')->with('error', 'Erro ao carregar dados dos cursos.');
        }
    }

    public function create()
    {
        $user = session('user');
        
        if (!$user || $user['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para criar cursos.');
        }

        return view('cursos.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = session('user');
        
        if (!$user || $user['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para criar cursos.');
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'image_url' => 'required|url|max:500',
        ]);

        try {
            Curso::create($data);
            return redirect('/cursos')->with('success', 'Curso criado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar curso: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar curso. Tente novamente.')->withInput();
        }
    }

    public function show($id)
    {
        $user = session('user');
        
        if (!$user) {
            return redirect('/auth/login')->with('error', 'Você precisa estar logado.');
        }

        try {
            $c = Curso::find($id);
            if (!$c) {
                return redirect('/cursos')->with('error', 'Curso não encontrado.');
            }
            $curso = [
                'id' => $c->id,
                'nome' => $c->nome,
                'descricao' => $c->descricao,
                'image_url' => $c->image_url,
            ];
            return view('cursos.show', compact('user', 'curso'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar curso: ' . $e->getMessage());
            return redirect('/cursos')->with('error', 'Erro ao carregar dados do curso.');
        }
    }

    public function edit($id)
    {
        $user = session('user');
        
        if (!$user || $user['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para editar cursos.');
        }

        try {
            $c = Curso::find($id);
            if (!$c) {
                return redirect('/cursos')->with('error', 'Curso não encontrado.');
            }
            $curso = [
                'id' => $c->id,
                'nome' => $c->nome,
                'descricao' => $c->descricao,
                'image_url' => $c->image_url,
            ];
            return view('cursos.edit', compact('user', 'curso'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar curso para edição: ' . $e->getMessage());
            return redirect('/cursos')->with('error', 'Erro ao carregar dados do curso.');
        }
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        
        if (!$user || $user['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para editar cursos.');
        }

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:1000',
            'image_url' => 'required|url|max:500',
        ]);

        try {
            $c = Curso::find($id);
            if (!$c) {
                return redirect('/cursos')->with('error', 'Curso não encontrado.');
            }
            $c->update($data);
            return redirect('/cursos')->with('success', 'Curso atualizado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar curso: ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar dados do curso.');
        }
    }

    public function destroy($id)
    {
        $user = session('user');
        
        if (!$user || $user['perfil'] !== 'admin') {
            return redirect('/painel')->with('error', 'Você não tem permissão para remover cursos.');
        }

        try {
            $c = Curso::find($id);
            if (!$c) {
                return redirect('/cursos')->with('error', 'Curso não encontrado.');
            }
            $c->delete();
            return redirect('/cursos')->with('success', 'Curso removido com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao remover curso: ' . $e->getMessage());
            return back()->with('error', 'Erro ao remover curso.');
        }
    }

    // Método público para buscar cursos na home
    public function getCursosForHome()
    {
        try {
            $cursos = Curso::orderBy('created_at', 'desc')->get()->map(fn($c) => [
                'id' => $c->id,
                'nome' => $c->nome,
                'descricao' => $c->descricao,
                'image_url' => $c->image_url,
            ])->toArray();
            return view('home', compact('cursos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar cursos para home: ' . $e->getMessage());
            return view('home', ['cursos' => []]);
        }
    }
}