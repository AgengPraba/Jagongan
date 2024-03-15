<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">
    <?php 
            $user = $_SESSION['user_email'];
            $get_user=mysqli_query($con,"SELECT * FROM users WHERE user_email='$user'");
            $row=mysqli_fetch_assoc($get_user);
            $user_name = $row['user_name'];

            echo "<a class='navbar-brand' href='include/find_friends.php' style='margin-left:-40px;' ><i class='fas fa-arrow-left'
            style='color: white;'></i></a>"
            ?>
  </a>
  <ul class="navbar-nav">
    <li style>
      <p style="color: white; margin-left:630px; font-size:20px;" class="setting">Setting</p>
    </li>
  </ul>
</nav><br>