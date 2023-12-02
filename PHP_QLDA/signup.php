<?php
    $connect = mysqli_connect('localhost', 'root', '12345678', 'qlda');
    mysqli_set_charset($connect, "utf8");
    $erremail = $errfullname = $errpasscheck = $errpassword = $errusername = "";
    if(isset($_POST['signup'])){
        $img_dir = "/BTL_PHP/image/tv.jpg";
        $permission = "tv";
        $result = mysqli_query($connect, "select * from user where username = '$_POST[username]'");
        $count = mysqli_num_rows($result);

        //check invalid
        //check regex username
        if (empty($_POST['username'])) {
            $errusername = "Tai khoan khong duoc de trong !";
            // $checkusername == "not";
        } else if ($count == 1) {
            $errusername = "Tai khoan da ton tai !";
            // $checkusername == "not";
        } else if (!preg_match("/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9]).{8,}$/", $_POST['username'])) {
            $errusername = "Ten tai khoan khong dung yeu cau";
            // $checkusername == "not";
        } else {
            $errusername = "";
            $username = $_POST['username'];
            // $checkusername == "pass";
        }

        //regex password
        if (empty($_POST['password'])) {
            $errpassword = "Mat khau khong duoc de trong !";
            // $checkpassword == "not";
        } elseif (!preg_match("/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*-?]).{8,}$/", $_POST['password'])) {
            $errpassword = "Mat khau khong dung yeu cau !";
            // $checkpassword == "not";
        } else {
            $errpassword = "";
            // $checkpassword == "pass";
        }

        //check passwordcheck
        if(empty($_POST['passwordcheck'])){
            $errpasscheck = "Mat khau khong duoc de trong";
        }else if($_POST['password'] == $_POST['passwordcheck']){
            $errpasscheck = "";
            $password = $_POST['password'];
        }else {
            $errpasscheck = "Mat khau khong khop !";
            // $checkpasswordcheck == "not";
        }
        //check fullname
        if (empty($_POST['fullname'])) {
            $errfullname = "Ho ten khong duoc de trong";
            // $checkfullname == "not";
        } elseif (!preg_match("/^[a-zA-Z-'\s]+$/", $_POST['fullname'])) {
            $errfullname = "Ho ten khong dung yeu cau";
            // $check == "not";
        } else {
            $errfullname = "";
            $fullname = $_POST['fullname'];
            // $check == "pass";
        }
        //check email
        if (empty($_POST['email'])) {
            $erremail = "Email khong duoc de trong";
            // $check == "not";
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erremail = "Email khong hop le !";
            // $check == "not";
        } else {
            $erremail = "";
            $email = $_POST['email'];
            // $check == "pass";
        }
        if (!empty($username) && !empty($fullname) && !empty($password) && !empty($email) ) {
            $sqladd = "INSERT INTO `user`(`fullname`, `email`, `username`, `password`, `img_dir`, `permission`) VALUES ('$fullname','$email','$username','$password','$img_dir','$permission')";
            mysqli_query($connect, $sqladd);
            header("location:thanhvien.php");
        }else{
            echo"Loi roi k them dc";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>QUẢN LÝ DỰ ÁN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <form action="" method="POST">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a href="index.php" class="">
                                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>QLDA</h3>
                                </a>
                                <h3>Đăng Kí</h3>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingText" name="username" placeholder="Tên tài khoản">
                                <label for="floatingText">Tài Khoản</label>
                                <p class="err">
                                    <?php echo "<i> $errusername </i>" ?>
                                </p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingInput" name="password" placeholder="Mật khẩu">
                                <label for="floatingInput">Mật Khẩu</label>
                                <p class="err">
                                    <?php echo "<i> $errpassword </i>" ?>
                                </p>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="passwordcheck" placeholder="Password">
                                <label for="floatingPassword">Nhập Lại Mật Khẩu</label>
                                <p class="err">
                                    <?php echo "<i> $errpasscheck </i>" ?>
                                </p>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" id="floatingPassword" name="fullname" placeholder="Password">
                                <label for="floatingPassword">Họ và Tên</label>
                                <p class="err">
                                    <?php echo "<i> $errfullname </i>" ?>
                                </p>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" id="floatingPassword" name="email" placeholder="Password">
                                <label for="floatingPassword">Email</label>
                                <p class="err">
                                    <?php echo "<i> $erremail </i>" ?>
                                </p>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="signup" value="Đăng Kí">Đăng kí</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>