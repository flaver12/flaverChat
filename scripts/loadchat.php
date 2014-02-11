<?php
/**
 * Created by PhpStorm.
 * User: Flavio
 * Date: 11.02.14
 * Time: 02:47
 */
$id = $_POST['id'];
$idT = $_POST['id2'];
include "db.php";
if(mysqli_connect_errno() == 0) {
    $q = "SELECT *
    FROM chat_message
    WHERE id > $id AND id <= $idT ORDER BY id";
    $result = $db->query($q);
    while($msg = $result->fetch_object()) {
    ?>
        <div style="color:<?php echo $msg->color; ?> ">
            <b><?php echo htmlentities($msg->name); ?></b>&nbsp;(<?php echo $msg->time; ?>):&nbsp;
            <i><?php echo htmlentities($msg->message); ?></i>
        </div>
    <?php
    }
} else {
    echo "Database Error:" .mysqli_connect_errno()." : ".mysqli_connect_error();
}
$db->close();