<?php
	session_start();
    error_reporting(E_ALL ^ E_NOTICE AND E_DEPRECATED);
	include("include/connection.php");
	$user_id = $_POST['sender_id'];
	$group_id = $_POST['receiver_id'];
    $output = '';


     $sel_msg = "SELECT chat_id,sender_id,receiver_id,chat_content,chat_date,user_name,user_profile FROM groups_chat AS t1 JOIN users AS t2  ON t1.sender_id=t2.user_id  WHERE receiver_id=$group_id ORDER BY 1 ASC";

    $run_msg = mysqli_query($con, $sel_msg);

    while ($row = mysqli_fetch_array($run_msg)) {
    $sender_id = $row['sender_id'];
    $sender_name = $row['user_name'];
    $receiver_id = $row['receiver_id'];
    $chat_content = $row['chat_content'];
    $chat_date = $row['chat_date'];
    ?>
<ul>
  <?php
            if ($user_id == $sender_id and $group_id == $receiver_id) {
                echo "
                <li>
                    <div class='rightside-right-chat'>
                    <span>$sender_name<small>$chat_date</small></span><br><br>
                    <p>$chat_content</p>
                    </div>
                </li>
                ";
            } else  {
                echo "
                <li>
                    <div class='rightside-left-chat'>
                    <span>$sender_name <small>$chat_date</small></span><br><br>
                    <p>$chat_content</p>
                    </div>
                </li>
                ";
            }

                            ?>
</ul>
<?php
}
echo $output;
?>