<?php
include("header.php");
#$search = "";
if (isset($_POST["search"])) {
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product Name"
               value="<?php echo $search;?>"/>
        <input type="submit" value="Search"/>
        <label for="order">Sort By:</label>
        <select name="order" id="order">
            <option value="Ascending">Ascending</option>
            <option value="Descending">Descending</option>
        </select>
    </form>
<?php
if ($_POST['order'] == 'Ascending') {
    //require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/query/asc.sql");
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
elseif ($_POST['order']=='Descending') {
    //require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/query/desc.sql");
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
elseif (isset($search)) {
    //require("common.inc.php");
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
    <table border="1" cellspacing="2" cellpadding="2">
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
        </tr>
    <?php foreach($results as $row):?>
            <tr>
                <td><?php echo '<img src="data:image;base64,'.base64_encode($row['image']).'" 
                alt="Image" style="width:250px; height:500px;">' ?></td>
                <td><?php echo get($row, "name") ?></td>
                <td><?php echo get($row, "price"); ?></td>
                <td><?php echo get($row, "description");?></td>
            </tr>
    <?php endforeach;?>
    </table>
<?php else: ?>
    <p>No Match Found.</p>
<?php endif; ?>


