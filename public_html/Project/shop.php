<?php
session_start();
include("header.php");
$status = "";

/*$product_id = -1;
$result = array();
if(isset($_GET["product_id"])) {
$product_id = $_GET["product_id"];
$stmt = $db->prepare("SELECT * FROM Products where id = :id");
$stmt->execute([":id" => $product_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);*/

if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $stmt = getDB()->prepare("select * from Products where code= '$code'");
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $results['name'];
    $code = $results['code'];
    $image = $results['image'];
    $price = $results['price'];

    $cartArray = array(
        $code => array(
            'name' => $name,
            'code' => $code,
            'image' => $image,
            'price' => $price,
            'quantity' => 1)
    );

    /*if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box'>Product is added to your cart</div>";
    } else {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "<div class='box' style='color:red;'>Product is already added to your cart</div>";
        } else {
            $_SESSION["shopping_cart"] = array_merge(
                $_SESSION["shopping_cart"], $cartArray
            );
            $status = "<div class='box'>Product is added to your cart</div>";
        }
    }
}*/
?>
<html>
<body>
<div>
    <?php
    if (!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    } ?>
    <div class="cart_div">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <a href="cart.php">
            <img src="images/cart.jpg" style="width: 50px"/>
            <span><?php echo $cart_count; ?></span></a>
    </div>
    <?php

    $start = 0;
    $per_page = 1;
    $page_counter = 0;
    $next = $page_counter + 1;
    $previous = $page_counter - 1;

    if(isset($_GET['start'])) {
        $start = $_GET['start'];
        $page_counter = $_GET['start'];
        $start = $start * $per_page;
        $next = $page_counter + 1;
        $previous = $page_counter - 1;
    }

    $query = getDB()->prepare("SELECT * FROM Products LIMIT $start, $per_page");
    $query->execute();

    if($query->rowCount() > 0){
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $count_query = "SELECT * FROM Products";
    $query = getDB()->prepare($count_query);
    $query->execute();
    $count = $query->rowCount();
    $page = ceil($count / $per_page); ?>

<?php
}
    foreach($res as $row) {
        echo "<div class='product-wrapper'>
        <br>
        <form method='post' action='' style='text-align: center' >
            <input type='hidden' name='code' value=" . $row['code'] . " />
            <div class='row'>
                <div class='column'>
                <img src='" . $row['image'] . "' style='width: 150px; height: 150px; '/></div></div>
                <div class='column'>" . $row['name'] . "</div>
                <div class='column'>$" . $row['price'] . "</div>
                <button type='submit' class='buy'><a href='cart.php'></a> Add to Cart</button>
        </form>
        </div>";
    }
    ?>
    <center>
        <ul class="pagination">
            <?php
            if($page_counter == 0){
                echo "<li><a href=?start='0' class='active'>0</a></li>";
                for($i = 1; $i < $page; $i++) {
                    echo "<li><a href=?start=$i>".$i."</a></li>";
                }
            }else{
                echo "<li><a href=?start=$previous>Previous</a></li>";
                for($i = 0; $i < $page; $i++) {
                    if($i == $page_counter) {
                        echo "<li><a href=?start=$i class='active'>".$i."</a></li>";
                    }else{
                        echo "<li><a href=?start=$i>".$i."</a></li>";
                    }
                }if($i != $page_counter+1)
                    echo "<li><a href=?start=$next>Next</a></li>";
            }
            ?>
        </ul>
    </center>
</div>
</body>
</html>