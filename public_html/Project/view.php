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
    <table style="text-align: center; font-size: 20px">
            <tr><img alt="product" src="<?php echo $result["image"] ;?>" style="display: block; margin-left: auto;
             margin-right: auto; margin-top: 2%; width: 40%; border-radius: 8px"
                    /></tr>
        <tr><h2 style="padding-left:30%; font-size: 22px">Product Name - <?php echo get($result, "name") ?></h2></tr>
        <tr><h2 style="padding-left:30%; font-size: 22px">Price - $<?php echo get($result, "price"); ?></h2></tr>
        <tr><h2 style="padding-left:30%; font-size: 22px">Description - <?php echo get($result, "description"); ?></h2></tr>
    </table>

