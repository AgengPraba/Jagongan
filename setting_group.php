<?php
session_start();
include("include/connection.php");
$_SESSION['user_name'];
$user_id = mysqli_fetch_assoc(mysqli_query($con, "SELECT user_id FROM users WHERE user_name='$_SESSION[user_name]' LIMIT 1"));

$group_id = $_GET['group_id'];
$sql = "SELECT t1.group_id,t1.user_id,role,group_name,group_profile,user_name  FROM groups_member AS t1
        JOIN groups AS t2 ON t1.group_id=t2.group_id
        JOIN users AS t3 ON t1.user_id=t3.user_id
        WHERE t1.group_id=$group_id LIMIT 1";
$run = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($run);
$group_name = $row['group_name'];
$group_profile = $row['group_profile'];

if(isset($_POST['save'])){
  $group_name=$_POST['group_name'];
  $group_profile=$_FILES['group_profile']['name'];
  $profile_tmp=$_FILES['group_profile']['tmp_name'];
  move_uploaded_file($profile_tmp, "images/".$group_profile);

  $sql="UPDATE groups SET group_name='$group_name',group_profile='$group_profile' WHERE group_id=$group_id ";
  $run = mysqli_query($con, $sql);
  if($run){
    echo "<script>alert('Updated is success!')</script>"; 
    header('location:group_chat.php?group_id='.$group_id);
}
}

if(isset($_GET['del'])){
  $group_id = $_GET['group_id'];
  $sql = "DELETE FROM groups_member WHERE user_id=$_GET[del]";
  $run = mysqli_query($con, $sql);
  header("location:setting_group.php?group_id=$group_id");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Setting group</title>
</head>

<body>
  <form action="" method="post" enctype="multipart/form-data">
    <label>Group name :</label>
    <input type="text" name="group_name" required value="<?= $group_name; ?>">
    <label>Profile Picture :</label>
    <input type="file" name="group_profile" value="<?= $group_profile; ?>">
    <input type="submit" name="save" value="save">
  </form>
  <br>
  <?php
  $row = mysqli_query($con, "SELECT * FROM groups_member WHERE group_id=$group_id");
  $total=mysqli_num_rows($row);
  ?>
  <p>Total members: <?=$total?> </p><br>
  <h3>Members:</h3>
  <?php
  $admin_group = mysqli_fetch_assoc(mysqli_query($con, "SELECT user_id FROM groups_member WHERE group_id=$group_id AND role='admin' LIMIT 1"));
  $sql = "SELECT t1.group_id,t1.user_id,role,group_name,group_profile,user_name  FROM groups_member AS t1
        JOIN groups AS t2 ON t1.group_id=t2.group_id
        JOIN users AS t3 ON t1.user_id=t3.user_id
        WHERE t1.group_id=$group_id";
  $run = mysqli_query($con, $sql);
  ?><table border='1' cellspacing='0'>
    <?php
    while($member=mysqli_fetch_assoc($run)){
    echo "

    <tr>
      <td >$member[user_id]</td>
      <td >$member[user_name]</td>
      <td >$member[role]</td>";

      if($member['user_id']!=$admin_group['user_id']){
      echo "<td ><a href='?del=$member[user_id]&group_id=$member[group_id]'>delete</a></td>";
      }else{
      echo "<td></td>";
      }
      
      echo"
    </tr>
  ";
  }

  ?>
  </table>

  <a href="add_members.php?group_id=<?= $group_id ?>">Add member</a>

</body>

</html>