<?php
/**
 * Created by PhpStorm.
 * User: Flavio
 * Date: 11.02.14
 * Time: 16:59
 */
$username = $_POST['username'];
$message = $_POST['message'];
$color = $_POST['color'];
include "db.php";
if(isset($username) && isset($message) && isset($color)) {
    if(mysqli_connect_errno() == 0) {
        $timestp = time();
        $date = date("d.m.Y - H:i:s",$timestp);
        $q = "INSERT INTO chat_message (name, color, message, time ) VALUE (?,?,?,?)";
        $row = $db->prepare($q);
        $row->bind_param("ssss",$username, $color, $message, $date);
        $row->execute();
        if($row->affected_rows == 1) {
            echo "Saved";
        } else {
            echo "Error";
        }
    } else {
        echo "Database Error:" .mysqli_connect_errno()." : ".mysqli_connect_error();
    }
    $db->close();
}