
<?php

$con = mysqli_connect("localhost", "root", "", "jagongan");

$user = "select * from users order by user_name ASC";

$run_user = mysqli_query($con, $user);

while($row_user=mysqli_fetch_array($run_user)){
    $user_id = $row_user['user_id'];
    $user_name = $row_user['user_name'];
    $user_profile = $row_user['user_profile'];
    $login = $row_user['log_in'];

    echo "
        <li>
            <div class='chat-left-img'>
            <img src='images/$user_profile'>
            </div>
            <div class='chat-left-details'>
            <p><a href='home.php?user_name=$user_name' style='text-decoration:none; color: white'>$user_name</a></p> ";

            if($login=='online'){
                echo "<span><i class='fa fa-circle' aria-hidden='true'></i>Online</span>";
            }else{
                echo "<span><i class='fa fa-circle-o' aria-hidden='true'></i>Offline</span>";
            }
            "
            </div>
        </li>
    ";
        
}

?>