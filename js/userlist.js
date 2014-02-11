/**
 * Created by Flavio on 11.02.14.
 */
var userList = 60;

function refreshUsers() {
    if(userList == 60) {
        userList = 0;
    }
    userList ++;
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

refreshUsers();