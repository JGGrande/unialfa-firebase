<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(){}

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
        $u = User::where('email', $credentials['email'])->first();
        if (!$u || !Hash::check($credentials['senha'], $u->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
        session(['user' => ['nome' => $u->name, 'email' => $u->email, 'perfil' => $u->perfil ?? 'aluno'], 'user_id' => (string) $u->id]);
        return redirect('/painel');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'senha' => 'required|string|min:6|confirmed',
        ]);
        $u = new User();
        $u->name = $data['nome'];
        $u->email = $data['email'];
        $u->password = Hash::make($data['senha']);
        $u->perfil = 'aluno';
        $u->save();
        session(['user' => ['nome' => $u->name, 'email' => $u->email, 'perfil' => $u->perfil], 'user_id' => (string) $u->id]);
        return redirect('/painel')->with('success', 'Registration successful.');
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
                'uid' => 'required|string',
                'nome' => 'required|string',
                'email' => 'required|email',
                'photo_url' => 'nullable|string',
                'provider' => 'required|string'
            ]);

            $u = User::where('email', $userData['email'])->first();

            if ($u) {
                $updates = [];
                if (empty($u->google_uid)) $updates['google_uid'] = $userData['uid'];
                if (empty($u->provider)) $updates['provider'] = $userData['provider'];
                if (empty($u->photo_url) && !empty($userData['photo_url'])) $updates['photo_url'] = $userData['photo_url'];
                if (!empty($updates)) {
                    // Ensure these columns exist; if not, ignore silently
                    foreach ($updates as $k => $v) {
                        $u->{$k} = $v;
                    }
                    $u->save();
                }
            } else {
                $u = new User();
                $u->name = $userData['nome'];
                $u->email = $userData['email'];
                $u->password = Hash::make(uniqid('google_', true)); // placeholder password
                $u->perfil = 'aluno';
                // Optional columns if present in users table
                if (property_exists($u, 'google_uid')) $u->google_uid = $userData['uid'];
                if (property_exists($u, 'photo_url')) $u->photo_url = $userData['photo_url'] ?? null;
                if (property_exists($u, 'provider')) $u->provider = $userData['provider'];
                $u->save();
            }

            session(['user' => ['nome' => $u->name, 'email' => $u->email, 'perfil' => $u->perfil ?? 'aluno'], 'user_id' => (string) $u->id]);

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
