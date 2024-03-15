<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/signin.css">
</head>

<body>
    <div class="signin-form">
        <form action="" method="post">
            <div class="form-header">
                <h2>Create New Password</h2>
                <p>Jagongan</p>
            </div>
            <div class="form-group">
                <label>Enter password</label>
                <input type="password" class="form-control" name="pass1" placeholder="password"
                    required>
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password" class="form-control" name="pass2"  placeholder="Confirm password" autocomplete="off" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg" name="change">Change</button>
            </div>
        </form>
    </div>
    <?php
      session_start();
      include("include/connection.php");
      
      if(isset($_POST['change'])){
      $user = $_SESSION['user_email'];
      $pass1 = $_POST['pass1'];
      $pass2 = $_POST['pass2'];

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
      if ($pass1 == $pass2) {
        $update_pass=mysqli_query($con,"UPDATE users SET user_pass='$pass1' WHERE user_email='$user'");
        session_destroy();

        echo "<script>alert('Go ahead and signin')</script>";
        echo "<script>window.open('signin.php', '_self')</script>";
      }
    }
    ?>
</body>

</html>