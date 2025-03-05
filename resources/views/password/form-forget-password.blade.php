<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Login</title>
    <style>
        /* Estilo do corpo da página */
        body {
            background-color: #1e1e2f;
            color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }

        /* Container do formulário de login */
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #2a2d3e;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .form-control {
            background-color: #33394c;
            border: 1px solid #444d64;
            color: #f5f5f5;
            font-size: 1rem;
            border-radius: 8px;
            padding: 15px;
        }

        .form-control:focus {
            background-color: #3c404e;
            border-color: #f39c12;
        }

        .form-outline {
            margin-bottom: 20px;
        }

        /* Estilo dos botões */
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Estilo dos links */
        a {
            text-decoration: none;
            color: #f39c12;
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        a:hover {
            color: #fff;
        }

        /* Estilo de mensagens de erro e sucesso */
        .alert {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        /* Responsividade */
        @media (max-width: 767px) {
            .login-container {
                padding: 20px;
                width: 80%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Recupere sua senha</h2>
            @if(Session::has('erro'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('erro') }}
                </div>
            @elseif(Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <form method="POST" action="{{route('esqueceu-senha')}}">
                @csrf

                <!-- Input de E-mail -->
                <div class="form-outline">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Informe seu e-mail</label>
                </div>


                <!-- Botão de login -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-block mb-4">Recuperar</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
