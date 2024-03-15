<?php
session_start();
include("include/connection.php");

    if (isset($_POST['submit'])) {
      $creator = $_SESSION['user_name'];
      $creator_id=mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM users where user_name='$creator'"));
      $creator_id=$creator_id["user_id"];
    $group_name=htmlentities(mysqli_real_escape_string($con, $_POST['group_name']));
      $group_profile = $_FILES['group_profile']['name'];
      $group_profile_tmp = $_FILES['group_profile']['tmp_name'];
      move_uploaded_file($group_profile_tmp, 'images/'.$group_profile);

      $sql="INSERT INTO groups (group_name,creator,date_created,group_profile) VALUES ('$group_name','$creator',NOW(),'$group_profile')";
      $result = mysqli_query($con, $sql);
      if($result){
        $sql = "SELECT * FROM groups WHERE creator='$creator' ORDER BY date_created DESC LIMIT 1";
        $result = mysqli_query($con, $sql);
        $row=mysqli_fetch_array($result);
        $group_id = $row['group_id'];

        $admin=mysqli_query($con,"INSERT INTO groups_member (group_id,user_id,role,date_join) VALUES ('$group_id','$creator_id','admin',NOW())");
        header("location:add_members.php?group_id='$group_id'");
      }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Members</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/44604b8181.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="css/add_members.css">
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">
          <li style>
            <p style="color: white; margin-left:600px; font-size:20px;" class="setting">Add Member</p>
          </li>
        </ul>
      </nav>
      <div class="col"></div>
      <div class="col-6">
        <div class="left-chat">
          <form action="" method="post">
            <ul>
              <?php
$user = "SELECT * FROM users ORDER BY user_name ASC";

$run_user = mysqli_query($con, $user);

while ($row_user = mysqli_fetch_array($run_user)) {
    $group_id = $_GET['group_id'];
    $user_id = $row_user['user_id'];
    $user_name = $row_user['user_name'];
    $user_profile = $row_user['user_profile'];
    $login = $row_user['log_in'];

    // Gunakan fungsi mysqli_real_escape_string untuk melindungi dari SQL injection

    // Query untuk memeriksa apakah user bukan bagian dari grup
    $check_query = "SELECT * FROM groups_member WHERE group_id = $group_id AND user_id = '$user_id'";
    $check_result = mysqli_query($con, $check_query);


    // Periksa apakah user bukan bagian dari grup tersebut
    if (mysqli_num_rows($check_result) == 0) {
        echo "
            <li onclick='add(this)'>
                <div class='chat-left-img'>
                    <img src='images/$user_profile'>
                </div>
                <div class='chat-left-details'>
                    <p style='color:black;'>$user_name</p>";

        if ($login == 'online') {
            echo "<span><i class='fa fa-circle' aria-hidden='true'></i>Online</span>";
        } else {
            echo "<span><i class='fa fa-circle-o' aria-hidden='true'></i>Offline</span>";
        }

        echo "
                </div>
                <div  class='checkbox'>
                    <input name='user[]' type='checkbox' value='$user_id'>
                </div>
            </li>
        ";
    }
}
  

?>
            </ul>
            <input name="add" type="submit" value="Add">
          </form>

          <?php
          $group_id = $_GET['group_id'];
          if (isset($_POST["add"])) {        
             $selectedUsers = isset($_POST['user']) ? $_POST['user'] : [];
              foreach($selectedUsers as $user) {
              $sql = "INSERT INTO groups_member (group_id,user_id,role,date_join) VALUES ($group_id,'$user','member',NOW())";
             
              mysqli_query($con, $sql);
    }
echo "<script>document.location='group_chat.php?group_id=$group_id'</script>";
          }
          ?>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>
  <script>
  function add(user) {
    var checkbox = user.querySelector('input[type="checkbox"]')
    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
      user.style.backgroundColor = "#86bb71"; // Ganti warna jika checkbox dicentang
    } else {
      user.style.backgroundColor = ""; // Kembali ke warna awal jika checkbox tidak dicentang
    }
  }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>