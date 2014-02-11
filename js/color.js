/**
 * Created by Flavio on 11.02.14.
 */
var color = $(".cactive").css("backgroundColor");
$('.colorset').click(function() {
    color = $(this).css("backgroundColor");
    $('.colorset').removeClass("cactive");
    $(this).addClass("cactive");
});