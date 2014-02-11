/**
 * Created by Flavio on 11.02.14.
 */
//Grep the values and set some variabels
var last = $("#lastEntry").val();
var newId;
var userList = 60;
var noReload = 0;
//Controlling function
function controlling() {
   if(noReload == 0) {
       if(userList == 60) {
           userList = 0;
           //Ajax request
           $.ajax({
               type: "POST",
               data: {id:$("#userid").val()},
               url: "scripts/userlist.php",
               success: function(msg) {
                   $("#userstream").html(msg);
               }
           });
       }
       userList ++;
       //Ajax request
       $.ajax({
           type: "POST",
           url: "scripts/query.php",
           success: function(id2) {
               if(id2 > last) {
                   newId = id2;
                   loadChat();
               } else {
                   window.setTimeout("controlling()", 1000);
               }
           }
       });
   }
}
controlling();

//Load the new rows in the char window
function loadChat() {
    $.ajax({
        type: "POST",
        url: "scripts/loadchat.php",
        data: {id:last, id2:newId},
        success: function(msg) {
            zeichen = new Array(/auml/g, /Auml/g, /ouml/g, /Ouml/g, /uuml/g, /Uuml/g, /szlig/g);
            replace = new Array("&auml;", "&Auml;", "&ouml;", "&Ouml;", "&uuml;", "&Uuml;", "&szlig;");

            for(i = 0; i < zeichen.length; i++) {
                msg = msg.replace(zeichen[i], replace[i]);
            }
            $("#stream").append(msg);
            last = newId;
            window.setTimeout("controlling()", 1000);
            document.getElementById("stream").scrollTop = document.getElementById("stream").scrollHeight;
        }
    });
}
$("#message").submit(function() {
    if($("#messageBox").val() != "") {
        noReload = 1;
        $("#response").html("Sending messsage");
        var message = $("#messageBox").val();
        $("#messageBox").val("");

        char = new Array(/\u00e4/g, /\u00c4/g, /\u00f6/g, /\u00d6/g, /\u00fc/g, /\u00dc/g, /\u00df/g);
        replace = new Array("auml", "Auml", "ouml", "Ouml", "uuml", "Uuml", "szlig");
        for(i = 0; i < zeichen.length; i++) {
            message = message.replace(char[i], replace[i]);
        }
        var color = $(".cactive").css("backgroundColor");
        //Ajax request
        $.ajax({
            type: "POST",
            url: "scripts/message.php",
            data: {username:$("#username").val(), message:message, color:color},
            success: function(msg) {
                $("#response").html(msg);
                $("#messageBox").focus();
                noReload = 0;
                window.setTimeout("controlling()", 1000);
            }
        });

    } else {
        alert("No empty message");
    }
    return false;
});
$("#messageBox").bind("keypress",function(event) {
    //13 = Enter
    if(event.which == 13) {
        $("#message").submit();
        $("#areacount").html("500");
        return false;
    }
});
$("#messageBox").keyup(function() {
    $("#areacount").html(500 - $("#messageBox").val().length);
});