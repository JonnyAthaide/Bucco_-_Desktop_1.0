
$(document).ready(function () {
    var documentEl = $(window);
    var currScrollPos = documentEl.scrollTop();

    // VARIÁVEIS SEÇÃO
    var secaoUm = "#sec_um",
            secaoDois = "#sec_dois",
            secaoTres = "#sec_tres",
            secaoQuatro = "#sec_quatro",
            secaoCinco = "#sec_cinco";

// VARIÁVEIS SEÇÃO
    var headerHeigth = 124,
            velocidadeTransicao = 1500,
            velocidadeLista = 250;

    btCard = $('#card');


    /* =============================================================================    
     * * MOVIMENTO CLICK MOUSE NAVEGADOR
     * ============================================================================= */


    //    CLICK PARA VOLTAR AO TOPO DA PÁGINA
    $('[title=BUCCO]').click(function () {
        if (documentEl.scrollTop() > 0) {
            $('html, body').animate({
                scrollTop: $("body").offset().top
            }, velocidadeTransicao);
        }
    });
//    CLICK PARA SEÇÃO 2
    $(secaoDois).click(function () {
        $('html, body').animate({
            scrollTop: $("#section_dois").offset().top - headerHeigth},
                velocidadeTransicao);
    });
    $('#click').click(function () {
        $('html, body').animate({
            scrollTop: $("#section_dois").offset().top - headerHeigth},
                velocidadeTransicao);
    });
    //    CLICK PARA SEÇÃO 3
    $(secaoTres).click(function () {
        $('html, body').animate({
            scrollTop: $("#section_tres").offset().top - headerHeigth},
                velocidadeTransicao);
    });
    //    CLICK PARA SEÇÃO 4
    $(secaoQuatro).click(function () {
        $('html, body').animate({
            scrollTop: $("#section_quatro").offset().top - headerHeigth},
                velocidadeTransicao);
    });
    //    CLICK PARA SEÇÃO 5
    $(secaoCinco).click(function () {
        $('html, body').animate({
            scrollTop: $("#section_cinco").offset().top - headerHeigth},
                velocidadeTransicao);
    });


    //    CLICK BOTÃO CARDÁPIO
    $(btCard).click(function () {
        $('html, body').animate({
            scrollTop: $("#section_tres").offset().top - headerHeigth},
                1000);
        $('#pasta ul').slideDown().removeClass('disable');
        $('#burger ul').slideUp().addClass('disable');
        $('#grill div').slideUp().addClass('disable');
    });
});