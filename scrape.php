<!--NOT USED-->
<?php
    include('simple_html_dom.php');

    $websiteUrl = "https://www.flipkart.com/search?q=watch&otracker=search&otracker1=search&marketplace=FLIPKART&as-show=on&as=off";
    $html = file_get_html($websiteUrl);

    $i = 0;
    $items = array();
    foreach($html->find('._1YokD2 _3Mn1Gg') as $section) {
            $i++;
        foreach($section->find('a') as $item) {
            if ($item->hasAttribute('title')) {
                array_push($items, $item->attr['title']);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ol id="test">
        <?php
            foreach ($items as $val) {
                echo "<li>" . $val . "</li>";
            }
        ?>
    </ol>
    <?php
        echo $i;
    ?>
    <!-- <?php 
        foreach ($items as $val) {
            echo $val . "<br>";
        } 
    ?> -->
    
</body>
</html>