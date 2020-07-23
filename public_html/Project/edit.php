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
            <input type="text" id="products" name="name" value="<?php echo get($result, "name");?>"/>
        </label>
        <label for="q">Code
            <input type="text" id="c" name="code"  value="<?php echo get($result, "code");?>"/>
        </label>
        <label for="p">Price
            <input type="number" id="p" name="price"  value="<?php echo get($result, "price");?>"/>
        </label>
        <label for="d">Description
            <input type="text" id="d" name="description"  value="<?php echo get($result, "description");?>"/>
        </label>
        <input type="submit" name="updated" value="Update Product"/>
    </form>
<?php
if (isset($_POST["updated"])) {
    $name = $_POST["name"];
    $code = $_POST["code"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    if (!empty($name) && !empty(code) && !empty($price) && !empty($description)) {
        try {
            $stmt = $db->prepare("UPDATE Products set name = :name, code = :code, price = :price, 
                description = :description where id= :id");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":code" => $code,
                ":price" => $price,
                ":description" => $description,
                ":id" => $product_id
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
               // echo var_export($result, true);
                if ($result){
                    echo "Successfully updated Product: " . $name;
                }
                else{
                    echo "Error updating record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name, code, price and description  must not be empty.";
    }
}
?>