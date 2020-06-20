<?php
require("common.inc.php");
$db = getDB();
//example usage, change/move as needed
$product_id = -1;
$result = array();
if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $stmt = $db->prepare("SELECT * FROM Products where id = :id");
    $stmt->execute([":id" => $product_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No product_id provided in url, don't forget this or it won't edit.";
}
?>
    <form method="POST">
        <label for="products">Product Name
            <input type="text" id="products" name="name" value="<?php echo get($result, "name"); ?>"/>
        </label>
        <label for="q">Quantity
            <input type="number" id="q" name="quantity" value="<?php echo get($result, "quantity"); ?>"/>
        </label>
        <label for="p">Price
            <input type="number" id="p" name="price" value="<?php echo get($result, "price"); ?>"/>
        </label>
        <label for="d">Description
            <input type="text" id="d" name="description" value="<?php echo get($result, "description"); ?>"/>
        </label>
        <?php if ($product_id > 0): ?>
            <input type="submit" name="delete" value="Delete Product"/>
        <?php endif; ?>
    </form>
<?php
if (isset($_POST["updated"]) || isset($_POST["created"]) || isset($_POST["delete"])) {
    $delete = isset($_POST["delete"]);
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    if (!empty($name) && !empty($quantity) && !empty($price) && !empty($description)) {
        try {
            if ($delete) {
                $stmt = $db->prepare("DELETE from Products where id= :id");
                $result = $stmt->execute(
                        array(":id" => $product_id));
                }
            }

            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            }
            else {
                //echo var_export($result, true);
                if ($result) {
                    echo "Successfully interacted with product: " . $name;
                }
                else {
                    echo "Error updating record";
                }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    else {
        echo "Name, quantity, price and description  must not be empty.";
    }
}
?>