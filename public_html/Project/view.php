<?php
session_start();
include("header.php");
$status = "";

$product_id = -1;
$result = array();
if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <!--
<form method='post' style='text-align: center' action="view.php?product_id=<//?php echo get($result, "id")?>">
    <div class='row'>
        <div class='column'>
            <img src='<//?php echo get($result, "image");?>'/></div>
        <div class='column'><//?php echo get($result, "name");?></div>
        <div class='column'>$<//?php echo get($result, "price");?></div>
        <div class='column'><//?php echo get($result, "description");?></div>
    </div>
</form>-->
    <?php foreach ($result as $row): ?>
        <tr>
            <td><img alt="product" src='<?php echo $row["image"]; ?>' width="200px" height="200px"/></td>
            <td style="text-align: center"><?php echo get($row, "name") ?></td>
            <td style="text-align: center"><?php echo get($row, "price"); ?></td>
            <td style="text-align: center"><?php echo get($row, "description"); ?></td>
        </tr>
    <?php endforeach; ?>
<?php } ?>
