<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE AND E_DEPRECATED);
include("connection.php");
include("find_friends_function.php");
if(!isset($_SESSION['signin'])){
    header('Location:signin.php');
    exit();
}

?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/find_friends.css">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/44604b8181.js" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">
      <?php 
            $user = $_SESSION['user_email'];
            $get_user=mysqli_query($con,"SELECT * FROM users WHERE user_email='$user'");
            $row=mysqli_fetch_assoc($get_user);
            $user_name = $row['user_name'];
            $user_id=$row['user_id'];

      $group =mysqli_query($con,"SELECT * FROM `groups_member` WHERE user_id=$user_id ORDER BY group_id ASC LIMIT 1;");
            $run=mysqli_fetch_assoc($group);
      $group_id = $run['group_id'];

            echo "<a class='navbar-brand' href='../home.php?user_name=$user_name'><i class='fas fa-arrow-left'
            style='color: white;'></i></a>"
            ?>
    </a>
    <ul class="navbar-nav">
      <li>
        <a style="color: white; text-decoration: none; font-size:20px" href="../create_group.php" id="group">Create
          Group</a>
      </li>
      <li>
        <a style="color: white; text-decoration: none; font-size:20px"
          href="../group_chat.php?group_id=<?php echo $group_id;?>" id="group_chat">Group</a>
      </li>
      <li>
        <a style="color: white; text-decoration: none; font-size:20px" href="../status.php ?>" id="status">Status</a>
      </li>
      <li>
        <a style="color: white; text-decoration: none; font-size:20px" href="../account_settings.php"
          id="setting">Setting</a>
      </li>
      <li>
        <a style="color: white; text-decoration: none; font-size:20px" href="../logout.php" id="logout">Logout</a>
      </li>
    </ul>
  </nav><br>
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <form class="search-form" action="" method="get">
        <input name="search_query" type="search" class="search-input" placeholder="Search Friends" autocomplete="off"
          required>
        <button class="search-btn" type="submit" name="search_btn">Search</button>
      </form>
    </div>
    <div class="col-sm-4"></div>
  </div><br><br>
  <?php
    search_user();
    ?>
</body>

</html>