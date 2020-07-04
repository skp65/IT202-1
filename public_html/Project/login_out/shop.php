<?php
session_start();
include("header.php");
$status = "";
if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $stmt = getDB()->prepare ("select * from Products where code= '$code'");
    $stmt->execute ();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $_SESSION["shopping_cart"] = array_merge(
                $_SESSION["shopping_cart"], $cartArray
            );
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
$cart_count = count(array_keys($_SESSION["shopping_cart"])); ?>

<div class="cart_div">
    <a href="cart.php"><img src="../images/cart.jpg" alt="cart"/> Cart<span>
    <?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>
<?php
$stmt = getDB()->prepare ("select * from Products");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    echo "<div class='product-wrapper'>
        <form method='post' action=''>
            <input type='hidden' name='code' value=" . $row['code'] . " />
            <div class='image'><img src='" . $row['image'] . "' /></div>
            <div class='name'>" . $row['name'] . "</div>
            <div class='price'>$" . $row['price'] . "</div>
            <button type='submit' class='buy'>Add to Cart</button>
        </form>
        </div>";
}
$stmt = null;   //close connection.
?>
<div style="clear:both;"></div>
<!DOCTYPE html>
<html>
<head>
    <div class="message_box" style="margin:10px 0px;">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <button style="font-size:24px"><i class="fa fa-shopping-cart"></i></button>
        </head>
</html>
<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
</div>
</body>
</html>