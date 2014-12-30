$(document).ready(function(){
    $("#top-menu").css('background', 'linear-gradient(to bottom,  rgba(0,0,0,.75) 1%,rgba(0,0,0,0.01) 99%,rgba(255,255,255,0) 100%)').css('color', '#000');
    $("#top-menu").find('.menu-left').find('li').find('a').css({color: '#fff', textShadow: '0 1px 2px rgba(0,0,0,.6)'});
    $("#top-menu").find('.menu-left').find('li').find('a').mouseover(function() {
        $(this).css('color', '#428bca')
    });
    $("#top-menu").find('.menu-left').find('li').find('a').mouseout(function() {
        $(this).css('color', '#fff')
    });
    $('.menu-right').css('color', '#fff');
})
$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll >= 500) {
        $("#top-menu").css('background', '#fff');
        $("#top-menu").find('.menu-left').find('li').find('a').css({color: '#666', textShadow: 'none'});
        $("#top-menu").find('.menu-left').find('li').find('a').mouseover(function() {
            $(this).css('color', '#428bca')
        });
        $("#top-menu").find('.menu-left').find('li').find('a').mouseout(function() {
            $(this).css('color', '#666')
        });
        $('.menu-right').css('color', '#666');
    } else {
        $("#top-menu").css('background', 'linear-gradient(to bottom,  rgba(0,0,0,.75) 1%,rgba(0,0,0,0.01) 99%,rgba(255,255,255,0) 100%)');
        $("#top-menu").find('.menu-left').find('li').find('a').css('color', '#fff');
        $("#top-menu").find('.menu-left').find('li').find('a').mouseover(function() {
            $(this).css('color', '#428bca')
        });
        $("#top-menu").find('.menu-left').find('li').find('a').mouseout(function() {
            $(this).css('color', '#fff')
        });
        $('.menu-right').css('color', '#fff');

    }
});