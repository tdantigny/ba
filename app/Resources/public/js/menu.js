$(document).ready(function() {
    $('.header__menu-hamburger').click(function () {
        if ($('.header__nav').css('display') == 'block') {
            $('.header__nav').css('display','none');
        }
        else {
            $('.header__nav').css('display','block');
        }
    });
});