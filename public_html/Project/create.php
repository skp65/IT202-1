<form method="POST">
    <label for="products">Product Name
        <input type="text" id="products" name="name"/>
    </label>
    <label for="code">Code
        <input type="number" id="code" name="code"/>
    </label>
    <label for="q">Quantity
        <input type="number" id="q" name="quantity"/>
    </label>
    <label for="p">Price
        <input type="number" id="p" name="price"/>
    </label>
    <label for="d">Description
        <input type="text" id="d" name="description"/>
    </label>
    <input type="submit" name="created" value="Create Product"/>
</form>

<?php
if (isset($_POST["created"])) {
    $name = $_POST["name"];
    $code = $_POST["code"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    if (!empty($name) && !empty($code) && !empty($quantity) && !empty($price) && !empty($description)) {
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO Products (name, code, quantity, price, description)   
                VALUES (:name, :code, :quantity, :price, :description)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":code" => $code,
                ":quantity" => $quantity,
                ":price" => $price,
                ":description" => $description
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
               // echo var_export($result, true);
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
        echo "Name, code, quantity, price and description must not be empty.";
    }
}
?>
