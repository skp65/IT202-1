<?php
require_once(__DIR__ . "/partials/header.php");
$status = "";

$product_id = -1;
$result = array();
if(isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            if ($_POST["id"] == $key) {
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
        if ($value['id'] === $_POST["id"]) {
            $value['quantity'] = $_POST["quantity"];
            break;
        }
    }
}
?>
<html>
<body>
<h2>Shopping Cart</h2>
<a href="shop1.php">
    <h2> Return to Products</h2></a>
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
                            <input type='hidden' name='id' value="<?php echo $product["id"]; ?>"/>
                            <input type='hidden' name='action' value="remove"/>
                            <button type='submit' class='remove'>Remove Item</button>
                        </form>
                    </td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='id' value="<?php echo $product["id"]; ?>"/>
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
            <tr><td colspan="5" align="right">
                <form method="post" action="">
                    <button type="submit" class="order">Place Order</button>
                </form></td>
            </tr>
            </tbody>
        </table>
        <?php
    } else {
        echo "<h3>Your cart is empty</h3>";
    }
    ?>
    <?php
    if(isset($_POST['order'])) {
            if (isset($_SESSION['user'])) {
                if ($_POST['order']) {
                    $user_id = $_SESSION["user"]["id"];
                   // $product_id = $_GET["product_id"];
                    $price = $total;
                    $stmt = getDB()->prepare("SELECT COUNT(*) AS rows FROM Orders where user_id = :user_id and product_id = :product_id");
                    $stmt->execute([":user_id" => $user_id,
                                    ":product_id" => $product_id]);
                    $rows = (int)$stmt["rows"];
                    if($rows == 0){
                        $stmt = getDB()->prepare("INSERT INTO Orders (user_id, price) 
                        VALUES (:user_id, :price)");
                        $stmt->execute([":user_id" => $user_id, ":price" => $price]);
                        echo "Order Placed";
                    }
                    else{
                        ?>
                        <p style="text-align: center"><?php echo "No order placed!"?></p><?php;
                    }
                }
            }
        }
    ?>
</div>
</div>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
    <?php echo $status; ?>
</div>
</body>
</html>
