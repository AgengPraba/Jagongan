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
  <title>Account Settings</title>
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
</head>

<body>
  <div class="row">
    <div class="col-sm-2">
    </div>
    <?php
        $user = $_SESSION['user_email'];
        $get_user = mysqli_query($con,"SELECT * FROM users WHERE user_email='$user'");
        $row=mysqli_fetch_assoc($get_user);

        $user_name = $row["user_name"];
        $user_pass = $row["user_pass"];
        $user_email = $row["user_email"];
        $user_profile = $row["user_profile"];
        $user_country = $row["user_country"];
        $user_gender= $row["user_gender"];
        ?>

    <div class="col-sm-8">
      <form action="" method="post" enctype="multipart/form-data">
        <table class="table table-bordered table-hover">
          <tr align="center">
            <td colspan="6" class="active">
              <h2>Change account settings</h2>
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Change your username</td>
            <td>
              <input type="text" name="u_name" class="form-control" required value="<?php echo $user_name; ?>">
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <a class="btn btn-default" style="text-decoration: none; font-size:15px;" href="upload.php"><i
                  class="fa fa-user" aria-hidden="true"></i>&nbsp;Change profile</a>
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Change your email</td>
            <td>
              <input type="email" name="u_email" class="form-control" required value="<?php echo $user_email; ?>">
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Country</td>
            <td>
              <select class="form-control" name="u_country" id="country" required>
                <script src="include/countries.js"></script>
              </select>
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Gender</td>
            <td>
              <select class="form-control" name="u_gender">
                <option value="male" <?php echo $user_gender=='male'?'selected':''; ?>>Male</option>
                <option value="female" <?php echo $user_gender=='female'?'selected':''; ?>>Female
                </option>
              </select>
            </td>
          </tr>
          <tr>
            <td style="font-weight: bold;">Forgotten password</td>
            <td>
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Forgotten
                password</button>
            </td>
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <form action="recovery.php?id=<?php echo $user_id; ?>" method="post" id="f">
                      <strong>What is your father name?</strong>
                      <input class="form-control" type="text" name="content" placeholder="someone">
                      <input class="btn btn-default" type="submit" name="submit" value="submit"
                        style="width: 100px;"><br><br>
                      <pre>Answer the above question we will ask you this question if you forgot your <br>Password.</pre>
                      <br><br>
                    </form>
                    <?php
if(isset($_POST['submit'])){
    $bfn=htmlentities($_POST['content']);
    if ($bfn == '') {
    echo "<script>alert('Please enter something!')</script>";
    echo "<script>window.open('account_settings.php'), '_self')</script>";
    exit();
    }else{
    $update = "UPDATE users SET forgotten_answer='$bfn' WHERE user_email='$user'";
    $run=mysqli_query($con,"$update");

    if($run){
      echo "<script>alert('Working...')</script>";
      echo "<script>window.open('account_settings.php','_self')</script>";
    }else{
      echo "<script>alert('Error while updating information.')</script>";
      echo "<script>window.open('account_settings.php','_self')</script>";
    }
    }
  }
?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </tr>
          <tr>
            <td></td>
            <td><a class="btn btn-default" href="change_password.php" style="text-decoration:none; font-size: 15px;"><i
                  class="fa fa-key fa-fw" aria-hidden="true"></i>&nbsp;Change password</a></td>
          </tr>

          <tr align="center">
            <td colspan="6">
              <input type="submit" value="update" name="update" class="btn btn-info">
            </td>
          </tr>
        </table>
      </form>
      <?php
      if (isset($_POST["update"])) {
        $user_name = htmlentities($_POST["u_name"]);
        $email = htmlentities($_POST["u_email"]);
        $u_gender = htmlentities($_POST["u_gender"]);
        $u_country = htmlentities($_POST["u_country"]);

        $update = "UPDATE users SET user_name='$user_name', user_email='$email', user_country='$u_country', user_gender='$u_gender' WHERE user_email='$user' ";
        $run = mysqli_query($con, "$update");

        if ($run) {
          echo "<script>window.open('account_settings.php', '_self')</script>";
        }
      }
      ?>
    </div>
    <div class="col-sm-2">

    </div>
  </div>
</body>

</html>