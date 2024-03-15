<?php
    include("include/connection.php");
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    $username=$_SESSION['username'];
    $sql="SELECT * FROM users WHERE user_name='$username'";
    $result=mysqli_query($con, $sql);
    while($row=mysqli_fetch_assoc($result)){
        $gambar=$row['user_profile'];
        $email=$row['user_email'];
    }

    if(isset($_POST['submit'])){
        $status=$_POST['tweet'];
        $tanggal=date("Y-m-d H:i:s");
        $foto = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($file_tmp, 'images/'. $foto);
        $sql="INSERT INTO status(pengirim, isi, tanggal, gambar) VALUES('$username', '$status', '$tanggal', '$foto')";
        $result=mysqli_query($con, $sql);
        header("location: status.php");
    }
?>

<!doctype html>
<html lang="eng">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css"
    integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
  <link rel="stylesheet" href="status.css">

  <!-- Font css -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900& display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <title>Status</title>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
      <li>
        <a href="include/find_friends.php" title="Back"><i class="fas fa-arrow-left"
            style="color: white; margin-top:16px"></i></a>
      </li>

      <li>
        <p style="color: white; text-decoration: none; font-size:20px; margin-left:630px; margin-top:10px">Status</p>
      </li>
    </ul>
  </nav>

  </div>
  <!-- Navbar end -->
  <div class="status container-fluid min-vh-100">
    <!-- Tweeet -->
    <div class="row card shadow-sm mb-2">
      <form action="status.php" method="POST" enctype="multipart/form-data">
        <div class="row d-flex justify-content-between align-items-start">
          <div class="kolom1 col-1 d-flex">
            <img src="images/<?php echo $gambar; ?>" alt="profile" class="mt-3" id="img-sender">
          </div>
          <div class="kolom2 col-10 d-flex mt-3">
            <textarea class="form-control" name="tweet" rows="3" placeholder="What's happening?" required></textarea>
          </div>
          <div class="kolom3 col-1 d-flex">
            <div class="row mt-3">
              <button class="btn btn-dark" type="submit" name="submit"><i class="fa fa-paper-plane fs-6"></i></button>
            </div>
          </div>
          <label for="image-input" class="custom-file-upload">
            <img src="images/galeri.png" alt="input photo" class="foto"> <span id="file-name-container"
              class="ms-2"></span>
          </label>
          <input class="form-control me-2" type="file" name="image" id="image-input" style="display: none;"
            onchange="displayFileName()">
        </div>
      </form>
    </div>
    <!-- End tweet -->
    <!-- Hasil tweet -->
    <!--<div class='tweet row shadow-sm rounded-4 mb-2'>
            <div class='tweet-header d-flex mt-3'>
                <img src='image/profil.jpeg' alt='Profile Picture' class='profile-picture' id="img">
                    <div class='tweet-user d-flex mt-2'>
                        <p class='name fw-semibold mx-2'>".$pembuat."</p>
                        <p class='email opacity-75'>".$email2."</p>
                    </div>
            </div>
            <div class='tweet-body me-5 mb-4'>
                <span class='timestamp opacity-75'>".$tanggal."</span>
                <p>Aku membuat status untuk pertama kalinya</p>
                <div class="foto-status">
                    <img src="image/amar.jpg" alt="foto">
                </div>
            </div>
        </div>
        -->
    <?php
                $sql="SELECT * FROM status INNER JOIN users ON status.pengirim = users.user_name ORDER BY status.id DESC";
                $result=mysqli_query($con, $sql);
                while($row=mysqli_fetch_assoc($result)){
                    $pembuat=$row['pengirim'];
                    $tanggal=$row['tanggal'];
                    $isi=$row['isi'];

                    //$sql2="SELECT * FROM users WHERE username=$pembuat";
                    //$result2=mysqli_query($conn, $sql2);
                    //$row2=mysqli_fetch_array($result2);
                    $gambar2=$row['user_profile'];
                    $email2=$row['user_email'];
                    $foto=$row['gambar'];
                    if($foto==''){
                        echo "
                        <div class='tweet row shadow-sm rounded-4 mb-2'>
                            <div class='tweet-header d-flex mt-3'>
                                <img src='images/".$gambar2."' alt='Profile Picture' class='profile-picture' id='img'>
                                <div class='tweet-user d-flex mt-2'>
                                    <p class='name fw-semibold mx-2'>".$pembuat."</p>
                                  
                                </div>
                            </div>
                            <div class='tweet-body me-5'>
                                <span class='timestamp opacity-75'>".$tanggal."</span>
                                <p>".$isi."</p>
                            </div>
                        </div>
                    ";
                    }else{
                        echo "<div class='tweet row shadow-sm rounded-4 mb-2'>
                                <div class='tweet-header d-flex mt-3'>
                                    <img src='images/".$gambar2."' alt='Profile Picture' class='profile-picture' id='img'>
                                        <div class='tweet-user d-flex mt-2'>
                                            <p class='name fw-semibold mx-2'>".$pembuat."</p>

                                        </div>
                                </div>
                                <div class='tweet-body me-5 mb-4'>
                                    <span class='timestamp opacity-75'>".$tanggal."</span>
                                    <p>".$isi."</p>
                                    <div class='foto-status'>
                                        <img src='images/".$foto."' alt='foto'>
                                    </div>
                                </div>
                            </div>";
                    }
                }

            ?>
    <!-- End Hasil -->
    <br>
  </div>

  <script>
  function displayFileName() {
    const fileInput = document.getElementById("image-input");
    const fileNameContainer = document.getElementById("file-name-container");

    if (fileInput.files.length > 0) {
      fileNameContainer.textContent = fileInput.files[0].name;
    } else {
      fileNameInput.value = "Nama Dokumen";
      fileNameContainer.textContent = ""; // Clear the file name when no file is selected
    }
  }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
</body>

</html>