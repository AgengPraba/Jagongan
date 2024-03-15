    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create New Account</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="css/signup.css">
    </head>

    <body>
        <div class="signup-form">
            <form action="" method="post">
                <div class="form-header">
                    <h2>Sign Up</h2>
                    <p>Fill out this form</p>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="user_name" id="username" placeholder="example: john"
                        required>
                </div>
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" class="form-control" name="user_pass" id="pass" placeholder="Password"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" name="user_email" id="email"
                        placeholder="example@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select class="form-control" name="user_country" id="country" required>
                        <option value="countryCode">Country</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gender">Choose your gender</label><br>
                    <span>
                        <input type="radio" id="gender" name="user_gender" value="male">Male</span>
                    <input type="radio" id="gender" name="user_gender" value="female">Female


                </div>
                <div class="form-group">
                    <label><input type="checkbox" required>I accept the <a href="#">Terms of Use</a> &amp; <a
                            href="#">Privacy Policy</a></label>
                </div>

                <div class="form-group checkbox">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="sign_up">Sign Up</button>
                </div>


                <?php include ("signup_user.php"); ?>
            </form>
            <div class="text-center small" style="color: #4682A9">Already have an account? <a href="signin.php">Sign in
                    here</a></div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="include/countries.js"></script>
    </body>
    </body>

    </html>