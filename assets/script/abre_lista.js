$(function(){
    $('#pasta h1').click(function () {
        $('#pasta ul').slideToggle().toggleClass('disable');
        $('#burger ul').slideUp().addClass('disable');
        $('#grill div').slideUp().addClass('disable');
    });

    $('#burger h1').click(function () {
        $('#burger ul').slideToggle().toggleClass('disable');
        $('#pasta ul').slideUp().addClass('disable');
        $('#grill div').slideUp().addClass('disable');
    });

    $('#grill h1').click(function () {
        $('#grill div').slideToggle().toggleClass('disable');
        $('#pasta ul').slideUp().addClass('disable');
        $('#burger ul').slideUp().addClass('disable');
    });
});