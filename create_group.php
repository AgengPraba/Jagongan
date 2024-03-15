<?php
session_start();
include("include/connection.php");
$user_email = $_SESSION['user_email'];
$user_name=mysqli_query($con,"SELECT * FROM users WHERE user_email='$user_email'");
$run=mysqli_fetch_array($user_name);
$_SESSION['user_name']=$run['user_name'];
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
  <title>Create Group</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/44604b8181.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="include/create_group.css">
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="include/find_friends.php">
      <i class='fas fa-arrow-left' style='color: white; margin-left:20px'></i> </a>
    <ul class="navbar-nav">
      <li style>
        <p style="color: white; margin-left:600px; font-size:20px;" class="setting">Create Group</p>
      </li>
    </ul>
  </nav>
  <div class="form-box">
    <form action="add_members.php" method="post" enctype="multipart/form-data" class="box-form">
      <span>
        <label>Group Name :</label>
        <input type=" text" name="group_name" required>
      </span><br><br>
      <span>
        <label>Group Profile :</label>
        <input type="file" name="group_profile">
      </span>
      <br><br>
      <button type="submit" name="submit">Next</button>
    </form>

  </div>
</body>

</html>