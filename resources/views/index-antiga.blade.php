@extends('layout')
@section('conteudo')
    <div class="container">
        <div class="d-flex py-3 justify-content-around">
            <div style="width: 300px; height: 250px;" class=" border border-radius  d-flex justify-content-center align-items-center">
                <div class="row d-flex text-center">
                    <div class="col-12 py-2">
                        <strong> Usuários ativos</strong>
                    </div>
                    <div class="col-12 py-2"><i class="fa-solid fa-users"></i></div>
                    <div class="col-12 py-3">{{$user_ativos}}</div>
                </div>
            </div>
            <div style="width: 300px; height: 250px;" class=" border border-radius  d-flex justify-content-center align-items-center">
                <div class="row d-flex text-center">
                    <div class="col-12 py-2">
                        <strong> Usuários inativos</strong>
                    </div>
                    <div class="col-12 py-2"><i class="fa-solid fa-users"></i></div>
                    <div class="col-12 py-3">{{$user_inativos}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="form-group input-group my-2">
            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            <input name="consulta" id="txt_consulta" placeholder="Consultar" type="text" class="form-control" onkeyup="myFunction()">
        </div>

        <table id="tabela" class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Conta</th>
                    <th>Situação</th>
                    <th>Expiração</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><b>{{$user->nome}}</b></td>
                        <td>{{$user->conta}}</td>
                        <td class="inativo">Ativo</td>
                        <td>{{date( 'd/m/Y', strtotime($user->expiracao))}}</td>
                        <td  class="d-flex justify-content-around"> <div><i onclick="preencherFormulario(this)" style="cursor: pointer; color: dodgerblue;" nome="{{$user->nome}}" id="{{$user->id}}" conta="{{$user->conta}}" expiracao="{{date( 'Y-m-d', strtotime($user->expiracao))}}" data-bs-toggle="modal" data-bs-target="#edit-user" class="informacao fa-solid fa-circle-info"></i></div> <a href="delete/licenca/{{$user->id}}" onclick="return confirm('Tem certeza que deseja excluir?')" style="color: red;"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="edit-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Atualizar usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('user.update')}}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome do usuário" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <input type="text" id="id" name="id" hidden>
                    <div class="input-group mb-3">
                        <input type="number" id="conta" name="conta" class="form-control" placeholder="Digite o número da conta">
                    </div>

                    <div class="input-group mb-3">
                        <input type="date" id="expiracao" name="expiracao" class="form-control" placeholder="Digite a data de expiração">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button  type="submit" class="btn w-100 btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
        </div>
    </div>

    @if(Session::has('msg'))

        <script>
            Swal.fire(
                '{{session()->get("msg")}}',
                '',
                'success'
                )
        </script>
    @elseif(Session::has('error'))
    <script>
        Swal.fire(
            '{{session()->get("error")}}',
            '',
            'error'
            )
    </script>
    @endif

    <script>


        function preencherFormulario(elemento)
        {
            var nome = (elemento.getAttribute('nome'));
            var conta = (elemento.getAttribute('conta'));
            var expiracao = (elemento.getAttribute('expiracao'));
            var id = (elemento.getAttribute('id'));

            document.getElementById('nome').value = nome;
            document.getElementById('conta').value = conta;
            document.getElementById('expiracao').value = expiracao;
            document.getElementById('id').value = id;
        }
    </script>
@endsection
