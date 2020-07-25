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
<style>
    .products tr{
        text-align: center;
        font-size: 20px;
    }
    .products img{
        width: 200px;
        height: 200px;
        padding-left: 75%;
        padding-top: 10%;
    }
</style>
    <table class="products">
            <tr><img alt="product" src='<?php echo $result["image"]; ?>'/></tr>
            <tr>Product Name - <?php echo get($result, "name") ?></tr>
            <tr>$<?php echo get($result, "price"); ?></tr>
            <tr>Description - <?php echo get($result, "description"); ?></tr>
    </table>

