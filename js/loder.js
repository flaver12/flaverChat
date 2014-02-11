/**
 * Created by Flavio on 11.02.14.
 */
$(document).ready(function() {
    $("#login").submit(function(){
        //Check is the username empty
        if($("#username").val() == "") {
            $("#response").html("Username not Empty!");
        } else {
            username = $("#username").val();
            $("#submit").attr("disabled", "disable");
            $("#response").html("Loading.......");
            //Ajax request
            $.ajax({
                type: "POST",
                url: "scripts/loader.php",
                data: "name="+username,
                success: function(msg) {
                    $("#main").html(msg);
                    $("#response").html("");
                    $("#message").focus();
                }
            });
        }
        return false;
    });
});