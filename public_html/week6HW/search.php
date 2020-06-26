<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
    <form method="POST">
        <input type="text" name="search" placeholder="Search for Product Name"
               value="<?php echo $search;?>"/>
        <input type="submit" value="Search"/>
    </form>
<?php
if(isset($search)) {

    require("common.inc.php");
    $query = file_get_contents(__DIR__ . "/query/search.sql");
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":name"=>$search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
<?php if(isset($results) && count($results) > 0):?>
    <p>The results are displayed.</p>
    <ul>
        <?php foreach($results as $row):?>
            <li>
                <?php echo get($row, "name")?>
                <?php echo get($row, "quantity");?>
                <?php echo get($row, "price");?>
                <?php echo get($row, "description");?>
                <a href="delete.php?thingId=<?php echo get($row, "id");?>">Delete</a>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p>No Match Found.</p>
<?php endif;?>