<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sorteador de Comentários</title>
    <style>
        /* Contêiner principal */
        .container {
            display: flex; /* Organiza os itens lado a lado */
            gap: 20px; /* Espaço entre o card e a seção de comentários */
            margin-top: 20px;
            max-width: 1200px;
            width: 100%;
        }

        /* Card do post */
        .card {
            flex: 1; /* O card ocupa 1 parte do espaço */
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Garante que o conteúdo extra não extrapole */
        }

        .card img {
            width: 100%; /* Imagem ocupa toda a largura do card */
            height: auto;
        }

        .card-content {
            padding: 15px;
        }

        .card-content p {
            margin: 10px 0;
            line-height: 1.5;
            color: #333;
        }

        .card-content a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .card-content a:hover {
            background-color: #0056b3;
        }

        /* Seção de comentários */
        .comments-section {
            flex: 2; /* A seção de comentários ocupa 2 partes do espaço */
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .comments-section #comments .comment {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fefefe;
        }

        #raffle-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #raffle-btn:hover {
            background-color: #218838;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Empilha os elementos no mobile */
            }

            .card, .comments-section {
                flex: none; /* Remove a proporção no mobile */
                width: 100%; /* Ocupa 100% da largura */
            }
        }

    </style>
</head>
<body>

<h2>Comentários</h2>

<!-- Container para os comentários e sorteados -->
<div class="container">
    <!-- Card do post -->
    <div class="card">
        <img src="{{ $post['media_url'] }}" alt="Imagem do Post">
        <div class="card-content">
            <p><strong>ID:</strong> {{ $post['id'] }}</p>
            <p><strong>Total Comentários:</strong> {{ $post['comments_count'] }}</p>
            <!-- Limitar a legenda a 3 linhas -->
            <p class="caption"><strong>Legenda:</strong> {{ $post['caption'] }}</p>
            <a href="{{ url('/posts/' . $post['id']) }}">Ver Comentários</a>
        </div>
    </div>

    <!-- Div que contém os comentários -->
    <div class="comments-section">
        <div id="comments">
            @foreach ($comments as $comment)
                <div class="comment" data-username="{{ $comment['username'] }}">
                    <strong>{{ $comment['username'] }}:</strong> {{ $comment['text'] }}
                </div>
            @endforeach
        </div>

        <!-- Botão para sortear comentários -->
        <button id="raffle-btn">Sortear Comentários</button>

        <!-- Div que irá exibir os comentários sorteados -->
        <div id="raffled-comments"></div>
    </div>
</div>

<script>
    document.getElementById('raffle-btn').addEventListener('click', function () {
        let comments = [];
        document.querySelectorAll('.comment').forEach(function (comment) {
            comments.push({
                username: comment.dataset.username,
                text: comment.textContent
            });
        });

        fetch('/raffle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ comments: comments })
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    let raffledComments = document.getElementById('raffled-comments');
                    raffledComments.innerHTML = ''; // Limpar os sorteados anteriores
                    data.forEach(comment => {
                        raffledComments.innerHTML += `<p><strong>${comment.username}:</strong> ${comment.text}</p>`;
                    });
                }
            });
    });
</script>

</body>
</html>

