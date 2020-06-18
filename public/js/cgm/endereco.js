// jQuery(document).ready(function () {
// Guarda os valores iniciais 

var infoEndEnviada = false;

$("#cep1").mask("00.000-000");
var cgm_end_morador = $("#morador1").val();
var cgm_end_cep = $("#cep1").val();
var cgm_end_uf = $("#uf1").val();
var cgm_end_city = $("#city1").val();
var cgm_end_number = $("#number1").val();
var cgm_end_complement = $("#complement1").val();

var cgm_end_district = $("#district_11").val();
var cgm_end_address = $("#address_11").val();


$("#district_01").hide();
$("#district_11").show();
$("#address_01").hide();
$("#address_11").show();


$("#district_01").change(function () {

    // alert($("#district_01").val());

    var id = $("#district_01").val();
    if (id) {
        var url = 'recuperaRuasCGM/' + id;

        $.get(url, function (resposta) {

            var opt = "";
            // $("address_01").empty();
            document.getElementById("address_01").options.length = 0;
            $.each(resposta.ruas.aRuasEncontradas, function (i, item) {
                $('#address_01').append($('<option>', {
                    value: item.iRua+"|"+unescape(item.sDescricao).replace(/[+]/g, " "),
                    text: unescape(item.sDescricao).replace(/[+]/g, " ")
                }));
                // console.log(item.sDescricao);
                // return false;
            });
        });
    }



});

$("#morador1").change(function () {

    if ($("#btn_altera_endereco").val() == 2) {

        if ($("#morador1").val() == "0") {
            $("#cep1").prop('readonly', true);
            $("#buscaCep1").prop('disabled', true);
            $("#buscaCep1").removeClass("btn-blue");
            $("#uf1").prop('disabled', true);
            $("#city1").prop('readonly', true);
            $("#district_01").show();
            $("#district_11").hide();
            $("#district_11").prop('readonly', true);
            $("#district_01").prop('disabled', false);
            $("#address_01").show();
            $("#address_11").hide();
            $("#address_11").prop('readonly', true);
            $("#address_01").prop('disabled', false);
            $("#address1").prop('readonly', false);
            $("#uf1").val("19");
            $("#city1").val("MARICA");
            $("#district1").focus();
        }
        else {
            $("#buscaCep1").prop('disabled', false);
            $("#buscaCep1").addClass("btn-blue");
            $("#uf1").prop('disabled', true);
            $("#city1").prop('readonly', true);
            $("#district_01").hide();
            $("#district_11").show();
            $("#district_01").prop('disabled', true);
            $("#district_11").prop('readonly', true);
            $("#address_01").hide();
            $("#address_11").show();
            $("#address_01").prop('disabled', true);
            $("#address_11").prop('readonly', true);
            $("#address").prop('readonly', true);
            $("#cep1").prop('readonly', false);
            $("#city1").val("");
            $("#cep1").focus();
        }
    }
});

$("#btn_altera_endereco").click(function () {

    // verifica qual a ação está sendo feita (Alter/Cancelar)
    if ($("#btn_altera_endereco").val() == 1) {
        $("#btn_altera_endereco").val(2);
        $("#btn_altera_endereco").html("CANCELAR ALTERAÇÕES");

        // Habilita os campos para alteração
        $("#morador1").prop('disabled', false);
        if ($("#morador1").val() == "0") {

            $("#district_01").show();
            $("#district_11").hide();
            $("#district_11").prop('readonly', true);
            $("#district_01").prop('disabled', false);
            $("#address_01").show();
            $("#address_11").hide();
            $("#address_11").prop('readonly', true);
            $("#address_01").prop('disabled', false);

            $("#buscaCep1").prop('disabled', true);
            $("#buscaCep1").removeClass("btn-blue");
            $("#cep1").prop('readonly', true);
            $("#district_01").focus();

            $("#cep1").prop('readonly', true);
            $("#buscaCep1").prop('disabled', true);
            $("#buscaCep1").removeClass("btn-blue");
            $("#uf1").prop('disabled', true);
            $("#city1").prop('readonly', true);
            $("#district_01").show();
            $("#district_11").hide();
            $("#district_11").prop('readonly', true);
            $("#district_01").prop('disabled', false);
            $("#address_01").show();
            $("#address_11").hide();
            $("#address_11").prop('readonly', true);
            $("#address_01").prop('disabled', false);
            $("#address1").prop('readonly', false);
            $("#uf1").val("19");
            $("#city1").val("MARICA");
            $("#district1").focus();

        }
        else {
            $("#district_01").hide();
            $("#district_11").show();
            $("#district_01").prop('disabled', true);
            $("#district_11").prop('readonly', false);
            $("#address_01").hide();
            $("#address_11").show();
            $("#address_01").prop('disabled', true);
            $("#address_11").prop('readonly', false);

            $("#buscaCep1").prop('disabled', false);
            $("#buscaCep1").addClass("btn-blue");
            $("#cep1").prop('readonly', false);
            $("#cep1").focus();

            $("#buscaCep1").prop('disabled', false);
            $("#buscaCep1").addClass("btn-blue");
            $("#uf1").prop('disabled', false);
            $("#city1").prop('readonly', false);
            $("#district_01").hide();
            $("#district_11").show();
            $("#district_01").prop('disabled', true);
            $("#district_11").prop('readonly', false);
            $("#address_01").hide();
            $("#address_11").show();
            $("#address_01").prop('disabled', true);
            $("#address_11").prop('readonly', false);
            $("#address").prop('readonly', false);
            $("#cep1").prop('readonly', false);
            $("#city1").val("");
            $("#cep1").focus();
        }
        $("#number1").prop('readonly', false);
        $("#complement1").prop('readonly', false);

        $("#cep1").val("");
        $("#district_11").val("");
        $("#address_11").val("");
        $("#number1").val("");
        $("#complement1").val("");
        $("#btn_gravar_endereco").prop('disabled', false);
    }
    else {
        // desabilita os campos e restaura os valores iniciais 
        $("#btn_altera_endereco").val(1);
        $("#btn_altera_endereco").html("ALTERAR DADOS");

        // Restaura valores iniciais
        $("#morador1").val(cgm_end_morador);
        $("#cep1").val(cgm_end_cep);
        $("#uf1").val(cgm_end_uf);
        $("#city1").val(cgm_end_city);

        $("#district_01").val(cgm_end_district);
        $("#address_01").val(cgm_end_address);

        $("#district_11").val(cgm_end_district);
        $("#address_11").val(cgm_end_address);

        $("#district_01").hide();
        $("#district_11").show();
        $("#district_01").prop('disabled', true);
        $("#district_11").prop('readonly', true);
        $("#address_01").hide();
        $("#address_11").show();
        $("#address_01").prop('disabled', true);
        $("#address_11").prop('readonly', true);

        $("#number1").val(cgm_end_number);
        $("#complement1").val(cgm_end_complement);

        // Desabilita campos
        $("#morador1").prop('disabled', true);
        $("#cep1").prop('readonly', true);
        $("#uf1").prop('disabled', true);
        $("#city1").prop('readonly', true);
        $("#number1").prop('readonly', true);
        $("#complement1").prop('readonly', true);

        $("#btn_gravar_endereco").prop('disabled', true);

    }
});


