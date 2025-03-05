{{-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/dafault.css">
    <script type="text/javascript" src="/js/java.js"></script>
    <title>Dashboard</title>
</head> --}}
@extends('layout')
@section('conteudo')
    @if (Session::has('msg_cadastro'))
        <script>
            Swal.fire(
                'Usuário cadastrado!',
                '',
                'success'
            )
        </script>
    @elseif(Session::has('error_cadastro'))
        <script>
            Swal.fire(
                'Erro ao cadastrar usuário',
                '',
                'error'
            )
        </script>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.register') }}" method="POST">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" name="nome" class="form-control" placeholder="Digite o nome do usuário"
                                aria-label="Nome do usuário" aria-describedby="basic-addon1" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Digite o e-mail">
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" name="conta" class="form-control" placeholder="Digite o número da conta"
                                required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="date" name="expiracao" class="form-control"
                                placeholder="Digite a data de expiração" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn w-100 btn-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Conteúdo principal -->
    <div class="container-fluid p-3">
        <button class="btn btn-lg text-white" style="background-color: #2a2d3e" data-bs-toggle="modal"
            data-bs-target="#exampleModal"><i class="fa-solid fa-user-plus"></i><span> Novo Usuário</span></button>

        <h1 class="mb-4">Dashboard</h1>

        <div class="card-container mb-5">
            <div class="card-box">
                <i class="fa-solid fa-users"></i>
                <h3 class="my-3">Usuários Ativos</h3>
                <p class="display-6">{{ $user_ativos ?? 0 }}</p>
            </div>
            <div class="card-box">
                <i class="fa-solid fa-users-slash"></i>
                <h3 class="my-3">Usuários Inativos</h3>
                <p class="display-6">{{ $user_inativos ?? 0 }}</p>
            </div>

            <!-- Novo Card de Novos Clientes do Mês -->
            <div class="card-box">
                <i class="fa-solid fa-calendar-check"></i>
                <h3 class="my-3">Novos Clientes (Mês Atual)</h3>
                <p class="display-6">{{ $new_clientes ?? 0 }}</p>
                <!-- Exemplo de quantidade, substitua dinamicamente -->
            </div>

            <div class="card-box">
                <i class="fa-solid fa-calendar-check"></i>
                <h3 class="my-3">Valor Gerenciado(Cliente ativos)</h3>
                <p class="display-6">${{ number_format($saldo, 2, ",", ".") ?? 0 }}</p>
                <!-- Exemplo de quantidade, substitua dinamicamente -->
            </div>
        </div>


        <div class="form-group input-group mb-3" id="input_consulta">
            <span class="input-group-text bg-dark text-light border-0"><i class="fa-solid fa-search"></i></span>
            <input name="consulta" id="txt_consulta" placeholder="Consultar" type="text" class="form-control"
                onkeyup="myFunction()">
        </div>



        <div class="table-responsive" style="min-width: 250px;">
            <table class="table table-hover " id="tabela">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Conta</th>
                        <th>E-mail</th>
                        <th>Situação</th>
                        <th>Expiração</th>
                        <th>Ult. Autenticação</th>
                        <th>Saldo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($users as $user)
                    <tr>
                        <td><b>{{ $user->name }}</b></td>
                        <td>{{ $user->account_mt5 }}</td>
                        <td>{{ $user->email }}</td>
                        @if (now() > $user->end)
                            <td>Inativo</td>
                        @else
                            <td>Ativo</td>
                        @endif


                        <td>{{ date('d/m/Y', strtotime($user->end)) }}</td>
                        @if (isset($user->last_auth_mt5))
                            <td>{{ date('d/m/Y', strtotime($user->last_auth_mt5)) }}</td>
                        @else
                            <td>N/A</td>
                        @endif

                        <td>{{ number_format($user->saldo, 2, ",", ".") ?? 0 }} {{ $user->moeda??"" }}</td>

                        <td>
                            <div class="d-flex justify-content-around ">
                                <i onclick="preencherFormulario(this)" style="cursor: pointer; color: dodgerblue;"
                                    nome="{{ $user->name }}" id="{{ $user->id }}" conta="{{ $user->account_mt5 }}"
                                    email="{{ $user->email }}" expiracao="{{ date('Y-m-d', strtotime($user->end)) }}"
                                    data-bs-toggle="modal" data-bs-target="#edit-user"
                                    class="informacao fa-solid fa-circle-info"></i>

                                <a href="delete/licenca/{{ $user->id }}"
                                    onclick="return confirm('Tem certeza que deseja excluir?')" style="color: red;"><i
                                        class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                </tbody>
            </table>
            {{ $users->withQueryString()->links('vendor.pagination.bootstrap-5') }}

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atualizar usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update') }}" method="POST">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="text" id="nome" name="nome" class="form-control"
                                placeholder="Digite o nome do usuário" aria-label="Username"
                                aria-describedby="basic-addon1">
                        </div>



                        <input type="text" id="id" name="id" hidden>
                        <div class="input-group mb-3">
                            <input type="number" id="conta" name="conta" class="form-control"
                                placeholder="Digite o número da conta">
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" id="email_input" name="email" class="form-control"
                                placeholder="Digite o e-mail">
                        </div>

                        <div class="input-group mb-3">
                            <input type="date" id="expiracao" name="expiracao" class="form-control"
                                placeholder="Digite a data de expiração">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn w-100 btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>





    <script>
        function preencherFormulario(elemento) {
            var nome = (elemento.getAttribute('nome'));
            var conta = (elemento.getAttribute('conta'));
            var expiracao = (elemento.getAttribute('expiracao'));
            var id = (elemento.getAttribute('id'));
            var email_input = elemento.getAttribute('email')

            document.getElementById('nome').value = nome;
            document.getElementById('conta').value = conta;
            document.getElementById('expiracao').value = expiracao;
            document.getElementById('id').value = id;
            document.getElementById('email_input').value = email_input;
        }
    </script>


@endsection
