<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Sorteador de Comentários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #d7d6d6;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        /* Container para card e div de comentários lado a lado */
        .container {
            display: flex;
            flex-direction: row; /* Layout em linha */
            align-items: flex-start; /* Alinha os itens no topo */
            justify-content: center;
            margin-top: 10px;
        }

        /* Estilo do card */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 50px; /* Distância do card para a div de comentários */
            width: 250px;
            height: 300px; /* Altura fixa */
            overflow: hidden;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 150px; /* Ajusta a altura da imagem dentro do card */
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
            height: calc(100% - 150px); /* Faz o conteúdo do card ocupar o restante da altura */
            overflow-y: auto;
        }

        .card-content p {
            margin: 8px 0;
            color: #555;
        }

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

        /* Estilo da div que contém os comentários */
        #comments {
            width: 100%;
            max-width: 800px;
            height: 300px; /* Altura igual ao card */
            overflow-y: scroll; /* Permite rolar para baixo */
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Estilo de cada comentário */
        .comment {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .comment:last-child {
            border-bottom: none;
        }

        /* Estilo do botão de sorteio */
        #raffle-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #raffle-btn:hover {
            background-color: #0056b3;
        }

        /* Estilo da div de comentários sorteados */
        #raffled-comments {
            width: 80%;
            max-width: 800px;
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #raffled-comments p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<h2>Comentários</h2>

<!-- Container para o card e comentários -->
<div class="container">
    <!-- Card do Post -->
    <div class="card">
        <img src="{{ $post['media_url'] }}" alt="Imagem do Post">
        <div class="card-content">
            <!--<p><strong>ID:</strong> {{ $post['id'] }}</p> -->
            <p><strong>Total Comentários:</strong> {{ $post['comments_count'] }}</p>
            <!-- Limitar a legenda a 3 linhas -->
            <p class="caption"><strong>Legenda:</strong> {{ $post['caption'] }}</p>
            <a href="{{ url('/posts/' . $post['id']) }}">Ver Comentários</a>
        </div>
    </div>

    <!-- Div que contém todos os comentários -->
    <div id="comments">
        <h3>Comentários</h3>
        <?php $x = 0; ?>
        @foreach ($comments as $comment)
            <div class="comment" data-username="{{ $comment['username'] }}">
                <strong>{{ $comment['username'] }}:</strong> {{ $comment['text'] }}
            </div>
                <?php $x++; ?>
        @endforeach
        <p>{{$x}}</p>
    </div>
</div>

<!-- Botão para sortear comentários centralizado -->
<div style="display: flex; justify-content: center; margin-top: 20px;">
    <button id="raffle-btn">Sortear Comentários</button>
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

        // Exibir o SweetAlert2 com contagem regressiva
        let timerInterval;
        Swal.fire({
            title: 'Realizando o sorteio!',
            html: 'O resultado será exibido em <b></b> segundos.',
            timer: 5000, // Tempo em milissegundos (5 segundos aqui)
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const b = Swal.getHtmlContainer().querySelector('b');
                timerInterval = setInterval(() => {
                    b.textContent = Math.ceil(Swal.getTimerLeft() / 1000); // Exibe os segundos restantes
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then(() => {
            // Após o timer, enviar a requisição para realizar o sorteio
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
                        Swal.fire('Erro', data.error, 'error'); // Exibe erro no SweetAlert2
                    } else {
                        // Construir o resultado do sorteio
                        let resultHtml = '';
                        data.forEach(comment => {
                            // Remover o texto do usuário antes dos ":"
                            const textParts = comment.text.split(':'); // Divide o texto no ":"
                            const message = textParts.length > 1 ? textParts[1].trim() : comment.text; // Pega a parte após o ":"

                            resultHtml += `
                            <p><strong>A pessoa sorteada foi: ${comment.username}</strong></p>
                            <p>Comentário: ${message}</p>
                        `;
                        });

                        // Exibir o resultado no SweetAlert2
                        Swal.fire({
                            title: 'Sorteio Concluído!',
                            html: resultHtml,
                            icon: 'success',
                            confirmButtonText: 'Fechar'
                        });
                    }
                });
        });
    });
</script>

</body>
</html>
