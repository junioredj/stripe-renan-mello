@extends('layout')

@section('conteudo')
    <div class="container ">


        @if (count($licencas['licencas']) > 0)
            <h1 class="text-center mb-5">Licenças</h1>


            <div class="d-flex  flex-wrap">
                @foreach ($licencas['licencas'] as $key => $licenca)
                    <div class="card-licencas p-3 m-2">
                        <div><img style="width: 100%; border-radius: 15px;"
                                src="{{ $licencas['produtos'][$key]->images[0]??"https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/1280px-Placeholder_view_vector.svg.png" }}"
                                alt="Imagem do robô"></div>
                        <div class="text-center mt-3">
                            <strong>{{ $licenca->descricao_licenca ?? '' }}</strong>
                        </div>
                        <div class="mt-3 d-flex">
                            <b>Conta:</b>
                            @if (isset($licenca->account_mt5) && $licenca->account_mt5 != 0)
                                <div class="mx-2">{{ $licenca->account_mt5 }}</div>
                            @else
                                <div class="mx-2" style="color: gray;">Cadastre sua conta</div>
                            @endif

                            <div>
                                <?php

                                $hoje = new DateTime(); // Data atual
                                $dataLicenca = new DateTime(date('Y-m-d H:i:s', strtotime('+1 days', strtotime($licenca->update_account))));
                                $diferenca = $hoje->diff($dataLicenca);

                                $mensagem_expiracao = '';
                                if ($diferenca->days > 0) {
                                    $mensagem_expiracao = $diferenca->days . ' dia(s) e ' . $diferenca->h . ':' . $diferenca->i;
                                } else {
                                    $mensagem_expiracao = $diferenca->h . ':' . $diferenca->i;
                                }

                                ?>
                                @if (date('Y-m-d') > date('Y-m-d', strtotime('+1 days', strtotime($licenca->update_account))))
                                    <i style="cursor: pointer" valor_id="{{ $licenca->id }}"
                                        nome_robo = "{{ $licenca->descricao_licenca }}" conta="{{ $licenca->account_mt5 }}"
                                        onclick="preencherFormulario(this)" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" class="fa-solid fa-pen-to-square"></i>
                                @else
                                    <i style="cursor: pointer; color: red;"
                                        title="Você deve esperar {{ $mensagem_expiracao }} minutos para cumprir o prazo de 24 horas para atualizar novamente"
                                        class="fa-solid fa-pen-to-square"></i>
                                    <span id="msg_account" style="color: red; display: none;">Você alterou sua conta
                                        {{ date('d/m/Y H:i:s', strtotime($licenca->update_account)) }} deve esperar 24 horas
                                        para atualizar novamente</span>
                                @endif

                            </div>
                        </div>

                        <div class="mt-2">
                            <strong>Expiração: </strong>{{ date('d/m/Y ', strtotime($licenca->end)) }}
                        </div>

                    </div>
                @endforeach
        @else
            <div class="text-center vh-100 d-flex justify-content-center align-items-center">
                <h2>Não licenças cadastradas</h2>
            </div>
        @endif
    </div>

    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar conta Metatrader</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.account') }}" method="POST">
                        @csrf

                        <input type="text" hidden name="id_update" id="id_update">
                        <div class="input-group mb-3">
                            <input type="text" name="nome" id="nome_update" class="form-control"
                                placeholder="Digite uma descrição" aria-label="Identificador da conta"
                                aria-describedby="basic-addon1" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" id="conta_update" name="conta" class="form-control"
                                placeholder="Digite o número da conta" required>
                        </div>

                        <p class="text-warning mt-3">
                            <strong>Observação:</strong> O número da conta só poderá ser modificado após 24 horas.
                            Certifique-se de
                            inserir as informações corretamente.
                        </p>


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

    <script>
        function preencherFormulario(elemento) {


            var input_id = document.getElementById('id_update');
            var input_nome = document.getElementById('nome_update');
            var input_conta = document.getElementById('conta_update');

            input_id.value = elemento.getAttribute('valor_id');
            input_nome.value = elemento.getAttribute('nome_robo');
            input_conta.value = elemento.getAttribute('conta');

        }

        function mostrarErro() {
            document.getElementById('msg_account').style.display = 'block';
        }
    </script>
@endsection
