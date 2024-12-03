<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\InstagramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstagramController extends Controller
{
    protected $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    // Exibir todas as postagens
    public function index()
    {
        Auth::user();
        $posts = $this->instagramService->getPosts();
        return view('index', compact('posts'));
    }

    // Exibir os comentários de uma postagem
    public function show($mediaId)
    {
        Auth::user();
        $post = $this->instagramService->getPost($mediaId);
        $comments = $this->instagramService->getComments($mediaId);
        return view('show')->with(['post' => $post, 'comments' => $comments]);
    }

    // Sortear 5 comentários aleatórios
    public function raffleComments(Request $request)
    {
        $comments = $request->comments;
        $uniqueUsers = collect($comments)->unique('username')->values()->all();

        // Verifica se há ao menos 5 usuários únicos
        if (count($uniqueUsers) >= 1) {
            $raffledComments = collect($uniqueUsers)->random(1);
            return response()->json($raffledComments);
        }

        return response()->json(['error' => 'Não há comentários suficientes'], 400);
    }

    public function logar(Request $request)
    {
        // Validando os dados da requisição
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Buscando o usuário no banco de dados pelo username
        $user = User::where('username', $request->username)->first();

        // Verificando se o usuário existe e a senha está correta
        if ($user && Hash::check($request->password, $user->password)) {
            // Autenticando o usuário manualmente
            Auth::login($user);

            // Caso o login seja bem-sucedido, redireciona o usuário para a página desejada
            return redirect()->route('index');  // ou para qualquer outra página desejada
        }

        // Caso as credenciais estejam incorretas, retorna erro
        return back()->withErrors([
            'login_error' => 'Nome de usuário ou senha incorretos.'
        ]);

    }

    public function userManager(){
        Auth::user();
        return view ('user-manager');
    }

    public function logout(){
        Auth::logout(); // Faz o logout do usuário
        return redirect('/login'); // Redireciona para a página de login após o logout
    }

}

