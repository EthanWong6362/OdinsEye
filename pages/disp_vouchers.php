<?php
    include_once 'connect.php';
    session_start();
    if(!isset($_SESSION['user_n'])) {
        echo "<script>alert('Please log in to view vouchers.')</script>";
        echo "<script>window.location.href='home.php'</script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/logo_no_txt.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
      Odin's Eye
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  </head>

  <body class="">
    <div class="wrapper ">
      <div class="sidebar" data-color="orange">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      -->
      <div class="logo">
          <p id="odin">ODIN'S EYE</p>

          <?php if(isset($_SESSION['user_n'])) { 
            echo "<p id='wlcback'>Welcome back, " . $_SESSION['user_n'] . "!</p>";
          } ?>
        </div>

        <div class="sidebar-wrapper" id="sidebar-wrapper">
          <ul class="nav">
            <li>
              <a href="home.php">
                <i class="now-ui-icons shopping_shop"></i>
                <p>Home</p>
              </a>
            </li>
            <li>
              <a href="disp_likes.php">
                <i class="now-ui-icons ui-2_favourite-28"></i>
                <p>Likes</p>
              </a>
            </li>
            <li class="active">
              <a href="disp_vouchers.php">
                <i class="now-ui-icons shopping_tag-content"></i>
                <p>Vouchers</p>
              </a>
            </li>
            <li>
            <li>
                <?php if(!isset($_SESSION['user_n'])) { ?>
                    <a href="login.php" id="btnlogin">
                      <i class="now-ui-icons users_single-02"></i>
                      <p>Login</p></a>
                <?php } ?>
            </li>
            <li>
                <?php if(!isset($_SESSION['user_n'])) { ?>
                    <a href="signup.php" id="btnsignup">
                      <i class="now-ui-icons gestures_tap-01"></i>
                      <p>Sign up</p></a>
                <?php } ?>
            </li>
            <li>
              <?php if(isset($_SESSION['user_n'])) { ?>
                <a onclick="logout()" href="#">
                <i class="now-ui-icons media-1_button-power"></i>
                <p>Logout</p></a>
              <?php } ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
          <img src="../assets/img/logo.PNG" height=200px width=200px alt=logo>

          <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-lg-left" id="navigation">
              <form action="search.php" method="POST" name="search" id="search" autocomplete="off">
                <div class="input-group no-border" action="search.php" method="POST" name="search" id="search" autocomplete="off">
                  <input class="form-control" type="text" placeholder="Search..." name="query" id="query">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="now-ui-icons ui-1_zoom-bold"></i>
                    </div>
                  </div>
                </div>
              </form>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="now-ui-icons design_bullet-list-67"></i>
                    <p>
                      <span class="d-lg-none d-md-block">Filter</span>
                    </p>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="search.php">All Websites</a>
                    <a class="dropdown-item" href="flipkart.php">Flipkart</a>
                    <a class="dropdown-item" href="lelong.php">Lelong</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-lg">
        </div>
        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card  card-tasks">
                <div class="card-header ">
                  <h5 class="card-category1">Vouchers:</h5>
                </div>
                <div class="card-body ">
                  <div class="table-full-width table-responsive">
                    <table class="table">
                      <tbody>
                        <div class="container mt-5">
                            <div class="d-flex justify-content-center row">
                                <div class="col-md-6">
                                    <div class="coupon p-3 bg-white">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 border-right">
                                                <div class="d-flex flex-column align-items-center"><img src="../assets/img/logo_no_txt.png"><span class="d-block">Odin's Eye</span><span class="text-black-50">Clothes</span></div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="coupon1">
                                                    <div class="d-flex justify-content-center">
                                                        <h1>50%</h1><span>OFF</span>
                                                        
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <p>Disclaimer: This is not a real voucher.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class=" container-fluid ">
            <div class="copyright" id="copyright">
              &copy; <script>
                document.getElementById('copyright')
              </script>Odin's Eye (Orbital 2021) by Ethan Wong Goon Hong & Nicholas Chow Carson
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
    <script>
      $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

      });
    </script>
    <script src="../Scripts/logout.js"></script>
    <script src="../Scripts/search.js"></script>
  </body>

</html>