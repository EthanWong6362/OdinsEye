<?php
    include_once 'connect.php';
    session_start();
    include('simple_html_dom.php');

    if(isset($_POST['query'])) {
      $q = $_POST['query'];
      $_SESSION['q'] = $q;
    } elseif (isset($_SESSION['q'])){
      $q = $_SESSION['q'];
    } else {
      $q = null;
    }

    $search = str_replace(" ", "%20", $q);

    $pg = !isset($_GET['page']) ? 0 : $_GET['page'];
    $sortasc = true;
    if(isset($_GET['order'])) {
        //true = asc, false = desc
        $sortasc = $_GET['order'];
        $disp_order = $sortasc ? "Price: Low to High" : "Price: High to Low";
    }
    
    $short_items = array();
    $items = array();
    $links = array();
    $prices = array();
    if (isset($search)) {
        $flipUrl = "https://www.flipkart.com/search?q=" . $search . "&otracker=search&otracker1=search&marketplace=FLIPKART&as-show=on&as=off";
        $html1 = file_get_html($flipUrl);

        foreach($html1->find('.IRpwTa') as $item) {
            array_push($items, $item->attr['title']);
            array_push($links, "https://www.flipkart.com" . $item->attr['href']);
        }
        if (empty($items)) {
            foreach($html1->find('.s1Q9rs') as $item) {
                array_push($items, $item->attr['title']);
                array_push($links, "https://www.flipkart.com" . $item->attr['href']);
            }
        }
        if (empty($items)) {
            foreach($html1->find('._4rR01T') as $item) {
                array_push($items, $item->innertext);
            }
            foreach($html1->find('._1fQZEK') as $item) {
                array_push($links, "https://www.flipkart.com" . $item->attr['href']);
            }
        }

        foreach($html1->find('._30jeq3') as $item) {
            $p = str_replace(",", "", $item->innertext);
            $p = str_replace("₹", "", $p);
            array_push($prices, (float)$p * 0.018);
        }
        if (empty($prices)) {
            foreach($html1->find('._30jeq3 _1_WHN1') as $item) {
                $p = str_replace(",", "", $item->innertext);
                $p = str_replace("₹", "", $p);
                array_push($prices, (float)$p * 0.018);
            }
        }
        $prices = array_slice($prices, 0, count($items));

        array_multisort($prices, SORT_NUMERIC, $items, $links);
        if(!$sortasc) {
            $prices = array_reverse($prices);
            $items = array_reverse($items);
            $links = array_reverse($links);
        }

        foreach($items as $i) {
            $i = strlen($i) > 70 ? substr($i, 0, 70) . "..." : $i;
            array_push($short_items, $i);
        }
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

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link href="../Styles/main.css" rel="stylesheet"/>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  </head>

  <body class="">
    <div class="wrapper ">
      <div class="sidebar" data-color="orange">

      <div class="logo">
          <p id="odin">ODIN'S EYE</p>

          <?php if(isset($_SESSION['user_n'])) { 
            echo "<p id='wlcback'>Welcome back, " . $_SESSION['user_n'] . "!</p>";
          } ?>
        </div>

        <div class="sidebar-wrapper" id="sidebar-wrapper">
          <ul class="nav">
            <li class="active ">
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
            <li>
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
              <form action="flipkart.php" method="POST" name="search" id="search" autocomplete="off">
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
                  <h5 class="card-category">SEARCH RESULTS FOR:</h5>
                  <h4 class="card-title">"<?php echo $q ?>"</h4>
                  <div class="dropdown">
                    <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret justify-content-end" data-toggle="dropdown">
                      <i class="now-ui-icons arrows-1_minimal-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left">
                      <a class="dropdown-item" href="?order=1&page=<?php echo $pg?>">Price: Low to High</a>
                      <a class="dropdown-item" href="?order=0&page=<?php echo $pg?>">Price: High to Low</a>
                    </div>
                  </div>
                </div>
                <div class="card-body ">
                  <div class="table-full-width table-responsive">
                    <table class="table">
                      <tbody>

                      <?php if(empty($items)) { ?>
                        <p>No results found :C</p>
                        <?php } else { ?> 
                            <p><a href="clearSearch.php">Clear Search</a></p>
                        <?php } ?>
                        
                        <?php
                            $begin = $pg * 30;
                            $end = min(($pg + 1) * 30, count($items)); 
                        ?>
                        <!-- <tr>
                            <td class="text-left"><a href="#"> test </a></td>
                            <td class="td-actions text-right">
                            <button type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
                                <i class="now-ui-icons ui-2_favourite-28"></i>
                            </button>
                            </td>
                        </tr> -->

                        <?php
                        for($i=$begin; $i<$end; $i++) {
                            echo "<tr>
                                <td class=\"text-left\"><a href=\"" . $links[$i] . 
                                "\" target=_blank rel=noopener noreferrer>" . $short_items[$i] . 
                                " (SGD" . ($prices[$i]) . ")</a></td>

                                <td class=\"td-actions text-right\">
                                <button 
                                onclick=\"window.location.href='/OdinEye/pages/like.php?name=". $items[$i] . "&price=" . $prices[$i] . "&link=" . $links[$i] . "'\" 
                                type=\"button\" rel=\"tooltip\" title=\"\" class=\"btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral\" data-original-title=\"Remove\">
                                <i class=\"now-ui-icons ui-2_favourite-28\"></i>
                                </button></td>
                                </tr>";
                        }
                        ?>
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
            <div class="page_manager">
                <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?><?php if($pg == 0) {echo "#";} else {echo "page=" . ($pg - 1);}?>"><</a>
                <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?>page=0"
                style="background-color:<?php if($pg == 0) {echo'orange';}?>;">1</a>
                <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?>page=1"
                style="background-color:<?php if($pg == 1) {echo'orange';}?>;">2</a>
                <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?>page=2"
                style="background-color:<?php if($pg == 2) {echo'orange';}?>;">3</a>
                <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?><?php if($pg == 2) {echo "#";} else {echo "page=" . ($pg + 1);}?>">></a>
            </div>
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