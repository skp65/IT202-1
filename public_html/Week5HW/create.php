<form method="POST">
    <label for="products">Product Name
        <input type="text" id="products" name="name"/>
    </label>
    <label for="q">Quantity
        <input type="number" id="q" name="quantity"/>
    </label>
    <label for="p">Price
        <input type="number" id="p" name="price"/>
    </label>
    <input type="submit" name="created" value="Create Product"/>
</form>

<?php
if (isset($_POST["created"])) {
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $quantity = $_POST["price"];
    if (!empty($name) && !empty($quantity) && !empty($price)) {
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Products (name, quantity, price) VALUES (:name, :quantity, :price)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":quantity" => $quantity,
                ":price" => $price
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                echo var_export($result, true);
                if ($result) {
                    echo "Successfully inserted new product: " . $name;
                } else {
                    echo "Error inserting record";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "Name, quantity and price must not be empty.";
    }
}
?>
