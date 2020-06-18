// jQuery(document).ready(function () {
// Guarda os valores iniciais 

var infoCrrEnviada = false;
var buscaCep = false;


$("#cep").mask("00.000-000");
var cgm_end2_morador = $("#morador").val();
var cgm_end2_cep = $("#cep").val();
var cgm_end2_uf = $("#uf").val();
var cgm_end2_city = $("#city_2").val();
var cgm_end2_number = $("#number").val();
var cgm_end2_complement = $("#complement").val();

var cgm_end2_district = $("#district_1").val();
var cgm_end2_address = $("#address_1").val();



$("#district_0").hide();
$("#district_1").show();
$("#address_0").hide();
$("#address_1").show();


$("#city_2").change(function () {
    console.log("Mudou");
});

$("#uf").change(function () {
    $("#mdlAguarde").modal('toggle');

    var url = 'recuperaMunicipiosCGM/' + $("#uf").val();;

    $.get(url, function (resposta) {

        if (!resposta.error){
            document.getElementById("city_1").options.length = 0;
            resposta.municipios.oMunicipio.forEach(function(item){
                $('#city_1').append($('<option>', {
                    value: unescape(item.descricao).replace(/[+]/g, " ").toUpperCase(),
                    text: unescape(item.descricao).replace(/[+]/g, " ").toUpperCase()
                }));
                if(buscaCep){
                    if(unescape(item.descricao).replace(/[+]/g, " ").toUpperCase() == $("#city_2").val().toUpperCase()){
                        console.log($("#city_2").val().toUpperCase());
                        console.log(unescape(item.descricao).replace(/[+]/g, " ").toUpperCase());
                        $("#city_1").val(unescape(item.descricao).replace(/[+]/g, " ").toUpperCase());
                        buscaCep = false;
                    }
                }  
            });
        }
    })
    .done(function() {
        $("#mdlAguarde").modal('toggle'); 
    });

});


$("#district_0").change(function () {

    // alert($("#district_0").val());

    var id = $("#district_0").val();
    if (id) {
        var url = 'recuperaRuasCGM/' + id;

        $.get(url, function (resposta) {
            var opt = "";
            // $("address_0").empty();
            document.getElementById("address_0").options.length = 0;
            $.each(resposta.ruas.aRuasEncontradas, function (i, item) {
                $('#address_0').append($('<option>', {
                    value: item.iRua,
                    text: unescape(item.sDescricao).replace(/[+]/g, " ")
                }));
                // console.log(unescape(item.sDescricao).replace(/[+]/g, " "));
                // return false;
            });
        });
    }
});

$("#morador").change(function () {

    if ($("#btn_altera_end_correspondencia").val() == 2) {

        if ($("#morador").val() == "0") {
            $("#cep").prop('readonly', true);
            $("#buscaCep").prop('disabled', true);
            $("#buscaCep").removeClass("btn-blue");
            $("#uf").prop('disabled', true);
            $("#city_2").prop('readonly', true);
            $("#city_1").prop('disabled', true);
            $("#city_1").hide();
            $("#city_2").show();
            $("#district_0").show();
            $("#district_1").hide();
            $("#district_1").prop('readonly', true);
            $("#district_0").prop('disabled', false);
            $("#address_0").show();
            $("#address_1").hide();
            $("#address_1").prop('readonly', true);
            $("#address_0").prop('disabled', false);
            $("#address").prop('readonly', false);
            $("#uf").val("19");
            $("#city_2").val("MARICA");
            $("#district").focus();
        }
        else {
            $("#buscaCep").prop('disabled', false);
            $("#buscaCep").addClass("btn-blue");
            $("#uf").prop('disabled', false);
            $("#uf").val("");
            $("#city_2").prop('readonly', false);
            $("#city_1").prop('disabled', false);
            console.log($("#btn_altera_end_correspondencia").html() + " - " + $("#btn_altera_end_correspondencia").val());
            if($("#btn_altera_end_correspondencia").val() == 2){
                $("#city_2").hide();
                $("#city_1").show();
            }
            else{
                $("#city_2").show();
                $("#city_1").hide();
            }
            console.log("City_1 - 2");
            $("#district_0").hide();
            $("#district_1").show();
            $("#district_0").prop('disabled', false);
            $("#district_1").prop('readonly', false);
            $("#address_0").hide();
            $("#address_1").show();
            $("#address_0").prop('disabled', false);
            $("#address_1").prop('readonly', false);
            $("#address").prop('readonly', true);
            $("#cep").prop('readonly', false);
            $("#cep").focus();
        }
    }
});

