<?php
require_once(__DIR__ . "partials/header.php");
$search = "";
if (isset($_POST["search"])) {
    $search = $_POST["search"];
}
?>
<form method="POST">
    <input type="text" name="search" placeholder="Search for Products"
           value="<?php echo $search; ?>"/>
    <select name="col">
        <option value="name">Name</option>
    </select>
    <select name="order">
        <option value="1">Asc</option>
        <option value="0">Desc</option>
    </select>
    <input type="submit" value="Search"/>
</form>

<?php
if (isset($search)) {
    try {
        $order = $_POST["order"];
        $mapped_col = "name";
        $query = "SELECT * FROM Products where name like CONCAT('%', :name, '%') ORDER BY $mapped_col";
        if((int)$order == 1){
            $query .= " ASC";
        }
        else{
            $query .= " DESC";
        }
        $stmt = getDB()->prepare($query);
        $stmt->execute([":thing"=>$search]);
        echo var_export($stmt->errorInfo());
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<?php if (isset($results) && count($results) > 0): ?>
    <table border="1" cellspacing="2" cellpadding="2">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><img alt="product" src='<?php echo $row["image"]; ?>' width="100px" height="100px"/></td>
                <td><?php echo get($row, "name") ?></td>
                <td><?php echo get($row, "price"); ?></td>
                <td><?php echo get($row, "description"); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No Match Found.</p>
<?php endif; ?>


