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
        // URL para obter as páginas associadas ao token
        $url1 = "https://graph.facebook.com/me/accounts?access_token={$this->accessToken}";

        // Faz a requisição para obter as páginas do Facebook associadas ao token
        $response1 = $this->client->get($url1);

        // Decodifica a resposta JSON
        $data1 = json_decode($response1->getBody()->getContents(), true);

        // Verifica se a resposta contém páginas
        if (isset($data1['data'])) {
            // Itera sobre as páginas e busca o ID da conta do Instagram associada
            foreach ($data1['data'] as $page) {
                if (isset($page['instagram_business_account']['id'])) {
                    // Pegamos o ID da conta do Instagram
                    $instagramAccountId = $page['instagram_business_account']['id'];

                    // Agora vamos buscar as postagens dessa conta do Instagram
                    $url2 = "https://graph.facebook.com/v21.0/{$instagramAccountId}/media";
                    $queryParams = [
                        'fields' => 'id,comments_count,caption,media_type,media_url,thumbnail_url,permalink',
                        'limit' => 100,  // Limita a 100 postagens
                        'access_token' => $this->accessToken,
                    ];

                    // Faz a requisição para obter as postagens
                    $response2 = $this->client->get($url2, [
                        'query' => $queryParams,
                    ]);

                    // Decodifica a resposta JSON
                    $data2 = json_decode($response2->getBody()->getContents(), true);

                    // Verifica se a resposta contém postagens
                    if (isset($data2['data'])) {
                        return $data2['data']; // Retorna as postagens da conta do Instagram
                    }
                }
            }
        }
        // Caso não encontre a conta do Instagram ou postagens
        return []; // Retorna um array vazio
    }



    public function getComments($mediaId)
    {
        $url = "https://graph.facebook.com/v21.0/{$mediaId}/comments";
        $allComments = [];

        // Definindo os parâmetros de consulta iniciais (primeira página)
        $queryParams = [
            'fields' => 'id,username,text',  // Campos dos comentários
            'access_token' => $this->accessToken,
            'limit' => 50, // Limitar a 50 comentários por requisição
        ];

        do {
            // Faz a requisição para a API
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

            // Adiciona os comentários da página atual à lista
            $allComments = array_merge($allComments, $data['data']);

            // Verifica se há uma próxima página de comentários
            $nextPageUrl = $data['paging']['next'] ?? null;

            // Se houver uma próxima página, atualiza a URL para a próxima requisição
            if ($nextPageUrl) {
                $url = $nextPageUrl; // Atualiza o URL para continuar a busca
            }

        } while ($nextPageUrl);  // Continue a requisição enquanto houver a próxima página

        return $allComments; // Retorna todos os comentários encontrados
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
