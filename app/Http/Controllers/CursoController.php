<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CursoController extends Controller
{
    public function __construct(private FirestoreClient $firestore) {}

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

        $cursos = [];
        
        try {
            $cursosCollection = $this->firestore->collection('cursos');
            $documents = $cursosCollection->documents();
            
            foreach ($documents as $document) {
                if ($document->exists()) {
                    $cursoData = $document->data();
                    $cursoData['id'] = $document->id();
                    $cursos[] = $cursoData;
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro ao carregar cursos: ' . $e->getMessage());
            return redirect('/painel')->with('error', 'Erro ao carregar dados dos cursos.');
        }

        return view('cursos.index', compact('user', 'cursos'));
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
            $this->firestore
                ->collection('cursos')
                ->add($data);

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
            $document = $this->firestore
                ->collection('cursos')
                ->document($id)
                ->snapshot();
            
            if (!$document->exists()) {
                return redirect('/cursos')->with('error', 'Curso não encontrado.');
            }
            
            $curso = $document->data();
            $curso['id'] = $document->id();
            
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
            $document = $this->firestore
                ->collection('cursos')
                ->document($id)
                ->snapshot();
            
            if (!$document->exists()) {
                return redirect('/cursos')->with('error', 'Curso não encontrado.');
            }
            
            $curso = $document->data();
            $curso['id'] = $document->id();
            
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
            // Converter array associativo para o formato esperado pelo Firestore
            $updateData = [];
            foreach ($data as $field => $value) {
                $updateData[] = [$field, $value];
            }
            
            $this->firestore
                ->collection('cursos')
                ->document($id)
                ->update($updateData);
            
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
            $this->firestore
                ->collection('cursos')
                ->document($id)
                ->delete();

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
            $cursosCollection = $this->firestore->collection('cursos');
            $documents = $cursosCollection->documents();
            
            $cursos = [];
            foreach ($documents as $document) {
                if ($document->exists()) {
                    $cursoData = $document->data();
                    $cursoData['id'] = $document->id();
                    $cursos[] = $cursoData;
                }
            }
            
            return view('home', compact('cursos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar cursos para home: ' . $e->getMessage());
            // Em caso de erro, mostrar a home com array vazio
            return view('home', ['cursos' => []]);
        }
    }
}