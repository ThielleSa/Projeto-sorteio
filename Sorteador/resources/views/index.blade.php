<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sorteador de Comentários</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            width: 220px;
            overflow: hidden;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;

            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-content p {
            margin: 8px 0;
            color: #555;
        }

        /* Limitar a legenda (caption) a 3 linhas com elipse */
        .card-content .caption {
            display: -webkit-box;
            -webkit-line-clamp: 3;  /* Limita a 3 linhas */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #333;
        }

        .card-content a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .card-content a:hover {
            text-decoration: underline;
        }
        h1{
            margin-left: 90px;
        }
    </style>
</head>
<body>
<h1>Postagens do instagram</h1>
<div class="container">
    @foreach($posts as $post)
        <div class="card">
            <a href="{{ url('/posts/' . $post['id']) }}"><img src="{{ $post['media_url'] }}" alt="Imagem do Post"></a>
            <div class="card-content">
                <!-- <p><strong>ID:</strong> {{ $post['id'] }}</p> -->
                <p><strong>Total Comentários:</strong> {{ $post['comments_count'] }}</p>
                <!-- Limitar a legenda a 3 linhas -->
                <p class="caption"><strong>Legenda:</strong> {{ $post['caption'] }}</p>
                <a href="{{ url('/posts/' . $post['id']) }}">Ver Comentários</a>
            </div>
        </div>
    @endforeach
</div>

</body>
</html>
