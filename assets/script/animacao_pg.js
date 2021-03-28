$(document).ready(function () {
    var documentEl = $(window);
    var currScrollPos = documentEl.scrollTop();
    var secaoDois = "#sec_dois";
    
    
    documentEl.on('scroll', function () {


//        alert(secaoDois);
        
        
        if ($(this).scrollTop() > $(secaoDois).offset().top - (currScrollPos * .1)) {
            alert(secaoDois);
            $('[title=POTEFRANGO]').css({
                "transition": "transform 2s ease-in-out, opacity 2s ease-in-out",
                "-o-transition": "transform 2s ease-in-out, opacity 2s ease-in-out",
                "-webkit-transition": "transform 2s ease-in-out, opacity 2s ease-in-out",
                "-moz-transition": "transform 2s ease-in-out, opacity 2s ease-in-out",
                "transform": "translateX(-420px) translateY(-50px)", "opacity": "1"
            });
        } else {
            $('[title=POTEFRANGO]').css({"transform": "initial", "opacity": "0"});
        }

//        if ($(this).scrollTop() > $(secaoDois).offset().top - (currScrollPos * .5)) {
//            //                ADD MOVIMENTO DO QUADRO
//            $('[title=QUADRO]').css({
//                'animation': 'moveLousa 5s infinite linear',
//                '-webkit-animation': 'moveLousa 5s infinite linear'
//            });
//        } else {
//            //                REMOVE MOVIMENTO DO QUADRO
//            $('[title=QUADRO]').css({
//                'animation': 'none',
//                '-webkit-animation': 'none'
//            });
//        }


        /* =============================================================================
         * AJUSTE MENU FIXO            
         * ============================================================================= */
        if ($(window).scrollTop() > $('#section_dois').offset().top - 200) {
            $('header').addClass('header');
        } else {
            $('header').removeClass('header');
        }
    });
});