<?php

namespace App\Services;

use GuzzleHttp\Client;

class InstagramService
{
    protected $client;
    protected $accessToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->accessToken = env('INSTAGRAM_ACCESS_TOKEN'); // Coloque seu token aqui
    }

    // Buscar postagens do Instagram
    public function getPosts()
    {
        $response = $this->client->get('https://graph.facebook.com/v21.0//media', [
            'query' => [
                'fields' => 'id,comments_count,caption,media_type,media_url,thumbnail_url,permalink',
                'access_token' => $this->accessToken,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data']; // Retorna as postagens
    }

    // Buscar todos os comentários de uma postagem sem limitação
    public function getComments2($mediaId)
    {
        $url = "https://graph.facebook.com/v21.0/{$mediaId}/comments";
        $allComments = [];
        $nextPage = null;

        // Vamos buscar todos os comentários sem limitação de páginas
        do {
            // Faz a requisição para pegar os comentários
            $queryParams = [
                'fields' => 'id,username,text',  // Campos dos comentários
                'limit' => 100,
                'access_token' => $this->accessToken,
            ];

            // Se houver um cursor "after" (para paginação), adicionamos no query
            if ($nextPage) {
                $queryParams['after'] = $nextPage;
            }

            $response = $this->client->get($url, [
                'query' => $queryParams,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Adiciona os comentários recebidos à lista
            $allComments = array_merge($allComments, $data['data']);

            // Verifica se há mais comentários (se houver "next" na resposta)
            $nextPage = $data['paging']['cursors']['after'] ?? null;

        } while ($nextPage); // Continua buscando enquanto houver uma próxima página

        return $allComments;
    }

    public function getComments($mediaId)
    {
        $url = "https://graph.facebook.com/v21.0/{$mediaId}/comments";
        $allComments = [];
        $nextPage = null;

        do {
            $queryParams = [
                'fields' => 'id,username,text',  // Campos dos comentários
                'limit' => 100, // Solicita até 100 comentários por página
                'access_token' => $this->accessToken,
            ];

            if ($nextPage) {
                $queryParams['after'] = $nextPage;
            }

            $response = $this->client->get($url, [
                'query' => $queryParams,
            ]);

            // Verifica se a resposta foi bem-sucedida
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Erro ao buscar comentários: ' . $response->getReasonPhrase());
            }

            $data = json_decode($response->getBody()->getContents(), true);

            // Verifica se os dados foram retornados corretamente
            if (!isset($data['data'])) {
                throw new \Exception('Erro ao buscar comentários: Resposta inválida da API.');
            }

            // Adiciona os comentários à lista
            $allComments = array_merge($allComments, $data['data']);

            // Atualiza o cursor para a próxima página
            $nextPage = $data['paging']['cursors']['after'] ?? null;

        } while ($nextPage);

        return $allComments;
    }


    public function getPost($mediaId) {
        $response = $this->client->get("https://graph.facebook.com/v21.0/{$mediaId}", [
            'query' => [
                'fields' => 'id,comments_count,caption,media_type,media_url,thumbnail_url,permalink',
                'access_token' => $this->accessToken,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data; // Retorna as postagens
    }
}
