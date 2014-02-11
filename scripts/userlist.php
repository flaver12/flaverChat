<?php
/**
 * Created by PhpStorm.
 * User: Flavio
 * Date: 11.02.14
 * Time: 18:01
 */
$userId = $_POST['id'];
if(!$userId == "") {
    include "db.php";
    if(mysqli_connect_errno() == 0) {
        $timestp = time();
        $time = date("d.m.Y H:i",$timestp);
        $timeCalac = date("d.m.Y H:i",strtotime("$time - 10 minutes"));
        $q = "UPDATE chat_user SET time = '$time' WHERE id = $userId";
        $row = $db->query($q);

        $sql = 'SELECT id, time FROM chat_user';
        $result = $db->prepare($sql);
        $result->execute();
        $result->bind_result($id, $date);

        $userlist = array();
        $userlistCount = 0;

        while($result->fetch()) {
            if(strtotime($date) < strtotime($timeCalac)) {
                $userlist[$userlistCount] = $id;
                $userlistCount ++;
            }
        }

        for($i = 0; $i < count($userlist); $i++) {
            $q = "DELETE FROM chat_user WHERE id = $userlist[$i]";
            $result = $db->query($q);
        }

        $q = "SELECT name FROM chat_user ORDER BY id";
        $result = $db->prepare($q);
        $result->execute();
        $result->bind_result($username);
        //Create user list
        echo "<ul>";
        while($result->fetch()) {
          echo"<li>". $username ."</li>";
        }
        echo "</ul>";

    } else {
        echo "Database Error:" .mysqli_connect_errno()." : ".mysqli_connect_error();
    }
    $db->close();
}