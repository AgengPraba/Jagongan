<?php
session_start();
include("include/connection.php");
include("include/header.php");
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
  <title>Change profile picture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/44604b8181.js" crossorigin="anonymous"></script>

  <!-- BOOSTRAP 3 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
    integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
  </script>
  <!-- ------------ -->
  <link rel="stylesheet" href="css/find_friends.css">
</head>

<body>
  <?php
  $user = $_SESSION['user_email'];
  $get_user = mysqli_query($con,"SELECT * FROM users WHERE user_email='$user'");
  $row=mysqli_fetch_assoc($get_user);

  $user_name = $row["user_name"];
  $user_profile = $row["user_profile"];

  echo "
    <div class='card'>
    <img src='images/$user_profile'>
    <h1>$user_name</h1>
      <form action='' method='post' enctype='multipart/form-data'>
        <label for='update_profile'>
         Select profile
          <input type='file' name='u_image' size='60' style='margin-left:60px;'>
        </label>
        <button id='button_profile' name='update'>Update profile</button>
      </form>
    </div><br><br>
  ";

  if(isset($_POST['update'])){
    $u_image = $_FILES['u_image']['name'];
    $image_tmp = $_FILES['u_image']['tmp_name'];

    if($u_image==''){
      echo "<script>alert('Please select your profile picture!')</script>";
      echo "<script>window.open('upload.php','_self')</script>";
      exit();
    }else{
      move_uploaded_file($image_tmp, "images/".$u_image);

      $update="UPDATE  users SET user_profile='$u_image' WHERE user_email='$user'";

      $run=mysqli_query($con,$update);

      if($run){
        echo "<script>alert('Your profile updated!')</script>";
        echo "<script>window.open('upload.php','_self')</script>";
      }
    }
  }
  ?>
</body>

</html>