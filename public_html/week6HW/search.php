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
    $query = file_get_contents(__DIR__ . "/query/search.sql");
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
    echo"<table border="1" cellspacing="2" cellpadding="2">";
        echo"<tr>";
            echo"<th>Product Name</th>";
            echo"<th>Quantity</th>";
            echo"<th>Price</th>";
            echo"<th>Description</th>";
        echo"</tr>";
    <?php foreach($results as $row):?>
            echo"<tr>";
                echo"<td><?php echo get($row, "name") ?></td>";
                echo"<td><?php echo get($row, "quantity"); ?></td>";
                echo"<td><?php echo get($row, "price"); ?></td>";
                echo"<td><?php echo get($row, "description");?></td>";
            echo"</tr>";
    <?php endforeach;?>
    echo"</table>";
<?php else: ?>
    <p>No Match Found.</p>
<?php endif; ?>