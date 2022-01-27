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
    if (isset($q)) {
        $flipUrl = "https://www.flipkart.com/search?q=" . $q . "&otracker=search&otracker1=search&marketplace=FLIPKART&as-show=on&as=off";
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
            $i = strlen($i) > 40 ? substr($i, 0, 50) . "..." : $i;
            array_push($short_items, $i);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Odin's Eye</title>
        <link href="Styles/main.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="top"">
            <img src="Img/logo_w_txt.PNG" height=125px width=125px alt=logo>
            
            <form action="flipkart.php" method="POST" name="search" id="search" autocomplete="off">
                <input type="text" placeholder="Search..." name="query" id="query">
                <input type="submit" value="Search" name="btnsearch" id="btncsearch">
            </form>
            <!--button type="submit"><img src="Img/search-icon.jpg" height=25 width=25></button -->

            <?php if(!isset($_SESSION['user_n'])) { ?>
                <a href="login.php" id="btnlogin">Login</a> | 
                <a href="signup.php" id="btnsignup">Sign up</a>
            <?php } ?>

            <?php if(isset($_SESSION['user_n'])) { 
                echo "Welcome back, " . $_SESSION['user_n'] . "!";?>
                <a href="disp_likes.php">Likes</a>
                <button onclick="logout()">Logout</button>
            <?php } ?>
        </div>

        <div class="row">
            <!-- left sidebar -->
            <div class="filter">
                <h3>SEARCH FILTER</h3>
                <ul>
                    <li><a href="search.php">Both</a></li>
                    <li>Flipkart</li>
                    <li><a href="lelong.php">Lelong</a></li>
                </ul>
            </div>

            <div class="right">
                <div class="sort-order">
                    <h3>Sort by</h3>
                    <ul>
                        <li id="dropdown">
                            <button class="dropbtn">
                            <?php echo (isset($_GET['order'])) ? $disp_order : "Price";?>
                            </button>
                            <div class="dropdown-content">
                                <a href="?order=1&page=<?php echo $pg?>">Price: Low to High</a>
                                <a href="?order=0&page=<?php echo $pg?>">Price: High to Low</a>
                            </div>
                        </li>
                        <li><a href="#">Ratings</a></li>
                        <li><a href="#">Sales</a></li>
                    </ul>
                </div>
                
                <div class="content">
                    <h1>This where stuff is going to go</h1>

                    <?php if(empty($items)) { ?>
                        <p>No results found :C</p>
                    <?php } else { ?> 
                        <p><a href="clearSearch.php">Clear Search</a></p>
                    <?php } ?>
                    
                    <?php
                        $begin = $pg * 30;
                        $end = min(($pg + 1) * 30, count($items)); 
                    ?>
                    <ol start="<?php echo $begin + 1?>">
                    <?php
                        for($i=$begin; $i<$end; $i++) {
                            echo "<li><a class=\"listing\" href=\"" . $links[$i] . 
                                "\" target=_blank rel=noopener noreferrer title=\"" 
                                . $items[$i] . "\">" . $short_items[$i] . 
                                " (SGD" . ($prices[$i]) . ")</a>
                                
                                <a class=\"likebtn\" href=\"like.php?name=" . $items[$i] . "&price=" . $prices[$i] . "&link=" . $links[$i] 
                                . "\">&#10084;</a></li>";
                        }
                    ?>
                    </ol>
                </div>

                <?php 
                if(!empty($items)) { ?>
                <div class="page_manager">
                    <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?><?php if($pg == 0) {echo "#";} else {echo "?page=" . ($pg - 1);}?>"><</a>
                    <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?>page=0"
                    style="background-color:<?php if($pg == 0) {echo'orange';}?>;">1</a>
                    <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?>page=1"
                    style="background-color:<?php if($pg == 1) {echo'orange';}?>;">2</a>
                    <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?>page=2"
                    style="background-color:<?php if($pg == 2) {echo'orange';}?>;">3</a>
                    <a class="pagebtn" href="?<?php echo "order=".$sortasc."&"?><?php if($pg == 2) {echo "#";} else {echo "?page=" . ($pg + 1);}?>">></a>
                </div>
                <?php } ?>
            </div>
        </div>

        <script src="Scripts/search.js"></script>
        <script src="Scripts/logout.js"></script>
    </body>
</html>