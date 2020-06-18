/*global jQuery:false */
jQuery(document).ready(function ($) {
    "use strict";

    $("#btn_submit").click(function () {
        $("#frm_login").submit();
    });

    $("#btn_menu").click(function () {
        $("#menu_lateral").toggleClass("hide");
        $("#lateral-direita").toggleClass("margin-menu");
        $("#abrir_menu").toggleClass("hide");
        $("#fechar_menu").toggleClass("hide");
    });

    $("#phoneFC").mask("(00)00000-0009");

    $("#btn_contato").click(function () {
        if($("#nameFC").val() == ""){
            alert("Por favor informe o seu nome.")
            $("#nameFC").focus();
            return false;
        }
        if(!validaEmail($("#emailFC").val())){
            alert("E-mail inválido!  Por favor informe um e-mail válido.")
            $("#emailFC").focus();
            return false;
        }
        if($("#phoneFC").val() == ""){
            alert("Por favor informe o número do seu telefone.")
            $("#phoneFC").focus();
            return false;
        }
        if($("#solicitacao").val() == ""){
            alert("Por favor informe o tipo de solicitação.")
            $("#solicitacao").focus();
            return false;
        }
        if($("#mensagem").val() == ""){
            alert("Por favor informe a sua mensagem.")
            $("#mensagem").focus();
            return false;
        }

        $("#contactForm").submit();
    });

    function validaEmail(email){

        var usuario = email.substring(0, email.indexOf("@"));
        var dominio = email.substring(email.indexOf("@")+ 1, email.length);
        
        if ((usuario.length >=1) &&
            (dominio.length >=3) && 
            (usuario.search("@")==-1) && 
            (dominio.search("@")==-1) &&
            (usuario.search(" ")==-1) && 
            (dominio.search(" ")==-1) &&
            (dominio.search(".")!=-1) &&      
            (dominio.indexOf(".") >=1)&& 
            (dominio.lastIndexOf(".") < dominio.length - 1)) {
            return true;
        }
        else{
            return false;
        }
    }


    $("#logout").click(function () {
        $("#logout-form").submit();
    });

    $("#btn_retorna_consulta").click(function () {
        window.location.href = "acompanhamento";
    });

    $("#valida_cpf_login").click(function (e) {
        
        e.preventDefault();

        if ($("#cpf_login").val().length == 14) {

            if (validarCPF($("#cpf_login").val())) {
                $("#frmCpf").submit();
            }
            else {
                alert("CPF Inválido!  Inoforme o corretamente o número do seu CPF");
            }
        }
        else if ($("#cpf_login").val().length == 18) {
            if (validarCNPJ($("#cpf_login").val())) {
                $("#frmCpf").submit();
            }
            else {
                alert("CNPJ Inválido!  Inoforme o corretamente o número do seu CNPJ");
            }
        }
        else {
            alert("Por favor, informe corretamente o número do seu CPF ou CNPJ.");
        }
    });

    $("#continuar-alvara").click(function () {
        window.location.href = $("#servico_01-doc").val();
    })

    $("#continuar-certidao").click(function () {
        window.location.href = $("#servico_02-doc").val();
    })

    $("#continuar-iptu").click(function () {
        window.location.href = $("#servico_03-doc").val();
    })

    $("#continuar-iss").click(function () {
        window.location.href = $("#servico_04-doc").val();
    })

    $("#btnCad").click(function () {

        alert($("#cpf_login").val().length);
        alert($("#cpf_login").val());

        if ($("#cpf_login").val().length == 14) {
            if (validarCPF($("#cpf_login").val())) {
                window.location.href = "valida_cpf_cadastro/:cpf";
            }
            else {
                alert("CPF Inválido!  Inoforme o corretamente o número do seu CPF");
            }
        }
        else if ($("#cpf_login").val().length == 18) {
            if (validarCNPJ($("#cpf_login").val())) {
                $("#frmCpf").submit();
            }
            else {
                alert("CNPJ Inválido!  Inoforme o corretamente o número do seu CNPJ");
            }
        }
        else {
            alert("Por favor, informe corretamente o número do seu CPF ou CNPJ.");
        }
    });

    var cpf_options = {
        onKeyPress: function (cpf, e, field, cpf_options) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cpf.length > 14 || cpf.length == 0) ? masks[1] : masks[0];
            $('#cpf').mask(mask, cpf_options);
        }
    };

    if (typeof ($("#cpf")) !== "undefined") {
        $("#cpf").mask('00.000.000/0000-00', cpf_options);
    }

    var cpf_options_login = {
        onKeyPress: function (cpf, e, field, cpf_options_login) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            var mask = (cpf.length > 14 || cpf.length == 0) ? masks[1] : masks[0];
            $('#cpf_login').mask(mask, cpf_options_login);
        }
    };

    if (typeof ($("#cpf_login")) !== "undefined") {
        $("#cpf_login").mask('00.000.000/0000-00', cpf_options_login);
    }



    if (typeof ($("#avisos")) !== "undefined") {
        $('#avisos').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            }
        });


        var table = $('#avisos').DataTable();

        $('#avisos tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                // $(this).removeClass('selected');
            }
            else {
                var linha = table.row(this).data();
                window.location.href = "avisoEdit/" + linha[0];
            }
        });
    }

    if (typeof ($("#acompanhamento")) !== "undefined") {
        $('#acompanhamento').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            }
        });
    }

    $('.flexslider').flexslider({
        animation: "fade"
    });

    $(function () {
        $('.show_menu').click(function () {
            $('.menu').fadeIn();
            $('.show_menu').fadeOut();
            $('.hide_menu').fadeIn();
        });
        $('.hide_menu').click(function () {
            $('.menu').fadeOut();
            $('.show_menu').fadeIn();
            $('.hide_menu').fadeOut();
        });
    });

    function validarCNPJ(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        var tamanho = cnpj.length - 2
        var numeros = cnpj.substring(0, tamanho);
        var digitos = cnpj.substring(tamanho);
        var soma = 0;
        var pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        var resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (var i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;
    }

    function validarCPF(cpf) {
        var add;
        var rev;
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
        // Valida 1o digito	
        add = 0;
        for (var i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        // Valida 2o digito	
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }

    (function () {

        var $menu = $('.navigation nav'),
            optionsList = '<option value="" selected>Ir para...</option>';

        $menu.find('li').each(function () {
            var $this = $(this),
                $anchor = $this.children('a'),
                depth = $this.parents('ul').length - 1,
                indent = '';

            if (depth) {
                while (depth > 0) {
                    indent += ' - ';
                    depth--;
                }

            }
            $(".nav li").parent().addClass("bold");

            optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
        }).end()
            .after('<select class="selectmenu">' + optionsList + '</select>');

        $('select.selectmenu').on('change', function () {
            window.location = $(this).val();
        });

    })();


    $('.toggle-link').each(function () {
        $(this).click(function () {
            var state = 'open'; //assume target is closed & needs opening
            var target = $(this).attr('data-target');
            var targetState = $(this).attr('data-target-state');

            //allows trigger link to say target is open & should be closed
            if (typeof targetState !== 'undefined' && targetState !== false) {
                state = targetState;
            }

            if (state == 'undefined') {
                state = 'open';
            }

            $(target).toggleClass('toggle-link-' + state);
            $(this).toggleClass(state);
        });
    });

    //add some elements with animate effect

    $(".big-cta").hover(
        function () {
            $('.cta a').addClass("animated shake");
        },
        function () {
            $('.cta a').removeClass("animated shake");
        }
    );
    $(".box").hover(
        function () {
            $(this).find('.icon').addClass("animated pulse");
            $(this).find('.text').addClass("animated fadeInUp");
            $(this).find('.image').addClass("animated fadeInDown");
        },
        function () {
            $(this).find('.icon').removeClass("animated pulse");
            $(this).find('.text').removeClass("animated fadeInUp");
            $(this).find('.image').removeClass("animated fadeInDown");
        }
    );


    $('.accordion').on('show', function (e) {

        $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
        $(e.target).prev('.accordion-heading').find('.accordion-toggle i').removeClass('icon-plus');
        $(e.target).prev('.accordion-heading').find('.accordion-toggle i').addClass('icon-minus');
    });

    $('.accordion').on('hide', function (e) {
        $(this).find('.accordion-toggle').not($(e.target)).removeClass('active');
        $(this).find('.accordion-toggle i').not($(e.target)).removeClass('icon-minus');
        $(this).find('.accordion-toggle i').not($(e.target)).addClass('icon-plus');
    });



    //Navi hover
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });

    // tooltip
    $('.social-network li a, .options_box .color a').tooltip();

    // fancybox
    $(".fancybox").fancybox({
        padding: 0,
        autoResize: true,
        beforeShow: function () {
            this.title = $(this.element).attr('title');
            this.title = '<h4>' + this.title + '</h4>' + '<p>' + $(this.element).parent().find('img').attr('alt') + '</p>';
        },
        helpers: {
            title: {
                type: 'inside'
            },
        }
    });


    //scroll to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });
    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
        return false;
    });

    $('#mycarousel').jcarousel();
    $('#mycarousel1').jcarousel();

    //flexslider
    $('.flexslider').flexslider();

    //nivo slider
    $('.nivo-slider').nivoSlider({
        effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
        slices: 15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed: 500, // Slide transition speed
        pauseTime: 5000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: true, // Next & Prev navigation
        controlNav: false, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: true, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        prevText: '', // Prev directionNav text
        nextText: '', // Next directionNav text
        randomStart: false, // Start on a random slide
        beforeChange: function () { }, // Triggers before a slide transition
        afterChange: function () { }, // Triggers after a slide transition
        slideshowEnd: function () { }, // Triggers after all slides have been shown
        lastSlide: function () { }, // Triggers when last slide is shown
        afterLoad: function () { } // Triggers when slider has loaded
    });

    // Da Sliders
    if ($('#da-slider').length) {
        $('#da-slider').cslider();
    }

    //slitslider
    var Page = (function () {

        var $nav = $('#nav-dots > span'),
            slitslider = $('#slider').slitslider({
                onBeforeChange: function (slide, pos) {
                    $nav.removeClass('nav-dot-current');
                    $nav.eq(pos).addClass('nav-dot-current');
                }
            }),

            init = function () {
                initEvents();
            },
            initEvents = function () {
                $nav.each(function (i) {
                    $(this).on('click', function () {
                        var $dot = $(this);

                        if (!slitslider.isActive()) {
                            $nav.removeClass('nav-dot-current');
                            $dot.addClass('nav-dot-current');
                        }

                        slitslider.jump(i + 1);
                        return false;

                    });

                });

            };

        return {
            init: init
        };
    })();

    Page.init();

});
