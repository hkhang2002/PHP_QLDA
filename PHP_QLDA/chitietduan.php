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
        $idlogin = $row['id'];
        if($row['permission'] == "tv"){
            $permission = 'Thành viên';
            $showtv = 'd-block';
            $showql = 'd-none';
            $showgs = 'd-none';
        }else if($row['permission'] == "ql"){
            $permission = 'Quản lý';
            $showql = 'd-block';
            $showtv = 'd-none';
            $showgs = 'd-none';
        }
        else if($row['permission'] == "gs"){
            $permission = 'Giám sát';
            $showgs = 'd-block';
            $showql = 'd-none';
            $showtv = 'd-none';
        }else{
            $permission = 'Admin';
            $showadmin = 'd-block';
        }
        $img_dir = $row['img_dir'];
    }
    if(isset($_POST['logout'])){
        unset($_SESSION['username']);
        header("location:signin.php");
    }


    //chuyển hướng danh sach dự án

    if(empty($_SESSION['idduan'])){
        header('location:danhsachduan.php');
    }else{
        $idduan = $_SESSION['idduan'];
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
                    <a href="index.php" class="nav-item nav-link "><i class="fa fa-tachometer-alt me-2"></i>Tổng quan</a>
                    <a href="danhsachduan.php" class="nav-item nav-link active "><i class="fa fa-laptop me-2"></i>Dự án</a>
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
            
            <!-- Thong tin du an -->
            <div class="container-fluid pt-4 px-4">                   
                <div class="row g-4">    
                    <div class='col-sm-12 col-xl-12'>
                        <div class='bg-light rounded h-100 p-4'>
                            <ul class='nav nav-pills mb-3' id='pills-tab' role='tablist'>
                                <li class='nav-item' role='presentation'>
                                    <button class='nav-link active' id='pills-home-tab' data-bs-toggle='pill'
                                        data-bs-target='#pills-home' type='button' role='tab' aria-controls='pills-home'
                                        aria-selected='true'>Thông tin</button>
                                </li>
                                <li class='nav-item' role='presentation'>
                                    <button class='nav-link' id='pills-profile-tab' data-bs-toggle='pill'
                                        data-bs-target='#pills-profile' type='button' role='tab'
                                        aria-controls='pills-profile' aria-selected='false'>Công việc</button>
                                </li>
                                <li class='nav-item' role='presentation'>
                                    <button class='nav-link' id='pills-contact-tab' data-bs-toggle='pill'
                                        data-bs-target='#pills-contact' type='button' role='tab'
                                        aria-controls='pills-contact' aria-selected='false'>Phản Hồi/Yêu Cầu</button>
                                </li>
                            </ul>
                            <div class='tab-content' id='pills-tabContent'>
                                <div class='tab-pane fade show active' id='pills-home' role='tabpanel' aria-labelledby='pills-home-tab'>
                                    <?php
                                        $dulieuchitietduansql = "Select * from duan where maduan = '$idduan'";
                                        $dulieuduan = mysqli_query($connect,$dulieuchitietduansql);
                                        $dulieuduanarray = mysqli_fetch_assoc($dulieuduan);
                                        $tiendovalue = $dulieuduanarray['tiendo'];
                                        echo "
                                            <div class='bg-light rounded h-100 p-4'>
                                                <h5 class='mb-4'>Mã Dự Án:  #DA".$dulieuduanarray['maduan']."</h5>
                                                <div class='m-n2'>
                                                    <h5>Dự Án ".$dulieuduanarray['tenduan']."</h5>
                                                    <p>Thông tin của dự án : ".$dulieuduanarray['mota']."</p>
                                                    <p>Ngày bắt đầu : ".$dulieuduanarray['ngaybatdau']."</p>
                                                    <p>Ngày kết thúc : ".$dulieuduanarray['ngaykethuc']."</p>
                                                    <p>Số nhân viên : ".$dulieuduanarray['sothanhvien']."</p>
                                                    <p>Tiến độ : ".$dulieuduanarray['tiendo']."%</p>
                                                    <div class='pg-bar mb-3 col-xl-12'>
                                                        <div class='progress'>
                                                            <div class='progress-bar progress-bar-striped bg-info' role='progressbar' aria-valuenow='$tiendovalue' aria-valuemin='0' aria-valuemax='100'></div>
                                                        </div>
                                                    </div>
                                                    <form class='d-flex' action='' method='POST'>
                                                        <button type='submit' name='showupdateduan' value='showupdateduan' class='btn btn-warning m-2 $showql '>Sửa dự án</button>
                                                        <button type='submit' name='deleteduan' value='deleteduan' class='btn btn-danger m-2 $showql'>Hủy Dự Án</button>
                                                    </form>
                                                </div>
                                            </div>
                                        ";     
                                    ?>
                                </div>
                                <div class='tab-pane fade' id='pills-profile' role='tabpanel' aria-labelledby='pills-profile-tab'>
                                    <h5 class="mt-4">Danh sách công việc</h5>   
                                    <table class='table text-start align-middle table-bordered table-hover mb-0'>
                                        <thead>
                                            <tr class='text-dark'>
                                                <th scope='col'>#ID</th>
                                                <th scope='col'>Tên</th>
                                                <th scope='col'>Mô tả</th>
                                                <th scope='col'>Thời gian bắt đầu/kết thúc</th>
                                                <th scope='col'>Trạng Thái</th>
                                                <th scope='col'>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class='m-2'>
                                            
                                            <!-- duyet cong viec -->
                                            <?php 
                                                if(isset($_POST['duyetcongviec'])){
                                                    $idduyetcongviec=$_POST['duyetcongviec'];
                                                    $sqlduyet="UPDATE `congviec` SET `giamsat`='checked' WHERE macongviec='$idduyetcongviec'";
                                                    mysqli_query($connect, $sqlduyet);
                                                    $tiendothem = mysqli_fetch_assoc(mysqli_query($connect,"Select muctiendo from congviec where macongviec = '$idduyetcongviec'"));
                                                    $tiendocu = mysqli_fetch_assoc(mysqli_query($connect,"select tiendo from duan where maduan = '$idduan'"));
                                                    $tiendomoi = $tiendocu['tiendo'] + $tiendothem['muctiendo'];
                                                    $sqlcapnhattiendo = "UPDATE `duan` SET `tiendo`='$tiendomoi' WHERE maduan='$idduan'";
                                                    mysqli_query($connect,$sqlcapnhattiendo);
                                                    header('location:chitietduan.php');
                                                }
                                            ?>
                                            <!-- xoa cong viec  -->
                                            <?php 
                                                if(isset($_POST['deletecongviec'])){
                                                    $idxoa = $_POST['deletecongviec'];
                                                    $deletesql = "DELETE FROM `congviec` WHERE macongviec = '$idxoa'";
                                                    mysqli_query($connect,$deletesql);
                                                    header('location:chitietduan.php');
                                                }
                                            ?>
                                            <!-- Hoàn thành công việc -->
                                            <?php 
                                                if(isset($_POST['finishcongviec'])){
                                                    $idcongviec=$_POST['finishcongviec'];
                                                    $sqlfinish="UPDATE `congviec` SET `trangthai`='on' WHERE macongviec='$idcongviec'";
                                                    mysqli_query($connect, $sqlfinish);
                                                    header('location:chitietduan.php');
                                                }
                                            ?>
                                            <!-- huy cong viec -->
                                            <?php
                                                if(isset($_POST['huycongviec'])){
                                                    $idcongviechuy = $_POST['huycongviec'];
                                                    $checkdulieusql = "UPDATE `congviec` SET `trangthai`= 'off' WHERE macongviec = '$idcongviechuy' ";
                                                    mysqli_query($connect, $checkdulieusql);
                                                }
                                            ?>
                                            <!-- show cong viec -->
                                            <?php 
                                                $dulieucongviecsql = "Select * from congviec where maduan = '$idduan' and giamsat='check'" ;
                                                $dulieucongviec = mysqli_query($connect,$dulieucongviecsql);
                                                while($dulieucongviecarray = mysqli_fetch_assoc($dulieucongviec)){
                                                    $idcongviec = $dulieucongviecarray['macongviec'];
                                                    if($dulieucongviecarray['trangthai'] == "on"){
                                                        $status = 'checked';
                                                        $kiemtracv = 'd-block';
                                                        
                                                    }else{
                                                        $status = 'check';
                                                        $kiemtracv = 'd-none';
                                                        $showhuy = 'd-none';
                                                    }
                                                    if($status == 'checked'){
                                                        $check_finish = 'd-none';
                                                    }
                                                    echo "
                                                            <tr>
                                                                <td>CV".$dulieucongviecarray['macongviec']."</td>
                                                                <td>".$dulieucongviecarray['tencongviec']."</td>
                                                                <td>".$dulieucongviecarray['motacongviec']."</td>
                                                                <td>".$dulieucongviecarray['thoigianbatdau']." / ".$dulieucongviecarray['thoigianketthuc']."</td>
                                                                <td>
                                                                    <div class='form-check form-switch'>
                                                                        <input class=' form-check-input' type='checkbox' role='switch'
                                                                            id='flexSwitchCheckChecked' $status disabled >
                                                                        <label class='form-check-label' for='flexSwitchCheckChecked'></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <form action='' method='POST' class='d-flex'>
                                                                        <button type='submit' name='finishcongviec' value='$idcongviec' class='btn btn-primary m-2 $showtv $showadmin $check_finish'>Hoàn thành</button> 
                                                                        <button type='submit' name='huycongviec' value='$idcongviec' class='btn btn-danger m-2 $showtv $showadmin $showhuy $'>Hủy</button>
                                                                        <button type='submit' name='deletecongviec' value='$idcongviec' class='btn btn-danger m-2  $showql $showadmin'>Xóa</button>
                                                                        <button type='submit' name='showsuacongviec' value='$idcongviec' class='btn btn-warning m-2  $showql $showadmin'>Sửa</button>
                                                                        <button type='submit' name='duyetcongviec' value='$idcongviec' class='btn btn-info rounded-pill m-2 $showgs $showadmin $kiemtracv'>Duyệt</button>
                                                                        <button type='submit' name='huycongviec' value='$idcongviec' class='btn btn-danger m-2 $showgs $showadmin $kiemtracv'>Không duyệt</button>
                                                                    </form>
                                                                </td>
                                                            </tr> 
                                                    ";
                                                
                                                }
                                            ?>
                                           
                                            <!-- nut them cong viec -->
                                        </tbody>
                                        <form action="" method='POST' class='mr-1'>
                                            <?php 
                                                echo"
                                                <button type='submit' name='showthemcongviec' value='d-block' class='btn btn-success mb-2 mt-2 mr-2 $showql $showadmin'>
                                                Thêm công việc
                                                </button>
                                                ";
                                            ?>
                                            
                                        </form>
                                    </table> 
                                    <h5 class="mt-4">Công việc đã xong</h5>           
                                    <!-- show cong viec done -->
                                    <table class='table text-start align-middle table-bordered table-hover mb-0'>
                                        <thead>
                                            <tr class='text-dark'>
                                                <th scope='col'>#ID</th>
                                                <th scope='col'>Tên</th>
                                                <th scope='col'>Mô tả</th>
                                                <th scope='col'>Thời gian bắt đầu/kết thúc</th>
                                                <th scope='col'>Trạng Thái</th>
                                                <th scope='col'>Duyệt</th>
                                            </tr>
                                        </thead>
                                        <tbody class='m-2'>
                                            <!-- show cong viec -->
                                            <?php 
                                                $dulieucongviecdonesql = "Select * from congviec where maduan = '$idduan' and giamsat='checked'" ;
                                                $dulieucongviecdone = mysqli_query($connect,$dulieucongviecdonesql);
                                                while($dulieucongviecdonearray = mysqli_fetch_assoc($dulieucongviecdone)){
                                                    $idcongviec = $dulieucongviecdonearray['macongviec'];
                                                    if($dulieucongviecdonearray['trangthai'] == "on"){
                                                        $status = 'checked';
                                                        $kiemtracv = 'd-block';
                                                        
                                                    }else{
                                                        $status = 'check';
                                                        $kiemtracv = 'd-none';
                                                        $showhuy = 'd-none';
                                                    }
                                                    if($status == 'checked'){
                                                        $check_finish = 'd-none';
                                                    }
                                                    
                                                    echo "
                                                            <tr>
                                                                <td>CV".$dulieucongviecdonearray['macongviec']."</td>
                                                                <td>".$dulieucongviecdonearray['tencongviec']."</td>
                                                                <td>".$dulieucongviecdonearray['motacongviec']."</td>
                                                                <td>".$dulieucongviecdonearray['thoigianbatdau']." / ".$dulieucongviecdonearray['thoigianketthuc']."</td>
                                                                <td>
                                                                    <div class='form-check form-switch'>
                                                                        <input class=' form-check-input' type='checkbox' role='switch'
                                                                            id='flexSwitchCheckChecked' $status disabled >
                                                                        <label class='form-check-label' for='flexSwitchCheckChecked'></label>
                                                                    </div>
                                                                </td>
                                                                <td>Đã Duyệt</td>
                                                            </tr> 
                                                    ";
                                                
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class='tab-pane fade' id='pills-contact' role='tabpanel' aria-labelledby='pills-contact-tab'>
                                    
                                    <?php 
                                        $dulieufeedbacksql = "Select * from feedback where maduan ='$idduan' ";
                                        $dulieufeedback = mysqli_query($connect,$dulieufeedbacksql);
                                        $sophanhoi = 1;
                                        while($dulieufeedbackarray = mysqli_fetch_assoc($dulieufeedback)){
                                            $maphanhoi = $dulieufeedbackarray['mafeedback'];
                                            $nguoitaofeedback = mysqli_fetch_assoc(mysqli_query($connect , "select * from user where id = '$dulieufeedbackarray[iduser]' "));
                                            echo "
                                                <div class='accordion accordion-flush' id='accordionFlushExample'>
                                                    <div class='accordion-item'>
                                                        <h2 class='accordion-header' id='flush-heading$sophanhoi'>
                                                            <button class='accordion-button collapsed' type='button'
                                                                data-bs-toggle='collapse' data-bs-target='#flush-collapse$sophanhoi'
                                                                aria-expanded='true' aria-controls='flush-collapseOne'>
                                                                Phản hồi $sophanhoi
                                                            </button>
                                                        </h2>
                                                        <div id='flush-collapse$sophanhoi' class='accordion-collapse collapse '
                                                            aria-labelledby='flush-heading$sophanhoi' data-bs-parent='#accordionFlushExample'>
                                                            <div class='accordion-body'>
                                                                <div class='feedback'>
                                                                    <h5>Phản Hồi</h5>
                                                                    <div class='bg-light rounded h-100 pl-4 pr-4 pb-4'>
                                                                        <div class='p-2 bg-warning text-dark'> $dulieufeedbackarray[phanhoi]</div>
                                                                    </div>
                                                                </div>
                                                                <div class='requirement'>
                                                                    <h5>Yêu cầu</h5>
                                                                    <div class='bg-light rounded h-100 pl-4 pr-4 pb-4'>
                                                                        <div class='alert alert-danger' role='alert'>
                                                                            $dulieufeedbackarray[yeucau]
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='owner'>
                                                                    <div class=' rounded p-4 pb-0 mb-0'>
                                                                        <figure class='text-end'>
                                                                            <figcaption class='blockquote-footer'>
                                                                                Tạo bởi <cite title='Source Title'>$nguoitaofeedback[fullname]</cite>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </div>
                                                                </div>
                                                                <form action='' method='POST' class='mr-1'>
                                                                    <button type='submit' name='xoafeedback' value='$maphanhoi' class='btn btn-success mb-2 mt-2 mr-2 $showgs $showadmin'>Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                            $sophanhoi++;
                                        }
                                    ?>
                                    <form action="" method='POST' class='mr-1'>
                                        <?php 
                                            echo"
                                            <button type='submit' name='showthemfeedback' value='d-block' class='btn btn-success mb-2 mt-2 mr-2 $showgs $showadmin'>
                                            Thêm
                                            </button>
                                            ";

                                        ?>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                                        
                    
                    
                    <div class=' table-responsive col-sm-12 col-xl-12'>
                        <!-- xoa feedback -->
                        <?php 
                            if(isset($_POST['xoafeedback'])){
                                $mafeedbackxoa = $_POST['xoafeedback'];
                                $xoafeedbacksql = "DELETE FROM `feedback` WHERE mafeedback = $mafeedbackxoa";
                                mysqli_query($connect, $xoafeedbacksql);
                                $url = 'chitietduan.php';
                                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                            }
                            
                        ?>
                        <?php
                            //show them feedback
                            if(isset($_POST['showthemfeedback'])){
                                $showaddfeedback = $_POST['showthemfeedback'];
                            }else{
                                $showaddfeedback = 'd-none';
                            }
                            if(isset($_POST['themfeedback'])){
                                $phanhoi = $_POST['phanhoi'];
                                $yeucau = $_POST['yeucau'];
                                $addfbsql = "INSERT INTO `feedback`(`maduan`, `phanhoi`, `yeucau`, `iduser`) VALUES ('$idduan','$phanhoi','$yeucau','$idlogin')";
                                mysqli_query($connect,$addfbsql);
                                unset($_POST['name'],$_POST['des'],$_POST['start'],$_POST['end']);
                                $url = 'chitietduan.php';
                                echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                            }
                            //form them 
                            echo "
                                <div class=' $showaddfeedback bg-light rounded h-100 p-4 mt-3'>
                                    <h4 class='mb-4'>Thêm Phản hồi và Yêu cầu</h4>
                                    <div class='col-sm-12 col-xl-12 mt-2'>
                                        <form action='' method ='POST'>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='phanhoi' class='form-control' id='floatingInput'>
                                                <label for='floatingInput'>Phản Hồi</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='yeucau' class='form-control' id='floatingInput'>
                                                <label for='floatingInput'>Yêu Cầu</label>
                                            </div>
                                            <button type='submit' name='themfeedback' value='themfeedback' class='btn btn-success rounded-pill mb-2 mt-4'>Thêm</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            ";
                        ?>

                            
                    </div>
                    <!-- them, sua cong viec -->
                    <div class=' table-responsive col-sm-12 col-xl-12'>
                        <?php
                            $tongtiendosql ="SELECT SUM(muctiendo) AS TONG FROM `congviec` WHERE maduan='$idduan' and giamsat='check'";
                            $tongtiendo = mysqli_fetch_assoc(mysqli_query($connect,$tongtiendosql));
                            $tiendoduansql = "SELECT tiendo FROM `duan` WHERE maduan = '$idduan'";
                            $tiendoduan = mysqli_fetch_assoc(mysqli_query($connect,$tiendoduansql));
                            //show them cong viec va sua
                            if(isset($_POST['showthemcongviec'])){
                                $showadd = $_POST['showthemcongviec'];
                                $showupdate = 'd-none';
                            }else if(isset($_POST['showsuacongviec'])){
                                $showadd = 'd-none';
                                $_SESSION['idfix'] = $_POST['showsuacongviec'];
                                $showupdate = 'd-block';
                            }else{
                                $showadd = 'd-none';
                                $showupdate = 'd-none';
                            }
                            // regex them cong viec 
                            if(isset($_POST['themcongviec'])){
                                $showadd = 'd-block';
                                $trangthaicongviec = 'off';
                                $giamsat= 'check';
                                //check name
                                if(empty($_POST['tencongviec'])){
                                    $errname = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $name = $_POST['tencongviec'];
                                }
                                //check des
                                if(empty($_POST['motacongviec'])){
                                    $errdes = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $des = $_POST['motacongviec'];
                                }
                                //check start date
                                if(empty($_POST['thoigianbatdau'])){
                                    $errstart = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $start = $_POST['thoigianbatdau'];
                                }
                                //check end date
                                if(empty($_POST['thoigianketthuc'])){
                                    $errend = "Khong duoc de trong" ;
                                }else{
                                    $errend = "";
                                    $end = $_POST['thoigianketthuc'];
                                }
                                //checktiendo
                                if(empty($_POST['muctiendo'])){
                                    $errtiendo = "Khong duoc de trong" ;
                                }elseif($tiendoduan['tiendo'] + $tongtiendo['TONG'] + $_POST['muctiendo'] > 100 || $_POST['muctiendo'] <= 0){
                                    $errtiendo =" Muc tien do khong hop li ! ";
                                }
                                else{
                                    $errtiendo = "";
                                    $muctiendo = $_POST['muctiendo'];
                                }
                        
                                if(isset($name) && isset($des) && isset($start) && isset($end) && isset($muctiendo)){
                                    $addcvsql = "INSERT INTO `congviec`( `maduan`, `tencongviec`, `motacongviec`, `thoigianbatdau`, `thoigianketthuc`, `trangthai`, `giamsat`,`muctiendo`) VALUES ('$idduan','$name','$des','$start','$end','$trangthaicongviec','$giamsat','$muctiendo')";
                                    mysqli_query($connect,$addcvsql);
                                    unset($_POST['name'],$_POST['des'],$_POST['start'],$_POST['end']);
                                    $url = 'chitietduan.php';
                                    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                                }
                            }

                            //update cong viec 
                            if(isset($_POST['suacongviec'])){
                                //check name
                                if(empty($_POST['tencongviecnew'])){
                                    $errname = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $namenew = $_POST['tencongviecnew'];
                                }
                                //check des
                                if(empty($_POST['motacongviecnew'])){
                                    $errdes = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $desnew = $_POST['motacongviecnew'];
                                }
                                //check start date
                                if(empty($_POST['thoigianbatdaunew'])){
                                    $errstart = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $startnew = $_POST['thoigianbatdaunew'];
                                }
                                //check end date
                                if(empty($_POST['thoigianketthucnew'])){
                                    $errend = "Khong duoc de trong" ;
                                }else{
                                    $errend = "";
                                    $endnew = $_POST['thoigianketthucnew'];
                                }
                                //checktiendo
                                if(empty($_POST['muctiendo'])){
                                    $errtiendo = "Khong duoc de trong" ;
                                }elseif($tiendoduansql['tiendo'] + $tongtiendo['TONG'] + $_POST['muctiendo'] > 100 || $_POST['muctiendonew'] <= 0){
                                    $errtiendo =" Muc tien do khong hop li ! ";
                                }
                                else{
                                    $errtiendo = "";
                                    $muctiendonew = $_POST['muctiendonew'];
                                }
                        
                                if(isset($namenew) && isset($desnew) && isset($startnew) && isset($endnew)&& isset($muctiendonew)){
                                    $idfix = $_SESSION['idfix'];
                                    $fixcvsql = " UPDATE `congviec` SET `tencongviec`='$namenew',`motacongviec`='$desnew',`thoigianbatdau`='$startnew',`thoigianketthuc`= '$endnew',`muctiendo` = $muctiendonew WHERE  macongviec = '$idfix' ";
                                    mysqli_query($connect,$fixcvsql);
                                    $url = 'chitietduan.php';
                                    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                                }
                                
                                
                            }
                            
                            

                            //form them 
                            echo "
                                <div class=' $showadd bg-light rounded h-100 p-4 mt-3'>
                                    <h4 class='mb-4'>Thêm công việc</h4>
                                    <div class='col-sm-12 col-xl-12 mt-2'>
                                        <form action='' method ='POST'>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='tencongviec' class='form-control' id='floatingInput'>
                                                <span>$errname</span>
                                                <label for='floatingInput'>Tên Công Việc</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='motacongviec' class='form-control' id='floatingInput'>
                                                <span>$errdes</span>
                                                <label for='floatingInput'>Mô tả</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='date' name='thoigianbatdau' class='form-control' id='floatingInput'>
                                                <span>$errstart</span>
                                                <label for='floatingInput'>Thời gian bắt đầu</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='date' name='thoigianketthuc' class='form-control' id='floatingInput'>
                                                <span> $errend</span>
                                                <label for='floatingInput'>Thời gian kết thúc</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='number' min='1' max='100' name='muctiendo' class='form-control' id='floatingInput'>
                                                <span> $errtiendo</span>
                                                <label for='floatingInput'>Mức tiến độ</label>
                                            </div>
                                            <button type='submit' name='themcongviec' value='themcongviec' class='btn btn-success rounded-pill mb-2 mt-4'>Thêm </button>
                                        </form>
                                        
                                    </div>
                                </div>
                            ";

                            
                            //form sua
                            echo "
                                <div class=' $showupdate bg-light rounded h-100 p-4 mt-3'>
                                    <h4 class='mb-4'>Sửa công việc  CV$idcongviec</h4>
                                    <div class='col-sm-12 col-xl-12 mt-2'>
                                        <form action='' method ='POST'>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='tencongviecnew' class='form-control' id='floatingInput'>
                                                <span>$errname</span>
                                                <label for='floatingInput'>Tên Công Việc</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='motacongviecnew' class='form-control' id='floatingInput'>
                                                <span> $errdes </span>
                                                <label for='floatingInput'>Mô tả</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='date' name='thoigianbatdaunew' class='form-control' id='floatingInput'>
                                                <span>$errstart </span>
                                                <label for='floatingInput'>Thời gian bắt đầu</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='date' name='thoigianketthucnew' class='form-control' id='floatingInput'>
                                                <span>$errend </span>
                                                <label for='floatingInput'>Thời gian kết thúc</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='number' min='1' max='100' name='muctiendonew' class='form-control' id='floatingInput'>
                                                <span> $errtiendo</span>
                                                <label for='floatingInput'>Mức tiến độ</label>
                                            </div>
                                            <button type='submit' name='suacongviec' value='suacongviec' class='btn btn-warning rounded-pill m-2 mb-2 mt-4 ml-2'>Sửa</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            ";
                            
                        ?>
                    </div>   

                    <!-- xoa du an -->
                    <?php 
                        if(isset($_POST['deleteduan'])){
                            $duanxoasql= "DELETE FROM `duan` WHERE maduan = '$idduan'";
                            mysqli_query($connect,$duanxoasql);
                            $congviecxoasql = "DELETE FROM `congviec` WHERE maduan = '$idduan'";
                            mysqli_query($connect,$congviecxoasql);
                            $feedbackxoasql = "DELETE FROM `feedback` WHERE maduan = '$idduan'";
                            mysqli_query($connect,$feedbackxoasql);
                            unset($_SESSION['idduan']);
                            $url = 'chitietduan.php';
                            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';

                        }
                    ?>

                    <!-- sua du an -->
                    <div class=' table-responsive col-sm-12 col-xl-12'>
                       
                        <?php
                            //update cong viec 
                            if(isset($_POST['suaduan'])){
                                //check name
                                if(empty($_POST['tenduannew'])){
                                    $errname = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $nameduannew = $_POST['tenduannew'];
                                }
                                //check des
                                if(empty($_POST['motaduannew'])){
                                    $errdes = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $desduannew = $_POST['motaduannew'];
                                }
                                //check start date
                                if(empty($_POST['thoigianbatdauduannew'])){
                                    $errstart = "Khong duoc de trong" ;
                                }else{
                                    $errname = "";
                                    $startduannew = $_POST['thoigianbatdauduannew'];
                                }
                                //check end date
                                if(empty($_POST['thoigianketthucduannew'])){
                                    $errend = "Khong duoc de trong" ;
                                }else{
                                    $errend = "";
                                    $endduannew = $_POST['thoigianketthucduannew'];
                                }
                                if(empty($_POST['sonhanviennew'])){
                                    $errsoluongnhanviennew = "Khong duoc de trong" ;
                                }else{
                                    $errnumber = "";
                                    $soluongnew = $_POST['sonhanviennew'];
                                }
                        
                                if(isset($nameduannew) && isset($desduannew) && isset($startduannew) && isset($endduannew) && isset($soluongnew) ){
                                    $fixduansql = "UPDATE `duan` SET `tenduan`='$nameduannew',`ngaybatdau`='$startduannew',`ngaykethuc`='$endduannew',`mota`='$desduannew',`sothanhvien`='$soluongnew' WHERE maduan = '$idduan'";
                                    mysqli_query($connect,$fixduansql);
                                    $url = 'chitietduan.php';
                                    echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
                                }
                                
                                
                            }

                            //show them cong viec va sua
                            if(isset($_POST['showupdateduan'])){
                                $showupdateduan = 'd-block';
                            }else{
                                $showupdateduan = 'd-none';
                            }
                            //form sua
                            echo "
                                <div class=' $showupdateduan bg-light rounded h-100 p-4 mt-3'>
                                    <h4 class='mb-4'>Sửa dự án #DA$idduan</h4>
                                    <div class='col-sm-12 col-xl-12 mt-2'>
                                        <form action='' method ='POST'>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='tenduannew' class='form-control' id='floatingInput'>
                                                <span>$errname</span>
                                                <label for='floatingInput'>Tên Dự Án</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='text' name='motaduannew' class='form-control' id='floatingInput'>
                                                <span> $errdes </span>
                                                <label for='floatingInput'>Mô tả</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='date' name='thoigianbatdauduannew' class='form-control' id='floatingInput'>
                                                <span>$errstart </span>
                                                <label for='floatingInput'>Thời gian bắt đầu</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='date' name='thoigianketthucduannew' class='form-control' id='floatingInput'>
                                                <span>$errend </span>
                                                <label for='floatingInput'>Thời gian kết thúc</label>
                                            </div>
                                            <div class='form-floating mb-3'>
                                                <input type='number' name='sonhanviennew' class='form-control' id='floatingInput'>
                                                <span>$errnumber </span>
                                                <label for='floatingInput'>Số nhân viên </label>
                                            </div>
                                            <button type='submit' name='suaduan' value='suaduan' class='btn btn-warning rounded-pill m-2 mb-2 mt-4 ml-2'>Sửa</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            ";
                            
                        ?>
                        <!-- them cong viec -->
                    </div>    
                </div>
                
                
            </div>


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