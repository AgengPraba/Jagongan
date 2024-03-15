<?php
	session_start();
	include("include/connection.php");

	$sender = $_POST['sender_username'];
	$receiver = $_POST['receiver_username'];
	$message = $_POST['msg_content'];

	$output="";
	$insert = "INSERT INTO users_chat (sender_username, receiver_username, msg_content, msg_status, msg_date) VALUES ('$sender','$receiver','$message','unread',NOW())";
	$result = mysqli_query($con, $insert);
	if($result){
		$output.="";
	}else{
		$output.="Error. Please try again";
	}
	echo $output;
?>