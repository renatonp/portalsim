<div class="modal fade" id="modal_login" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lock"></i> Entre na sua conta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form name="formularioLogin" action="{{ route('valida_cpf_login') }}" id="frmCpf" method="post">
                    @csrf
                    
                    <label for="cpf_login"><h4 class="h6">Digite aqui seu CPF/CNPJ:</h4></label>
                    <div class="form-group">
                        <input type="text" id="cpf_login" name="cpf_login" class="form-control">
                    </div>

                    <button class="btn btn-danger" id="valida_cpf_login" type="submit">
                        <i class="fa fa-lock"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>