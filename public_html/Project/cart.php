<?php
include("header.php");
$status = "";
if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            if ($_POST["code"] == $key) {
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='box' style='color:red;'>Product is removed from your cart</div>";
            }
            if (empty($_SESSION["shopping_cart"]))
                unset($_SESSION["shopping_cart"]);
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['code'] === $_POST["code"]) {
            $value['quantity'] = $_POST["quantity"];
            break;
        }
    }
}
if (isset($_REQUEST['Logout']) && $_REQUEST['Logout'] == "logout") {
    unset($_SESSION['Logged']);
    header("location:login.php?Msg=You are successfully Logout ");
}
?>
<html>
<body>
<h2>Shopping Cart</h2>
<a href="shop.php">
    <h2> Return to Home</h2></a>
<?php
if (!empty($_SESSION["shopping_cart"])) {
    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    ?>
    <?php
}
?>
<div class="cart">
    <?php
    if (isset($_SESSION["shopping_cart"])) {
        $total_price = 0;
        ?>
        <table class="table" width="80%">
            <tbody>
            <td colspan=5 align="right">
                <div class="cart_div">
                    <a href="cart.php">
                        <img src="images/cart.jpg" style="width: 50px"/>
                        <span><?php echo $cart_count; ?></span></a>
                </div>
            </td>
            <tr>
                <td>IMAGE</td>
                <td>NAME</td>
                <td>QUANTITY</td>
                <td>PRICE</td>
                <td>TOTAL</td>
            </tr>
            <?php
            foreach ($_SESSION["shopping_cart"] as $product) {
                ?>
                <tr>
                    <td><img src='<?php echo $product["image"]; ?>' width="70" height="70"/></td>
                    <td><?php echo $product["name"]; ?><br/>
                        <form method='post' action=''>
                            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>"/>
                            <input type='hidden' name='action' value="remove"/>
                            <button type='submit' class='remove'>Remove Item</button>
                        </form>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>"/>
                            <input type='hidden' name='action' value="change"/>
                            <select name='quantity' class='quantity' onchange="this.form.submit()">
                                <option <?php if ($product["quantity"] == 1) echo "selected"; ?> value="1">1</option>
                                <option <?php if ($product["quantity"] == 2) echo "selected"; ?> value="2">2</option>
                                <option <?php if ($product["quantity"] == 3) echo "selected"; ?> value="3">3</option>
                                <option <?php if ($product["quantity"] == 4) echo "selected"; ?> value="4">4</option>
                                <option <?php if ($product["quantity"] == 5) echo "selected"; ?> value="5">5</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo "$" . $product["price"]; ?></td>
                    <td><?php echo "$" . $product["price"] * $product["quantity"]; ?></td>
                </tr>
                <?php
                $total += ($product["price"] * $product["quantity"]);
            }
            ?>
            <tr>
                <td colspan="5" align="right">
                    <strong>TOTAL: <?php echo "$" . $total; ?></strong>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
    } else {
        echo "<h3>Your cart is empty</h3>";
    }
    ?>
</div>

<div style="clear:both;"></div>
<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
</div>
</body>
</html>
