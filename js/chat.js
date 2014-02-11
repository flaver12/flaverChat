/**
 * Created by Flavio on 11.02.14.
 */
//Grep the values and set some variabels
var last = $("#lastEntry").val();
var newId;
var noReload = 0;
//Controlling function
function controlling() {
   if(noReload == 0) {
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
        data: "id="+last + "id2="+newId,
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
