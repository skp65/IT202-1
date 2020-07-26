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
    <table class="products">
            <tr><img alt="product" src='<?php echo $result["image"]; ?>'/></tr><br><br>
            <tr>Product Name - <?php echo get($result, "name") ?></tr><br><br>
            <tr>$<?php echo get($result, "price"); ?></tr><br><br>
            <tr>Description - <?php echo get($result, "description"); ?></tr>
    </table>

