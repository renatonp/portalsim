// jQuery(document).ready(function () {
// Guarda os valores iniciais 

$("#dtEmiss").mask("00/00/0000");
$("#pis").mask("000.0000.00-0");

var infoAddEnviada = false;

var cgm_identidade = $("#identidade").val();
var cgm_orgEmi = $("#orgEmi").val();
var cgm_dtEmiss = $("#dtEmiss").val();
var cgm_pis = $("#pis").val();
var cgm_profissoes = $("#profissoes").val();
var cgm_local_trabalho = $("#local_trabalho").val();
var cgm_renda = $("#renda").val();

$("#btn_altera_info_ad").click(function () {
    // verifica qual a ação está sendo feita (Alter/Cancelar)
    if ($("#btn_altera_info_ad").val() == 1) {
        // Habilita os campos para alteração
        $("#btn_altera_info_ad").val(2);
        $("#btn_altera_info_ad").html("CANCELAR ALTERAÇÕES");
        // $("#identidade").prop('readonly', false);
        // $("#orgEmi").prop('readonly', false);
        // $("#dtEmiss").prop('readonly', false);
        // $("#pis").prop('readonly', false);
        // $("#profissoes").prop('readonly', false);
        // $("#local_trabalho").prop('readonly', false);
        $("#renda").prop('readonly', false);

        $("#btn_gravar_info_ad").prop('disabled', false);

    }
    else {
        // desabilita os campos e restaura os valores iniciais 
        $("#btn_altera_info_ad").val(1);
        $("#btn_altera_info_ad").html("ALTERAR DADOS");

        // Restaura valores iniciais
        // $("#identidade").val(cgm_identidade);
        // $("#orgEmi").val(cgm_orgEmi);
        // $("#dtEmiss").val(cgm_dtEmiss);
        // $("#pis").val(cgm_pis);
        // $("#profissoes").val(cgm_profissoes);
        // $("#local_trabalho").val(cgm_local_trabalho);
        $("#renda").masked(cgm_renda);

        // Desabilita campos
        $("#identidade").prop('readonly', true);
        $("#orgEmi").prop('readonly', true);
        $("#dtEmiss").prop('readonly', true);
        $("#pis").prop('readonly', true);
        $("#profissoes").prop('readonly', true);
        $("#local_trabalho").prop('readonly', true);
        $("#renda").prop('readonly', true);

        $("#btn_gravar_info_ad").prop('disabled', true);
    }
});


$("#btn_gravar_info_ad").click(function () {
    
    if(!infoAddEnviada){
        infoAddEnviada = true;
        $("#btn_gravar_info_ad").prop('disabled', true);
                
        // if ($("#identidade").val() != "") {
        //     if ($("#orgEmi").val() == "") {
        //         alert("Por favor Informe o Orgão Emissor da sua Identidade");
        //         infoAddEnviada = false;
        //         $("#btn_gravar_info_ad").prop('disabled', false);                
        //         return false;
        //     }
        //     if ($("#dtEmiss").val() == "") {
        //         alert("Por favor Informe a Data de Emissão da sua Identidade");
        //         infoAddEnviada = false;
        //         $("#btn_gravar_info_ad").prop('disabled', false);                  
        //         return false;
        //     }
        // }

        $("#mdlAguarde").modal('toggle');
        $("#infoAdicionais").submit();
    }
    else{
        console.log("Segundo envio");
    }
});



// });