$("#btn_altera_end_correspondencia").click(function () {

    // verifica qual a ação está sendo feita (Alter/Cancelar)
    if ($("#btn_altera_end_correspondencia").val() == 1) {
        $("#btn_altera_end_correspondencia").val(2);
        $("#btn_altera_end_correspondencia").html("CANCELAR ALTERAÇÕES");

        // Habilita os campos para alteração
        $("#morador").prop('disabled', false);
        if ($("#morador").val() == "0") {

            $("#district_0").show();
            $("#district_1").hide();
            $("#district_1").prop('readonly', true);
            $("#district_0").prop('disabled', false);
            $("#address_0").show();
            $("#address_1").hide();
            $("#address_1").prop('readonly', true);
            $("#address_0").prop('disabled', false);

            $("#buscaCep").prop('disabled', true);
            $("#buscaCep").removeClass("btn-blue");
            $("#cep").prop('readonly', true);
            $("#district_0").focus();

            $("#cep").prop('readonly', true);
            $("#buscaCep").prop('disabled', true);
            $("#buscaCep").removeClass("btn-blue");
            $("#uf").prop('disabled', true);
            $("#city_2").prop('readonly', true);
            $("#city_1").prop('disabled', true);
            $("#city_1").hide();
            $("#city_2").show();
            $("#district_0").show();
            $("#district_1").hide();
            $("#district_1").prop('readonly', true);
            $("#district_0").prop('disabled', false);
            $("#address_0").show();
            $("#address_1").hide();
            $("#address_1").prop('readonly', true);
            $("#address_0").prop('disabled', false);
            $("#address").prop('readonly', false);
            $("#uf").val("19");
            $("#city_2").val("MARICA");
            $("#district").focus();
        }
        else {
            $("#district_0").hide();
            $("#district_1").show();
            $("#district_0").prop('disabled', true);
            $("#district_1").prop('readonly', true);
            $("#address_0").hide();
            $("#address_1").show();
            $("#address_0").prop('disabled', true);
            $("#address_1").prop('readonly', true);

            $("#buscaCep").prop('disabled', false);
            $("#buscaCep").addClass("btn-blue");
            $("#cep").prop('readonly', false);
            $("#cep").focus();

            $("#buscaCep").prop('disabled', false);
            $("#buscaCep").addClass("btn-blue");
            $("#uf").prop('disabled', false);
            $("#city_2").prop('readonly', false);
            $("#city_1").prop('disabled', false);
            $("#city_1").show();
            console.log("City_1 - 1");
            $("#city_2").hide();
            $("#district_0").hide();
            $("#district_1").show();
            $("#district_0").prop('disabled', false);
            $("#district_1").prop('readonly', false);
            $("#address_0").hide();
            $("#address_1").show();
            $("#address_0").prop('disabled', false);
            $("#address_1").prop('readonly', false);
            $("#address").prop('readonly', true);
            $("#cep").prop('readonly', false);
            $("#cep").focus();

        }
        $("#number").prop('readonly', false);
        $("#complement").prop('readonly', false);

        $("#cep").val("");
        $("#district_1").val("");
        $("#address_1").val("");
        $("#number").val("");
        $("#complement").val("");
        $("#btn_gravar_end_correspondencia").prop('disabled', false);
    }
    else {
        // desabilita os campos e restaura os valores iniciais 
        $("#btn_altera_end_correspondencia").val(1);
        $("#btn_altera_end_correspondencia").html("ALTERAR DADOS");

        // Restaura valores iniciais
        $("#morador").val(cgm_end2_morador);
        $("#cep").val(cgm_end2_cep);
        $("#uf").val(cgm_end2_uf);
        $("#city_1").val(cgm_end2_city);
        $("#city_2").val(cgm_end2_city);


        $("#district_0").val(cgm_end2_district);
        $("#address_0").val(cgm_end2_address);

        $("#district_1").val(cgm_end2_district);
        $("#address_1").val(cgm_end2_address);

        $("#district_0").hide();
        $("#district_1").show();
        $("#district_0").prop('disabled', true);
        $("#district_1").prop('readonly', true);
        $("#address_0").hide();
        $("#address_1").show();
        $("#address_0").prop('disabled', true);
        $("#address_1").prop('readonly', true);

        $("#number").val(cgm_end2_number);
        $("#complement").val(cgm_end2_complement);

        // Desabilita campos
        $("#morador").prop('disabled', true);
        $("#cep").prop('readonly', true);
        $("#uf").prop('disabled', true);
        $("#city_2").prop('readonly', true);
        $("#city_1").prop('disabled', true);
        $("#number").prop('readonly', true);
        $("#complement").prop('readonly', true);
        $("#city_1").hide();
        $("#city_2").show();
        console.log("Cancelar alterações");

        $("#btn_gravar_end_correspondencia").prop('disabled', true);

    }
});


