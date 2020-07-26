<?php
session_start();
include("header.php");
$status = "";

$product_id = -1;
$result = array();
if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $stmt = getDB()->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
    <table class="products" style="text-align: center; font-size: 20px">
            <tr><td><img alt="product" src='<?php echo $result["image"] ;?>' style="width='200px'; height='200px';
            padding-left: 75%; padding-top: 10%"
                    /></td></tr><br><br>
        <tr><h2>Product Name - <?php echo get($result, "name") ?></h2></tr><br><br>
        <tr><h2>Price - $<?php echo get($result, "price"); ?></h2></tr><br><br>
        <tr><h2>Description - <?php echo get($result, "description"); ?></h2></tr>
    </table>

