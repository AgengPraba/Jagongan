<?php
	session_start();
	include("include/connection.php");

	$sender = $_POST['sender_id'];
	$receiver = $_POST['receiver_id'];
	$message = $_POST['chat_content'];

	$output="";
	$insert = "INSERT INTO groups_chat (sender_id, receiver_id, chat_content, chat_date) VALUES ('$sender','$receiver','$message',NOW())";
	$result = mysqli_query($con, $insert);
	if($result){
		$output.="";
	}else{
		$output.="Error. Please try again";
	}
	echo $output;
?>