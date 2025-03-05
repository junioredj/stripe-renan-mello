<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/css/default.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
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
            color: #f5f5f5 !important;
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


    <title>Entrar</title>
</head>

<body>
    <div class="container-fluid p-0 body-content d-flex justify-content-center vh-100">

        <div class="container align-self-center">

            <div class="row d-flex justify-content-center">
                <div class="col-md-6 p-5" style="border-radius: 15px; border: solid 1px white">


                    <h3 class="py-3">Resetar senha</h3>

                    <form action="{{ route('reset-password') }}" method="POST">
                        @csrf

                        <input type="text" name="token" value="{{ $_REQUEST['token'] }}" hidden>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Nova senha</label>
                            <input type="password" name="password" class="form-control input" id="senha"
                                placeholder="Digite sua senha" required>
                            @if ($errors->has('password'))
                                <small class="error">Defina uma senha com no mínimo 6 digitos</small>
                            @elseif($errors->has('token'))
                                <small class="error">Erro ao redefinir senha</small>
                            @endif
                        </div>
                        <div>


                            <div class="d-flex justify-content-end py-3">
                                <button type="submit" class="btn btn-primary">Resetar senha</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
