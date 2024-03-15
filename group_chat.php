<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE AND E_DEPRECATED);
include("include/connection.php");
if (!isset($_SESSION['signin'])) {
  header('Location:signin.php');
  exit();
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Group Chat</title>
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
            <?php include("include/get_groups_data.php"); ?>
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
          $user_id = $_SESSION['user_id'];
                    ?>
          <input type="text" id="sender_id" value="<?php  echo $user_id; ?>" hidden>
          <!-- getting the group data on which user click -->
          <?php
                    if (isset($_GET['group_id'])) {

                        global $con;

                        $group_id = $_GET['group_id'];
                        $get_groups = "SELECT * FROM groups_member AS t1 JOIN users As t2 ON t1.user_id=t2.user_id JOIN groups AS t3 ON t1.group_id=t3.group_id WHERE t1.user_id=$_SESSION[user_id] ORDER BY group_name ASC";
                        $run_groups = mysqli_query($con, $get_groups);
                        $row_groups = mysqli_fetch_array($run_groups);
                        $group_name = $row_groups['group_name'];
                        $group_profile_image = 'images/'.$row_groups['group_profile'];
                    }
                    
                    ?>

          <input type="text" id="receiver_id" value="<?php  echo $group_id; ?>" hidden>

          <div class="col-md-12 right-header">
            <div class="right-header-img">
              <img src="<?php echo "$group_profile_image"; ?>">
            </div>
            <div class="right-header-detail">
              <form method="post">
                <a href="setting_group.php?group_id=<?php echo $group_id ?>" style="text-decoration:none;">
                  <p style="color:white;"><?php echo "$group_name"; ?></p>
                </a>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div id="scrolling_to_bottom" class="col-md-12 right-header-contentChat">
            <div id="container-chat">
              <?php
              $sel_msg = "SELECT chat_id,sender_id,receiver_id,chat_content,chat_date,user_name,user_profile FROM groups_chat AS t1 JOIN users AS t2  ON t1.sender_id=t2.user_id  WHERE receiver_id=$group_id ORDER BY 1 ASC";

    $run_msg = mysqli_query($con, $sel_msg);

    while ($row = mysqli_fetch_array($run_msg)) {
    $sender_id = $row['sender_id'];
    $sender_name = $row['user_name'];
    $receiver_id = $row['receiver_id'];
    $chat_content = $row['chat_content'];
    $chat_date = $row['chat_date'];
    ?>
              <ul>
                <?php
            if ($user_id == $sender_id and $group_id == $receiver_id) {
                echo "
                <li>
                    <div class='rightside-right-chat'>
                    <span>$sender_name<small>$chat_date</small></span><br><br>
                    <p>$chat_content</p>
                    </div>
                </li>
                ";
            } else  {
                echo "
                <li>
                    <div class='rightside-left-chat'>
                    <span>$sender_name <small>$chat_date</small></span><br><br>
                    <p>$chat_content</p>
                    </div>
                </li>
                ";
            }

                            ?>
              </ul>
              <?php
}
echo $output;
?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 right-chat-text-box">
            <form method="post">
              <input type="text" id="chat_content" name="msg_content" autocomplete="off"
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
        url: "insertMessageGroup.php",
        method: "POST",
        data: {
          sender_id: $("#sender_id").val(),
          receiver_id: $("#receiver_id").val(),
          chat_content: $("#chat_content").val()
        },
        dataType: "text",
        success: function(data) {
          $("#chat_content").val("");

        }
      });
    });
    setInterval(function() {

      $.ajax({
        url: "realTimeChatGroup.php",
        method: "POST",
        data: {
          sender_id: $("#sender_id").val(),
          receiver_id: $("#receiver_id").val(),
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