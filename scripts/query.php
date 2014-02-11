<?php
/**
 * Created by PhpStorm.
 * User: Flavio
 * Date: 11.02.14
 * Time: 02:38
 */
include "db.php";
if(mysqli_connect_errno() == 0) {
    $q = "SELECT id FROM chat_message ORDER BY id DESC LIMIT 1";
    $result = $db->prepare($q);
    $result->execute();
    $result->bind_result($id2);

    while($result->fetch()) {
        echo $id2;
    }
} else {
    echo "Database Error:" .mysqli_connect_errno()." : ".mysqli_connect_error();
}
$db->close();