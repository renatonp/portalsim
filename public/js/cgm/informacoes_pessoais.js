// jQuery(document).ready(function () {
// Guarda os valores iniciais 

$("#dtnasc").mask("00/00/0000");
$("#dtfalec").mask("00/00/0000");

var infoEnviada = false;

var cgm_nomeFantasia = $("#nomeFantasia").val();
var cgm_inscricao_estadual = $("#inscricao_estadual").val();
var cgm_mae = $("#mae").val();
var cgm_pai = $("#pai").val();
var cgm_dtnasc = $("#dtnasc").val();
var cgm_dtfalec = $("#dtfalec").val();
var cgm_estCivil = $("#estCivil").val();
var cgm_sex = $("#sex").val();
var cgm_nacionalidade = $("#nacionalidade").val();
var cgm_escolaridade = $("#escolaridade").val();
var cgm_nomeFantasia = $("#nomeFantasia").val();
var cgm_iest = $("#iest").val();
var cgm_nire = $("#nire").val();
var cgm_contato = $("#contato").val();

$("#btn_altera_info_pess").click(function () {
    // verifica qual a ação está sendo feita (Alter/Cancelar)
    if ($("#btn_altera_info_pess").val() == 1) {
        $("#btn_altera_info_pess").val(2);
        $("#btn_altera_info_pess").html("CANCELAR ALTERAÇÕES");

        // Habilita os campos para alteração
        $("#nomeFantasia").prop('readonly', false);
        $("#iest").prop('readonly', false);
        $("#nire").prop('readonly', false);
        $("#contato").prop('readonly', false);

        $("#mae").prop('readonly', false);
        $("#pai").prop('readonly', false);
        $("#dtnasc").prop('readonly', false);
        $("#dtfalec").prop('readonly', false);
        $("#estCivil").prop('disabled', false);
        $("#sex").prop('disabled', false);
        $("#nacionalidade").prop('disabled', false);
        $("#escolaridade").prop('disabled', false);

        $("#btn_gravar_info_pess").prop('disabled', false);

    }
    else {
        // desabilita os campos e restaura os valores iniciais 
        $("#btn_altera_info_pess").val(1);
        $("#btn_altera_info_pess").html("ALTERAR DADOS");

        // Restaura valores iniciais
        $("#nomeFantasia").val(cgm_nomeFantasia);
        $("#iest").val(cgm_iest);
        $("#nire").val(cgm_nire);
        $("#contato").val(cgm_contato);

        $("#mae").val(cgm_mae);
        $("#pai").val(cgm_pai);
        $("#dtnasc").val(cgm_dtnasc);
        $("#dtfalec").val(cgm_dtfalec);
        $("#estCivil").val(cgm_estCivil);
        $("#sex").val(cgm_sex);
        $("#nacionalidade").val(cgm_nacionalidade);
        $("#escolaridade").val(cgm_escolaridade);

        // Desabilita campos
        $("#nomeFantasia").prop('readonly', true);
        $("#iest").prop('readonly', true);
        $("#nire").prop('readonly', true);
        $("#contato").prop('readonly', true);

        $("#mae").prop('readonly', true);
        $("#pai").prop('readonly', true);
        $("#dtnasc").prop('readonly', true);
        $("#dtfalec").prop('readonly', true);
        $("#estCivil").prop('disabled', true);
        $("#sex").prop('disabled', true);
        $("#nacionalidade").prop('disabled', true);
        $("#escolaridade").prop('disabled', true);

        $("#btn_gravar_info_pess").prop('disabled', true);
    }
});


$("#btn_gravar_info_pess").click(function () {
    
    console.log("Envio = " + infoEnviada);

    if(!infoEnviada){
        infoEnviada = true;
        $("#btn_gravar_info_pess").prop('disabled', true);

        console.log("Primeiro envio");

        if ($("#cpf").val().length <= 14){
            if ($("#dtnasc").val() != "") {
                var dtHoje = new Date();
                var dtParts = $("#dtnasc").val().split('/');
                var dtNascTmp = new Date(dtParts[2], dtParts[1] - 1, dtParts[0]);
            
                // alert(isDate(dtParts[2], dtParts[1], dtParts[0]));
                if (!isDate(dtParts[2], dtParts[1], dtParts[0])) {
                    alert("Data de Nascimento inválida. Por favor Informe uma data válida");
                    infoEnviada = false;
                    $("#btn_gravar_info_pess").prop('disabled', false);
                    return false;
                }
            
                if (dtNascTmp >= dtHoje) {
                    alert("Data de Nascimento inválida. Por favor Informe uma data válida");
                    $("#dtnasc").focus();
                    infoEnviada = false;
                    $("#btn_gravar_info_pess").prop('disabled', false);
                    return false;
                }
            }
            else{
                alert("Data de Nascimento inválida. Por favor Informe uma data válida");
                $("#dtnasc").focus();
                infoEnviada = false;
                $("#btn_gravar_info_pess").prop('disabled', false);
                return false;            
            }    
        }

        $("#mdlAguarde").modal('toggle');
        $("#infoPessoal").submit();
        infoEnviada = false;
    }
    else{
        console.log("Segundo envio");
    }
});
function isDate(year, month, day) {
    myDate = new Date(year, (+month - 1), day)
    return isValidDate = (Boolean(+myDate) && myDate.getDate() == day)
}
// });