$("#buscaCep1").click(function () {
    if ($("#cep1").val() == "") {
        alert("Informe o CEP");
        return false;
    }
    else {
        // $("#buscaCep1").modal('toggle');
        var cep = $("#cep1").val().replace(/[^0-9]/, '');
        if (cep) {
            var url = 'consultaCEPcgm/' + cep;

            $.get(url, function (resposta) {
                var obj = jQuery.parseJSON(resposta);
                if (obj.logradouro) {
                    // $("#buscaCep1Cgm").modal('toggle');
                    $("#address_11").val(obj.logradouro);
                    $("#district_11").val(obj.bairro);
                    $("#city1").val(obj.localidade);
                    $("#uf1").val(descricaoEstado1(obj.uf));
                    $("#number1").focus();
                }
                else {
                    // $("#buscaCep1Cgm").modal('toggle');
                    alert("O CEP informado não é válido!");
                    return false;
                }
            });
        }
    }

});

$("#btn_gravar_endereco").click(function () {


    if(!infoEndEnviada){
        infoEndEnviada = true;
        $("#btn_gravar_endereco").prop('disabled', true);
            

        $("#ufDesc1").val($("#uf1 option:selected").text());
        $("#ufCod1").val($("#uf1").val());
        if ($("#morador1").val() == "1") {
            if ($("#cep1").val() == "") {
                alert("Por favor Informe o CEP do seu endereço de correspondência");
                infoEndEnviada = false;
                $("#btn_gravar_endereco").prop('disabled', false);
                return false;
            }
        }
        if ($("#city1").val() == "") {
            alert("Por favor Informe o Município do seu endereço de correspondência");
            infoEndEnviada = false;
            $("#btn_gravar_endereco").prop('disabled', false);
            return false;
        }
        if ($("#morador1").val() == "0") {
            if ($("#district_01").val() == 0) {
                alert("Por favor Informe o Bairro do seu endereço de correspondência");
                infoEndEnviada = false;
                $("#btn_gravar_endereco").prop('disabled', false);
                return false;
            }
            if ($("#address_01").val() == null || $("#address_01").val() == 0) {
                alert("Por favor Informe o Logradouro do seu endereço de correspondência");
                infoEndEnviada = false;
                $("#btn_gravar_endereco").prop('disabled', false);
                return false;
            }
        }
        if ($("#number1").val() == "") {
            alert("Por favor Informe o Número do seu endereço de correspondência");
            infoEndEnviada = false;
            $("#btn_gravar_endereco").prop('disabled', false);
            return false;
        }
        if ($("#morador1").val() == "0") {
            $("#district_11").prop('disabled', true);
        }
        else {
            $("#district_01").prop('disabled', true);
        }

        $("#mdlAguarde").modal('toggle');
        $("#formEndereco").submit();
    }
    else{
        console.log("Segundo envio");
    }
});


function descricaoEstado1(uf) {
    switch (uf) {
        case 'AC':
            return '1';
            break;
        case 'AL':
            return '2';
            break;
        case 'AP':
            return '3';
            break;
        case 'AM':
            return '4';
            break;
        case 'BA':
            return '5';
            break;
        case 'CE':
            return '6';
            break;
        case 'DF':
            return '7';
            break;
        case 'ES':
            return '8';
            break;
        case 'GO':
            return '9';
            break;
        case 'MA':
            return '10';
            break;
        case 'MT':
            return '11';
            break;
        case 'MS':
            return '12';
            break;
        case 'MG':
            return '13';
            break;
        case 'PA':
            return '14';
            break;
        case 'PB':
            return '15';
            break;
        case 'PR':
            return '16';
            break;
        case 'PE':
            return '17';
            break;
        case 'PI':
            return '18';
            break;
        case 'RJ':
            return '19';
            break;
        case 'RN':
            return '20';
            break;
        case 'RS':
            return '21';
            break;
        case 'RO':
            return '22';
            break;
        case 'RR':
            return '23';
            break;
        case 'SC':
            return '24';
            break;
        case 'SP':
            return '26';
            break;
        case 'SE':
            return '25';
            break;
        case 'TO':
            return '27';
            break;
    }
}

// });