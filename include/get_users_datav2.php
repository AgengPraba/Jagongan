<?php

$con = mysqli_connect("localhost", "root", "", "jagongan");

$get_sender=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM users WHERE user_email='$_SESSION[user_email]' LIMIT 1"));
$sender= $get_sender["user_name"];
$recent_msg = "SELECT MAX(t1.msg_id) AS msg_id, t1.sender_username, t1.receiver_username, t1.msg_content, MAX(t1.msg_date) AS latest_msg_date, t2.user_id, t2.user_name, t2.user_email, t2.user_profile, t2.log_in
FROM users_chat AS t1
JOIN users AS t2 ON t1.sender_username = t2.user_name
WHERE t1.msg_id IN (SELECT MAX(msg_id) FROM users_chat GROUP BY sender_username) AND (t1.sender_username = '$sender' OR t1.receiver_username = '$sender')
GROUP BY  t1.sender_username,t1.receiver_username, t2.user_id, t2.user_name, t2.user_email, t2.user_profile, t2.log_in
ORDER BY latest_msg_date DESC;

";
$run = mysqli_query($con, $recent_msg);

while ($row = mysqli_fetch_array($run)) {
    $user_id = $row['user_id'];
    $user_name = ($row["receiver_username"] == $_SESSION["user_name"]) ? $row['sender_username'] : $row['receiver_username'];
    $user_profile = $row['user_profile'];
    $login = $row['log_in'];

    
    echo "<li>";
    echo "<div class='chat-left-img'>";
    echo "<img src='images/$user_profile'>";
    echo "</div>";
    echo "<div class='chat-left-details'>";
    echo "<p><a href='home.php?user_name=$user_name'>$user_name</a></p>";

    if ($login == 'online') {
        echo "<span><i class='fa fa-circle' aria-hidden='true'></i>Online</span>";
    } else {
        echo "<span><i class='fa fa-circle-o' aria-hidden='true'></i>Offline</span>";
    }

    echo "</div>";
    echo "</li>";


}

?>