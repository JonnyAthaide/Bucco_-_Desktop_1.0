$(function () {
    $('.active-map').click(function () {
        $(this).css('display', 'none');
    });
    $('#section_cinco iframe').mouseout(function () {
        $('.active-map').css('display', 'initial');
    });
});