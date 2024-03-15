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
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/44604b8181.js" crossorigin="anonymous"></script>

<!-- BOOSTRAP 3 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- ------------ -->
<style>
  body{
  overflow-x:hidden;
  }

</style>
</head>

<body>
  <div class="row">
    <div class="col-sm-2"></div>
    <?php
      $user = $_SESSION['user_email'];
      $get_user = mysqli_query($con,"SELECT * FROM users WHERE user_email='$user'");
      $row=mysqli_fetch_assoc($get_user);
    
      $user_name = $row["user_name"];
      $user_profile = $row["user_profile"];

    ?>
    <div class="col-sm-8">
      <form action="" method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-hover">
          <tr align="center">
            <td colspan="6" class="active">
              <h2>Change Password</h2>
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Current password</td>
            <td>
              <input type="password" name="current_pass" id="mypass" class="form-control" required placeholder="current password">
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">New password</td>
            <td>
              <input type="password" name="u_pass1" id="mypass" class="form-control" required placeholder="New password">
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Confirm password</td>
            <td>
              <input type="password" name="u_pass2" id="mypass" class="form-control" required placeholder="confirm password">
            </td>
          </tr>
          <tr align="center">
            <td colspan="6">
              <input type="submit" name="change" value="change" class="btn btn-info" />
            </td>
          </tr>
        </table>
      </form>
      <?php
        if(isset($_POST['change'])){
        $c_pass = $_POST['current_pass'];
        $pass1 = $_POST['u_pass1'];
        $pass2 = $_POST['u_pass2'];

        $user=$_SESSION['user_email'];
        $get_user=mysqli_query($con,"SELECT * FROM users WHERE user_email='$user'");
        $row=mysqli_fetch_assoc($get_user);
        $user_password = $row["user_pass"];

        if($c_pass!==$user_password){
          echo "
            <div class='alert alert-danger'>
              <strong>Your old password didn't match!</strong>
            </div>
          ";
        }
        if($pass1!=$pass2){
          echo "
            <div class='alert alert-danger'>
              <strong>Your new password didn't match with confirm password!</strong>
            </div>
          ";
        }
        if($pass1<9 AND $pass2<9){
          echo "
            <div class='alert alert-danger'>
              <strong>Password must contains 9 or more characters!</strong>
            </div>
          ";
        }
        if($pass1==$pass2 AND $c_pass==$user_password){
          $update_pass=mysqli_query($con,"UPDATE users SET user_pass='$pass1' WHERE user_email='$user'");
          echo "<script>window.open('change_password.php','_self')</script>";
          echo "
            <div class='alert alert-success'>
              <strong>Change password is success!</strong>
            </div>
          ";
        }
      }
      ?>
    </div>
    <div class="col-sm-2"></div>
  </div>
</body>
</html>