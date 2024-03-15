<?php
session_start();
include("include/connection.php");
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
  <title>Jagongan - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="css/home.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/44604b8181.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container-fluid main-section">
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-12 left-sidebar">
        <div class="input-group searchbox">
          <div class="input-group-btn">
            <center><a href="include/find_friends.php"><button class="btn btn-default search-icon" name="search_user"
                  type="submit">Dashboard</button></a></center>
          </div>
        </div>
        <div class="left-chat">
          <ul>
            <?php include("include/get_users_data.php"); ?>
          </ul>
        </div>
      </div>
      <div class="col-md-9 col-sm-9 col-xs-12 right-sidebar">
        <div class="row">
          <!-- getting the user information who is logged in -->
          <?php
                    $user = $_SESSION['user_email'];
                    $get_user = "SELECT * FROM users WHERE user_email='$user'";
                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);
                    $user_id = $row['user_id'];
                    $user_name = $row['user_name'];
                    $user_id= $row['user_id'];
          $_SESSION['user_name'] = $user_name;
          $_SESSION['user_id'] = $user_id;
                    ?>
          <input type="text" id="sender_username" value="<?php  echo $user_name; ?>" hidden>
          <!-- getting the user data on which user click -->
          <?php
                    if (isset($_GET['user_name'])) {

                        global $con;

                        $get_username = $_GET['user_name'];
                        $get_user = "select * from users where user_name='$get_username'";
                        $run_user = mysqli_query($con, $get_user);
                        $row_user = mysqli_fetch_array($run_user);
                        $username = $row_user['user_name'];
                        $user_profile_image = 'images/'.$row_user['user_profile'];
                    }
                    $total_messages = "SELECT * FROM users_chat WHERE (sender_username='$user_name' AND receiver_username='$username') OR (receiver_username='$user_name' AND sender_username='$username')";
                    $run_messages = mysqli_query($con, $total_messages);
                    $total = mysqli_num_rows($run_messages);
                    ?>

          <input type="text" id="receiver_username" value="<?php  echo $username; ?>" hidden>

          <div class="col-md-12 right-header">
            <div class="right-header-img">
              <img src="<?php echo "$user_profile_image"; ?>">
            </div>
            <div class="right-header-detail">
              <form method="post">
                <p style="color:white;"><?php echo "$username"; ?></p>
                <span><?php echo $total; ?>&nbsp;messages</span>&nbsp; &nbsp;
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div id="scrolling_to_bottom" class="col-md-12 right-header-contentChat">
            <div id="container-chat">
              <?php

                        $update_msg = mysqli_query($con, "UPDATE users_chat SET msg_status='read' WHERE sender_username='$username' AND receiver_username='$user_name'");

                       $sel_msg = "SELECT * FROM users_chat WHERE (sender_username='$user_name' AND receiver_username='$username') OR (receiver_username='$user_name' AND sender_username='$username') ORDER BY 1 ASC";
 
                        $run_msg = mysqli_query($con, $sel_msg);

                        while ($row = mysqli_fetch_array($run_msg)) {
                            $sender_username = $row['sender_username'];
                            $receiver_username = $row['receiver_username'];
                            $msg_content = $row['msg_content'];
                            $msg_date = $row['msg_date'];
                            ?>
              <ul>
                <?php
                            if ($user_name == $sender_username and $username == $receiver_username) {
                                echo "
                                <li>
                                    <div class='rightside-right-chat'>
                                    <span>$user_name<small>$msg_date</small></span><br><br>
                                    <p>$msg_content</p>
                                    </div>
                                    
                                </li>
                                ";
                            } else if ($user_name == $receiver_username and $username == $sender_username) {
                                echo "
                                <li>
                                    <div class='rightside-left-chat'>
                                    <span>$username <small>$msg_date</small></span><br><br>
                                    <p>$msg_content</p>
                                    </div>
                                </li>
                                ";
                            }

                            ?>
              </ul>
              <?php
                        }
                        ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 right-chat-text-box">
            <form method="post">
              <input type="text" id="msg_content" name="msg_content" autocomplete="off"
                placeholder="Write your message...">
              <button class="btn-primary" id="send" name="submit"><i class="fa fa-telegram fa-xl"
                  aria-hidden="true"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  <script>
  $(document).ready(function() {
    $("#send").on("click", function() {
      $.ajax({
        url: "insertMessage.php",
        method: "POST",
        data: {
          sender_username: $("#sender_username").val(),
          receiver_username: $("#receiver_username").val(),
          msg_content: $("#msg_content").val()
        },
        dataType: "text",
        success: function(data) {
          $("#msg_content").val("");

        }
      });
    });
    setInterval(function() {

      $.ajax({
        url: "realTimeChat.php",
        method: "POST",
        data: {
          sender_username: $("#sender_username").val(),
          receiver_username: $("#receiver_username").val(),
        },
        dataType: "text",
        success: function(data) {
          $("#container-chat").html(data);
        }
      });
    }, 100);
  });
  </script>

  <script>
  $('#scrolling_to_bottom').animate({
    scrollTop: $('#scrolling_to_bottom').get(0).scrollHeight
  }, 100);
  </script>
  <script type="text/javascript">
  $(document).ready(function() {
    var height = $(window).height();
    $('.left-chat').css('height', (height - 92) + 'px');
    $('.right-header-contentChat').css('height', (height - 163) + 'px');
  })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
  </script>


</body>

</html>
<?php /*}*/ ?>