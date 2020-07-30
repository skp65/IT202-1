<?php
session_start();
include("header.php");
$status = "";

if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $stmt = getDB()->prepare("SELECT * FROM Products WHERE id = '$productid'");
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $productid = $results['pid'];
    $name = $results['name'];
    //$code = $results['code'];
    $image = $results['image'];
    $price = $results['price'];

    $cartArray = array(
        $code => array(
            'pid' => $productid,
            'name' => $name,
            //'code' => $code,
            'image' => $image,
            'price' => $price,
            'quantity' => 1)
    );

    if (empty($_SESSION["shopping_cart"])) {
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
}
?>
<?php
if (isset($_POST["buy"])) {
    if (isset($_SESSION["user"])) {
        $userid = $_SESSION["user"]["id"];
        $productid = $_GET["pid"];
        $price = $_GET["price"];
        $stmt=getDB()->prepare("INSERT INTO cart (product_id, quantity, user_id, price) 
        VALUES(:product_id, :quantity, :user_id, :price)");
        $stmt->execute([
                "user_id"=>$userid, "quantity"=> 1, "product_id"=>$productid, "price"=>$price
            ]
        );
    }
}
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <a href="cart.php">
            <img src="images/cart.jpg" style="width: 50px"/>
            <span style="color: black"><?php echo $cart_count; ?></span></a>
    </div>
    <?php
    $start = 0;
    $per_page = 1;
    $page_counter = 0;
    $next = $page_counter + 1;
    $previous = $page_counter - 1;

    if (isset($_GET['start'])) {
        $start = $_GET['start'];
        $page_counter = $_GET['start'];
        $start = $start * $per_page;
        $next = $page_counter + 1;
        $previous = $page_counter - 1;
    }

    $query = getDB()->prepare("SELECT * FROM Products LIMIT $start, $per_page");
    $query->execute();

    if ($query->rowCount() > 0) {
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    $count_query = "SELECT * FROM Products";
    $query = getDB()->prepare($count_query);
    $query->execute();
    $count = $query->rowCount();
    $page = ceil($count / $per_page);

    foreach ($res as $row) {
        echo "<div class='product-wrapper'>
        <br>
        <form method='post' action='' style='text-align: center' >
            <input type='hidden' name='pid' value=" . $row['pid'] . " />
            <div class='row'>
                <div class='column'>
                <img src='" . $row['image'] . "' style='width: 150px; height: 150px; border-radius: 8px'/></div></div>
                <div class='column' style='font-weight: bold; padding-right: 5%'>" . $row['name'] . "</div>
                <div class='column' style='font-weight: bold; padding-right: 5%'>$" . $row['price'] . "</div>
                <button type='submit' class='buy' name='buy' style='font-weight: bold; margin-right: 5%'>
                <a href='cart.php'></a> Add to Cart</button>
        </form>
        </div>";
    }
    ?>
    <center>
        <ul class="pagination">
            <?php
            if ($page_counter == 0) {
                echo "<li><a href=?start='0' class='active'>0</a></li>";
                for ($i = 1; $i < $page; $i++) {
                    echo "<li><a href=?start=$i>" . $i . "</a></li>";
                }
            } else {
                echo "<li><a href=?start=$previous>Previous</a></li>";
                for ($i = 0; $i < $page; $i++) {
                    if ($i == $page_counter) {
                        echo "<li><a href=?start=$i class='active'>" . $i . "</a></li>";
                    } else {
                        echo "<li><a href=?start=$i>" . $i . "</a></li>";
                    }
                }
                if ($i != $page_counter + 1)
                    echo "<li><a href=?start=$next>Next</a></li>";
            }
            ?>
        </ul>
    </center>
</div>
<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
</body>
</html>