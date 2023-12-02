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
        $fullname = $row['fullname'];
        if($row['permission'] == "tv"){
            $permission = 'Thành Viên';
        }else if($row['permission'] == "tn"){
            $permission = 'Trưởng Nhóm';
        }else{
            $permission = 'Admin';
        }
        $img_dir = $row['img_dir'];

        // lấy dữ liệu 
        // $soduansql = "Select count(*) as total from duan ";
        // $soduan = mysqli_fetch_array(mysqli_query($connect,$soduansql));
        // $sqlduanon = "Select count(*) as total from duan where trangthai = 'on' ";
        // $sqlduanoff = "Select count(*) as total from duan where trangthai = 'off' ";
        // $duanon = mysqli_fetch_assoc(mysqli_query($connect,$sqlduanon));
        // $duanoff = mysqli_fetch_assoc(mysqli_query($connect,$sqlduanoff));

        // $sqlthanhvien = "select count(*) as total from user ";
        // $sothanhvien = mysqli_fetch_assoc(mysqli_query($connect,$sqlthanhvien));

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


            <!-- Button Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <?php
                        if(isset($_POST['addprj'])){
                            $tiendo = 0;
                            $trangthai = 'on';
                            //check name
                            if(empty($_POST['nameprj'])){
                                $errname = "Khong duoc de trong" ;
                            }else{
                                $errname = "";
                                $name = $_POST['nameprj'];
                            }
                            //check des
                            if(empty($_POST['desprj'])){
                                $errdes = "Khong duoc de trong" ;
                            }else{
                                $errname = "";
                                $des = $_POST['desprj'];
                            }
                            //check start date
                            if(empty($_POST['desprj'])){
                                $errstart = "Khong duoc de trong" ;
                            }else{
                                $errname = "";
                                $start = $_POST['startdate'];
                            }
                            //check end date
                            if(empty($_POST['enddate'])){
                                $errend = "Khong duoc de trong" ;
                            }else{
                                $errend = "";
                                $end = $_POST['enddate'];
                            }
                            //check number
                            if(empty($_POST['number'])){
                                $errnumber = "Khong duoc de trong" ;
                            }else{
                                $errnumber = "";
                                $number = $_POST['number'];
                            }
                    
                            if(isset($name) &&isset($des) && isset($start) && isset($end) && isset($number)){
                                $addsql = "INSERT INTO `duan`( `tenduan`, `ngaybatdau`, `ngaykethuc`, `tiendo`, `mota`, `sothanhvien`, `trangthai`) VALUES ('$name','$start','$end','$tiendo','$des','$number','$trangthai')";
                                mysqli_query($connect,$addsql);
                                $url = 'danhsachduan.php';
                                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                            }
                    
                        }
                    ?>
                    <form action="" method= "POST">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Thông tin dự án</h6>
                            <div class="form-floating mb-3">
                                <input name="nameprj" type="text" class="form-control" id="floatingname">
                                <label for="floatingInput">Tên Dự Án</label>
                                <span><?php echo $errname ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="desprj" type="text" class="form-control" id="floatingdes">
                                <label for="floatingPassword">Mô Tả Dự Án</label>
                                <span><?php echo $errdes ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="startdate" type="date" class="form-control" id="floatingstart">
                                <label for="floatingstart">Ngày Bắt Đầu</label>
                                <span><?php echo $errstart ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="enddate" type="date" class="form-control" id="floatingend">
                                <label for="floatingend">Ngày Kết Thúc</label>
                                <span><?php echo $errend ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="number" type="number" class="form-control" id="floatingnumber">
                                <label for="floatingnumber">Số lượng nhân viên</label>
                                <span><?php echo $errnumber ?></span>
                            </div>
                            <button type="submit" value="addprj" name="addprj" class="btn btn-sm btn-primary m-2">Tạo mới</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- Button End -->


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