$("#buscaCep").click(function () {
    if ($("#cep").val() == "") {
        alert("Informe o CEP");
        return false;
    }
    else {
        // $("#buscaCep").modal('toggle');
        var cep = $("#cep").val().replace(/[^0-9]/, '');
        if (cep) {
            var url = 'consultaCEPcgm/' + cep;

            $.get(url, function (resposta) {
                var obj = jQuery.parseJSON(resposta);
                if (obj.logradouro) {
                    // $("#buscaCepCgm").modal('toggle');
                    $("#address_1").val(obj.logradouro);
                    $("#district_1").val(obj.bairro);
                    $("#city_2").val(obj.localidade);
                    console.log(descricaoEstado(obj.uf));
                    $("#uf").val(descricaoEstado(obj.uf)).change();
                    buscaCep = true;
                    $("#number").focus();
                }
                else {
                    // $("#buscaCepCgm").modal('toggle');
                    alert("O CEP informado não é válido!");
                    return false;
                }
            });
        }
    }

});

$("#btn_gravar_end_correspondencia").click(function () {

    if(!infoCrrEnviada){
        infoCrrEnviada = true;
        $("#btn_gravar_end_correspondencia").prop('disabled', true);
            
        $("#ufDesc").val($("#uf option:selected").text());
        $("#ufCod").val($("#uf").val());
        if ($("#morador").val() == "1") {
            if ($("#cep").val() == "") {
                alert("Por favor Informe o CEP do seu endereço de correspondência");
                infoCrrEnviada = false;
                $("#btn_gravar_end_correspondencia").prop('disabled', false);                
                return false;
            }
        }
        if ($("#city_1").val() == "") {
            alert("Por favor Informe o Município do seu endereço de correspondência");
            infoCrrEnviada = false;
            $("#btn_gravar_end_correspondencia").prop('disabled', false);                
            return false;
        }
        if ($("#morador").val() == "0") {
            if ($("#district_0").val() == 0) {
                alert("Por favor Informe o Bairro do seu endereço de correspondência");
                infoCrrEnviada = false;
                $("#btn_gravar_end_correspondencia").prop('disabled', false);                    
                return false;
            }
            if ($("#address_0").val() == null || $("#address_0").val() == 0) {
                alert("Por favor Informe o Logradouro do seu endereço de correspondência");
                infoCrrEnviada = false;
                $("#btn_gravar_end_correspondencia").prop('disabled', false);                    
                return false;
            }
        }
        if ($("#number").val() == "") {
            alert("Por favor Informe o Número do seu endereço de correspondência");
            infoCrrEnviada = false;
            $("#btn_gravar_end_correspondencia").prop('disabled', false);                
            return false;
        }
        if ($("#morador").val() == "0") {
            $("#district_1").prop('disabled', true);
        }
        else {
            $("#district_0").prop('disabled', true);
        }

        $("#mdlAguarde").modal('toggle');
        $("#enederecoCorrespondencia").submit();
    }
    else{
        console.log("Segundo envio");
    }
});


function descricaoEstado(uf) {
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