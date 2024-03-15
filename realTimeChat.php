<?php
	session_start();
	include("include/connection.php");
	$user_name = $_POST['sender_username'];
	$username = $_POST['receiver_username'];
    $output = '';

	 $update_msg = mysqli_query($con, "UPDATE users_chat SET msg_status='read' WHERE sender_username='$username' AND receiver_username='$user_name'");

    $sel_msg = "SELECT * FROM users_chat WHERE (sender_username='$user_name' AND receiver_username='$username') OR (receiver_username='$user_name' AND sender_username='$username') ORDER BY 1 ASC";
 
    $run_msg = mysqli_query($con, $sel_msg);

    // if(isset($_POST['del'])){
    // $msg_id = $_POST['msg_id'];
    // $del_msg=mysqli_query($con, "DELETE FROM users_chat WHERE msg_id=$msg_id");
    // echo $del_msg;
    // }
   
	while($row = mysqli_fetch_assoc($run_msg)){
		$sender_username = $row['sender_username'];
        $receiver_username = $row['receiver_username'];
        $msg_content = $row['msg_content'];
        $msg_date = $row['msg_date'];
        ?>
<ul>
  <?php
    if ($user_name == $sender_username and $username == $receiver_username) {
        $output.= "
        <li style='list-style: none;'>
            <div class='rightside-right-chat'>
            <span>$user_name<small>$msg_date</small></span><br><br>
            <p>$msg_content</p>
        </li>
        ";
    } else if ($user_name == $receiver_username and $username == $sender_username) {
        $output.="
        <li style='list-style: none;'>
            <div class='rightside-left-chat'>
            <span>$username <small>$msg_date</small></span><br><br>
            <p>$msg_content</p>
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