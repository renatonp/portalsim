$(function () {
    var menuOpen = false;

    $(".menu-hamburguer").click(function (e) {

        e.preventDefault();

        var sidebar = $(".dash-sidebar");

        if (!menuOpen) {
            menuOpen = true;
            sidebar.animate({left: 0}, 200, function (e) {
                $("body").css("overflow", "hide");
            });
            $('#check').attr('checked', true);
        } else {
            menuOpen = false;
            sidebar.animate({left: '-270'}, 200, function (e) {
                $("body").css("overflow", "hide");
            });
            $('#check').attr('checked', false);
        }
    });

    $('.btn-login').click(function () {
        $('.navbar-laravel').css('padding-right', '0px');
        $('body').css('padding-right', '0px');
        $('body').removeClass('modal-open');
    });
})
