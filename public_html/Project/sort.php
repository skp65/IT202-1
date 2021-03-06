<?php
//$search = "";
require_once(__DIR__ . "/partials/header.php");
if (isset($_POST["search"])) {
    $search = $_POST["search"];
}
if (isset($search)) {
    require("common.inc.php");
    try {
        $order = $_POST["order"];
        $col = $_POST["col"];
        $mapped_col = "name";
        if($col == "name"){
            $mapped_col = "name";
        }
        else if($col == "created"){
            $mapped_col = "created";
        }
        else if($col == "price"){
            $mapped_col = "price";
        }
        $query = "SELECT * FROM Products where name like CONCAT('%', :name, '%') ORDER BY $mapped_col";
        if ((int)$order == 1) {
            $query .= " ASC";
        } else {
            $query .= " DESC";
        }
        $stmt = getDB()->prepare($query);
        $stmt->execute([":name" => $search]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
$product_id = -1;
$result = array();
if(isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<br>
<form method="POST" style="text-align: center">
    <input type="text" name="search" placeholder="Search for Products"
           value="<?php echo $search; ?>"/>
    <select name="col">
        <option value="name">Name</option>
        <option value="price">Price</option>
        <option value="created">Date Added</option>
    </select>
    <select name="order">
        <option value="1">Asc</option>
        <option value="0">Desc</option>
    </select>
    <input type="submit" value="Search"/>
</form>


<?php
if (isset($results) && count($results) > 0): ?>
    <table border="1" cellspacing="2" cellpadding="2" style="margin: auto">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><img alt="product" src='<?php echo $row["image"]; ?>' width="100px" height="100px"/></td>
                <td style="text-align: center"><?php echo get($row, "name") ?></td>
                <td style="text-align: center"><?php echo get($row, "price"); ?></td>
                <td style="text-align: center"><?php echo get($row, "description"); ?></td>
                <td style="text-align: center"><a href="view.php?product_id=<?php echo get($row, "id"); ?>">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style="text-align: center">No Match Found.</p>
<?php endif; ?>


