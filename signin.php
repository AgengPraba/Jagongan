<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/signin.css">
</head>

<body>
    <div class="signin-form">
        <form action="signin_user.php" method="post">
            <div class="form-header">
                <h2>Sign In</h2>
                <p>Login to Jagongan</p>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com"
                    required>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required>
            </div>
            <div class="small">Forgot password? <a href="forgot_pass.php">Click here</a></div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg" name="sign_in">Sign In</button>
            </div>
            <?php include ("signin_user.php"); ?>
        </form>
        <div class="text-center small" style="color: #4682A9">Don't have an account? <a href="signup.php">Create an account</a></div>
    </div>

    <!-- <script>
    $(document).ready(function(){
        alert(1);
    })
</script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>