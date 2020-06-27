<?php
$search = "";
if (isset($_POST["search"])) {
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product Name"
               value="<?php echo $search; ?>"/>
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
<?php
    if ($results->num_rows > 0){
    echo "
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Description</th>
        </tr>";
        while($row = $results->fetch_assoc()) {
        echo "
        <tr>
            <td>" . $row["name"]. "</td>
            <td>" . $row["quantity"]. "</td>
            <td>" . $row["price"]. "</td>
            <td>" . $row["description"]. "</td>
        </tr>;"
        }
        echo "</table>";
    } else {
    echo "0 results";
    }
?>
<?php else: ?>
    <p>No Match Found.</p>
<?php endif; ?>