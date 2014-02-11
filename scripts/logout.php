<?php
/**
 * Created by PhpStorm.
 * User: Flavio
 * Date: 11.02.14
 * Time: 23:24
 */
$id = $_POST['userid'];
$username = $_POST['username'];
include "db.php";
if(mysqli_connect_errno() == 0) {
    $q = "SELECT id FROM chat_message ORDER BY id DESC LIMIT 1";

} else {
    echo "Database Error:" .mysqli_connect_errno()." : ".mysqli_connect_error();
}
$db->close();