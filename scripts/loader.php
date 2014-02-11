<?php
/**
 * Created by PhpStorm.
 * User: Flavio
 * Date: 11.02.14
 * Time: 00:48
 */
include "db.php";
$username = $_POST["name"];
//Check the connection
if(mysqli_connect_errno() == 0) {
    $timestp = time();
    $time = date("d.m.Y H:i",$timestp);

    $q = "INSERT INTO chat_user(name,time) VALUE (?,?)";
    $row = $db->prepare($q);
    $row->bind_param('ss',$username, $time);
    $row->execute();

    //If save was okey we build the chat
    if($row->affected_rows == 1) {
        ?>
            <h2>Flaver Chat&nbsp;
                <form action="logout.php" method="post">
                    <input type="submit" value="Logout">
                    <input type="hidden" value="<?php $row->insert_id; ?>" name="userId">
                    <input type="hidden" value="<?php $username ?>" name="username">
                </form>
            </h2>
            <div id="stream"></div>
            <div id="useronline">
                <h2>User online: </h2>
                <div id="userstream"></div>
            </div>
            <form id="message" method="post">
                <h4>Message: </h4>
                <div id="color">
                    <div class="colorset red cactive"></div>
                    <div class="colorset blue"></div>
                    <div class="colorset lightblue"></div>
                    <div class="colorset green"></div>
                    <div class="colorset purple"></div>
                    <div class="colorset orange"></div>
                    <div class="colorset darkred"></div>
                </div>
                <!--Ugly i know -->
                <table>
                    <tr>
                        <td>
                            <textarea maxlength="500" id="message"></textarea>
                            <div id="areacount">500</div>
                        </td>
                        <td>
                            <input type="hidden" value="<?php echo $_POST['name']; ?>" id="username">
                            <input type="hidden" value="<?php echo $row->insert_id; ?>" id="userid">
                            <input type="submit" id="submit" value="Send Message">
                            <?php
                                $q = "SELECT id FROM chat_message ORDER BY id DESC LIMIT 50";
                                $row = $db->query($q);
                                $startpoint = 0;

                                while($msg = $row->fetch_object()) {
                                    $startpoint = $msg->id;
                                }
                            ?>
                            <input type="hidden" value="<?php echo $startpoint; ?>" id="lastEntry">
                            <?php
                                $time = date("d.m.Y - H:i:s", $timestp);
                                $message = $username . " joined the chat";
                                $color = "rgb(0,0,0)";
                                $q = "INSERT INTO chat_message(name, color, message, time) VALUES (?,?,?,?)";
                                $row = $db->prepare($q);
                                $row->bind_param('ssss',$username, $color , $message ,$time);
                                $row->execute();
                            ?>
                        </td>
                    </tr>
                </table>
            </form>
            <!--Include color script and chat script-->
            <script type="text/javascript" src="js/color.js"></script>
            <script type="text/javascript" src="js/chat.js"></script>
        <?php
    }

} else {
    echo "Database Error:" .mysqli_connect_errno()." : ".mysqli_connect_error();
}
$db->close();