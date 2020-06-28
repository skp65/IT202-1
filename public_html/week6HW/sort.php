<?php
#$search = "";
if (isset($_POST["search"])) {
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product Name"
               value="<?php echo $search;?>"/>
        <input type="submit" value="Search"/>
    </form>
<?php
if (isset($search)) {
    require("common.inc.php");
    $order="asc";
    if($_GET['orderby']=="name" && $_GET['order']=="asc")
    {
        $order="desc";
    }
    if($_GET['orderby'])
    {
        $orderby="order by ".$_GET['orderby'];
    }
    if($_GET['order'])
    {
        $sort_order= $_GET['order'];
    }
    $query = "SELECT * FROM Products where name like CONCAT('%', :name, '%') ."$orderby." ."$sort_order."";
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":name" => $search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

?>
<?php if (isset($results) && count($results) > 0): ?>
    <table border="1" cellspacing="2" cellpadding="2">
        <tr>
            <th><a href="?orderby=name&order=".$order."">Product Name</a></th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Description</th>
        </tr>
    <?php foreach($results as $row):?>
            <tr>
                <td><?php echo get($row, "name") ?></td>
                <td><?php echo get($row, "quantity"); ?></td>
                <td><?php echo get($row, "price"); ?></td>
                <td><?php echo get($row, "description");?></td>
            </tr>
    <?php endforeach;?>
    </table>
<?php else: ?>
    <p>No Match Found.</p>
<?php endif; ?>


