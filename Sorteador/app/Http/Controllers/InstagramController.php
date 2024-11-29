<?php

namespace App\Http\Controllers;


use App\Services\InstagramService;
use Illuminate\Http\Request;

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
        $posts = $this->instagramService->getPosts();
        return view('index', compact('posts'));
    }

    // Exibir os comentários de uma postagem
    public function show($mediaId)
    {
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


}

