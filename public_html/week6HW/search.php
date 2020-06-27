<?php
#$search = "";
if (isset($_POST["search"])) {
    $search = $_POST["search"];
}
?>
    <button onclick="sort()">Sort</button>
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
    <table border="1" cellspacing="2" cellpadding="2" id="table">
        <tr>
            <th>Product Name</th>
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

<script>
    function sort() {
        var list, i, switch, b, shouldSwitch, dir, switchcount = 0;
        list = document.getElementById("table");
        switch = true;
        dir = "asc";
        while (switch) {
            switch = false;
            b = list.getElementsByTagName("td");
            for (i = 0; i < (b.length - 1); i++) {
                shouldSwitch = false;
                if (dir == "asc") {
                    if (b[i].innerHTML.toLowerCase() > b[i + 1].innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (b[i].innerHTML.toLowerCase() < b[i + 1].innerHTML.toLowerCase()) {
                        shouldSwitch= true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                b[i].parentNode.insertBefore(b[i + 1], b[i]);
                switch = true;
                switchcount ++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switch = true;
                }
            }
        }
    }
</script>
