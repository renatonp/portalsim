// jQuery(document).ready(function () {
// Guarda os valores iniciais 

$("#phone").mask("(00)0000-00009");
$("#celphone").mask("(00)00000-0009");

var infoCttEnviada = false;

var cgm_email = $("#email").val();
var cgm_orgEmi = $("#phone").val();
var cgm_dtEmiss = $("#celphone").val();

$("#btn_altera_info_ct").click(function () {
    // verifica qual a ação está sendo feita (Alter/Cancelar)
    if ($("#btn_altera_info_ct").val() == 1) {
        // Habilita os campos para alteração
        $("#btn_altera_info_ct").val(2);
        $("#btn_altera_info_ct").html("CANCELAR ALTERAÇÕES");
        if ($("#email").val() != "" && $("#solicitacaoEmail").val() == "") {
            $("#email").prop('readonly', false);
        }
        $("#phone").prop('readonly', false);
        $("#celphone").prop('readonly', false);

        $("#btn_gravar_info_ct").prop('disabled', false);

    }
    else {
        // desabilita os campos e restaura os valores iniciais 
        $("#btn_altera_info_ct").val(1);
        $("#btn_altera_info_ct").html("ALTERAR DADOS");

        // Restaura valores iniciais
        $("#email").val(cgm_email);
        $("#phone").val(cgm_orgEmi);
        $("#celphone").val(cgm_dtEmiss);

        // Desabilita campos
        $("#email").prop('readonly', true);
        $("#phone").prop('readonly', true);
        $("#celphone").prop('readonly', true);

        $("#btn_gravar_info_ct").prop('disabled', true);
    }
});


$("#btn_gravar_info_ct").click(function () {

    if(!infoCttEnviada){
        infoCttEnviada = true;
        $("#btn_gravar_info_ct").prop('disabled', true);
            
        if ($("#email").val() != "") {
            if (!isValidEmailAddress($("#email").val())) {
                alert("Por favor Informe um e-mail válido");
                infoCttEnviada = false;
                $("#btn_gravar_info_ct").prop('disabled', false);
                return false;
            }
        }
        else {
            // E-Mail vazio
            if ($("#email").val() != $("#emailOld").val()) {
                alert("Por favor Informe um e-mail válido");
                infoCttEnviada = false;
                $("#btn_gravar_info_ct").prop('disabled', false);                
                return false;
            }
        }

        $("#mdlAguarde").modal('toggle');
        $("#infoContato").submit();
    }
    else{
        console.log("Segundo envio");
    }
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    // alert( pattern.test(emailAddress) );
    return pattern.test(emailAddress);
};

// });