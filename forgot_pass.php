<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
                <h2>Forgot Password</h2>
                <p>Jagongan</p>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com"
                    required>
            </div>
            <div class="form-group">
                <label>Father's name</label>
                <input type="text" class="form-control" name="fn"  placeholder="Someone..." autocomplete="off" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg" name="submit">Submit</button>
            </div>
        </form>
        <div class="text-center small" style="color: #4682A9">Back to Sign In? Sign In<a href="signin.php">&nbsp;click here</a></div>
    </div>
    <?php
      session_start();
      include("include/connection.php");
      if(isset($_POST['submit'])){
        $email=htmlentities(mysqli_real_escape_string($con,$_POST['email']));
        $recovery_account=htmlentities(mysqli_real_escape_string($con,$_POST['fn']));

      $select = "SELECT * FROM users WHERE user_email='$email' AND forgotten_answer='$recovery_account'";

      $query=mysqli_query($con,$select);
      $check_user=mysqli_num_rows($query);

      if ($check_user == 1) {
        $_SESSION['user_email'] = $email;
        echo "<script>window.open('create_password.php', '_self')</script>";
      }else{
        echo "<script>alert('Your email or father`s name is incorrect!')</script>";
        echo "<script>window.open('forgot_pass.php', '_self')</script>";
      }
    }
    ?>
</body>

</html>