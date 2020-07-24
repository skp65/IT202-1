<?php
session_start();
include("header.php");
$status = "";

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

    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box'>Product is added to your cart</div>";
    } else {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "<div class='box' style='color:red;'>Product is already added to your cart</div>";
        } else {
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
            $status = "<div class='box'>Product is added to your cart</div>";
        }
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
        <a href="cart.php">
            <img src="images/cart.jpg" style="width: 50px"/>
            <span><?php echo $cart_count; ?></span></a>
    </div>
    <?php
    $limit = 2;
    $stmt = getDB()->prepare("SELECT count(*) FROM Products");
    $total_results = $stmt->fetchColumn();
    $total_pages = ceil($total_results/$limit);

    if (!isset($_GET['page'])) {
        $page = 1;
    } else{
        $page = $_GET['page'];
    }
    $start = ($page - 1) * $limit;
    $show = "SELECT * FROM Products ORDER BY id DESC LIMIT ?,?";

    $query = $db->prepare($show);
    $query->execute([$start, $limit]);

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        ?>
    <?php
        echo "<div class='product-wrapper'>
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
    }endwhile; ?>
    <?php
    for ($page=1; $page <= $total_pages ; $page++)?>

    <a href='<?php echo "?page=$page"; ?>' class="links"><?php  echo $page; ?></a>
    <?php endfor;?>
    <div style="clear:both;"></div>
    <!DOCTYPE html>
    <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
    </div>
</div>
</body>
</html>