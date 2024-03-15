<?php
include("connection.php");

function search_user(){

    global $con;

    if(isset($_GET['search_btn'])){
        $search_query=htmlentities($_GET['search_query']);
        $get_user="SELECT * FROM users WHERE user_name LIKE '%$search_query%' OR user_country LIKE '%$search_query%'";
    }else{
        $get_user="SELECT * FROM users ORDER BY user_country, user_name DESC LIMIT 5";
    }

    $run_user=mysqli_query($con,$get_user);

    while ($row = mysqli_fetch_assoc($run_user)) {
        $user_name = $row['user_name'];
        $user_profile = 'images/'.$row['user_profile'];
        $country = $row['user_country'];
        $gender = $row['user_gender'];

        echo "
        <div class='card'>
            <img src='../$user_profile'>
            <h1>$user_name</h1>
            <p class='title'>$country</p>
            <p>$gender</p>
            <form method='post'>
                <p style='background-color:black;padding:10px '><a href='../home.php?user_name=$user_name' style='color:white;font-size:18px;'>Chat with $user_name</a></p>
            </form>
        </div><br><br>
        ";

    }

}
?>