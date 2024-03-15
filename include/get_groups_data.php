<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "jagongan");
$user = $_SESSION['user_email'];
$get_user = "SELECT * FROM users WHERE user_email='$user'";
$run_user = mysqli_query($con, $get_user);
$row = mysqli_fetch_array($run_user);
$user_id = $row['user_id'];
$user_name = $row['user_name'];
$_SESSION['user_name'] = $user_name;
$_SESSION['user_id'] = $user_id;

$groups = "SELECT * FROM groups_member AS t1 JOIN users As t2 ON t1.user_id=t2.user_id JOIN groups AS t3 ON t1.group_id=t3.group_id WHERE t1.user_id=$_SESSION[user_id] ORDER BY group_name ASC";
$run_group=mysqli_query($con,$groups);


while($row_group=mysqli_fetch_assoc($run_group)){
    $group_id = $row_group['group_id'];
    $group_name = $row_group['group_name'];
    $group_profile = $row_group['group_profile'];

    echo "
        <li>
            <div class='chat-left-img'>
            <img src='images/$group_profile'>
            </div>
            <div class='chat-left-details'>
            <p><a href='group_chat.php?group_id=$group_id'>$group_name</a></p>
            </div>
        </li>
    ";
        
}

?>