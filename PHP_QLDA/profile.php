<?php
    session_start();
    $connect = mysqli_connect('localhost','root','12345678','qlda');
    mysqli_set_charset($connect,"utf8");
    if(!isset($_SESSION['username'])){
        header('location:signin.php');
    }
    if(isset($_SESSION['username'])){
        $data = $_SESSION['username'];
        $sql = "select * from user where username = '$data'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $idlogin = $row['id'];
        $fullname = $row['fullname'];
        if($row['permission'] == "tv"){
            $permission = 'Thành Viên';
        }else if($row['permission'] == "tn"){
            $permission = 'Trưởng Nhóm';
        }else{
            $permission = 'Admin';
        }
        $img_dir = $row['img_dir'];
    }
    if(isset($_POST['logout'])){
        unset($_SESSION['username']);
        header("location:signin.php");
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


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>QLDA</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">                        
                        <?php 
                            echo "<img class='rounded-circle' src='$img_dir' alt='' style='width: 40px; height: 40px;'>";
                        ?> 
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $fullname ?></h6>
                        <span><?php echo $permission ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Tổng quan</a>
                    <a href="danhsachduan.php" class="nav-item nav-link "><i class="fa fa-laptop me-2"></i>Dự án</a>
                    <a href="thanhvien.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Thành Viên</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Menu  -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <?php 
                            echo "<img class='rounded-circle' src='$img_dir' alt='' style='width: 40px; height: 40px;'>";
                        ?> 
                            <span class="d-none d-lg-inline-flex"><?php echo $fullname ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="profile.php" class="dropdown-item">Thông tin cá nhân</a>
                            <form action="" method = "POST">
                                <button type="submit" name="logout" value="logout" class="dropdown-item">Đăng xuất</button>                              
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Menu -->


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Tài khoản cá nhân</h6>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#ID</th>
                                        <th scope="col">Họ Tên</th>
                                        <th scope="col">Tài Khoản</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mật khẩu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action=""></form>
                                    
                                    <?php 
                                        $username = $_SESSION['username'];
                                        $danhsachtksql = "select * from user where username = '$username'";
                                        $danhsachtk = mysqli_query($connect,$danhsachtksql);
                                        $danhsachtkarray = mysqli_fetch_assoc($danhsachtk);
                                        echo "
                                            <tr>
                                                <td>".$danhsachtkarray['id']."</td>
                                                <td>".$danhsachtkarray['fullname']."</td>
                                                <td>".$danhsachtkarray['username']."</td>
                                                <td>".$danhsachtkarray['email']."</td>
                                                <td>".$danhsachtkarray['password']."</td>
                                            </tr>
                                        ";
                                    ?>
                                </tbody>
                            </table>
                            <form action="" method="POST">
                                <button type="submit" value="update" name="showupdateprofile" class="btn btn-primary m-2">Cập nhật</button>
                            </form>
                            
                            <!-- Form update Start -->
                            
                            <!-- Form update End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table End -->
            <?php
                                if(isset($_POST['showupdateprofile'])){
                                    $showupdateprofile = 'd-block';
                                }
                                else{
                                    $showupdateprofile = 'd-none';
                                }
                                echo"
                                <div class='container-fluid  $showupdateprofile'>
                                    <div class='row h-100 align-items-center justify-content-center' style='min-height: 100vh;'>
                                        <div class='col-12 col-sm-8 col-md-6 col-lg-5 col-xl-12'>
                                            <div class='bg-light rounded p-4 p-sm-5 my-4 mx-3'>
                                                <h5>Cập nhật thông tin cá nhân </h5>
                                                <form action='' method='POST'>
                                                    <div class='form-floating mb-4'>
                                                        <input type='email' class='form-control' id='floatingPassword' name='email' placeholder='Password'>
                                                        <label for='floatingPassword'>Email</label>
                                                        <p class='err'>
                                                            <i> $erremail </i>
                                                        </p>
                                                    </div>
                                                    <div class='form-floating mb-4'>
                                                        <input type='text' class='form-control' id='floatingPassword' name='fullname' placeholder='Password'>
                                                        <label for='floatingPassword'>Họ và Tên</label>
                                                        <p class='err'>
                                                            <i> $errfullname </i>
                                                        </p>
                                                    </div>
                                                    <div class='form-floating mb-3'>
                                                        <input type='password' class='form-control' id='floatingInput' name='password' placeholder='Mật khẩu'>
                                                        <label for='floatingInput'>Mật Khẩu</label>
                                                        <p class='err'>
                                                            <i> $errpassword </i>
                                                        </p>
                                                    </div>
                                                    <div class='form-floating mb-4'>
                                                        <input type='password' class='form-control' id='floatingPassword' name='passwordcheck' placeholder='Password'>
                                                        <label for='floatingPassword'>Nhập Lại Mật Khẩu</label>
                                                        <p class='err'>
                                                            <i> $errpasscheck </i>
                                                        </p>
                                                    </div>
                                                    
                                                    <button type='submit' class='btn btn-primary py-3 w-100 mb-4' name='capnhatprofile' value='Cap nhat'>Xác nhận</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ";
                            ?>
                            <?php 
                                $erremail = $errfullname = $errpasscheck = $errpassword = "";
                                if(isset($_POST['capnhatprofile'])){
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
                                    if (!empty($fullname) && !empty($password) && !empty($email) ) {
                                        $sql = "UPDATE `user` SET `fullname`='$fullname',`email`='$email',`password`='$password' where username = '$data'";
                                        mysqli_query($connect,$sql);
                                        $url = 'index.php';
                                        echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                                    }
                                    
                                } 
                            ?>                    

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Quản lý dự án</a>
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">Nhóm 14</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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