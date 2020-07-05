<form method="POST" enctype="multipart/form-data" class="wrapper">
    <label for="products">Product Name
        <input type="text" id="products" name="name"/>
    </label><br>
    <label for="code">Code
        <input type="text" id="code" name="code"/>
    </label><br>
    <label for="img"> Choose an Image
        <input type="file" id="image" name="image"/>
    </label><br>
    <label for="p">Price
        <input type="number" id="p" name="price"/>
    </label><br>
    <label for="d">Description
        <input type="text" id="d" name="description"/>
    </label><br>
    <input type="submit" name="created" value="Create Product"/>
</form>

<?php
if (isset($_POST["created"])) {
    $name = $_POST["name"];
    $code = $_POST["code"];
    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    $price = $_POST["price"];
    $description = $_POST["description"];
    if (!empty($name) && !empty($code) && !empty($file) && !empty($price) && !empty($description)) {
        require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("INSERT INTO products (name, image, code, price, description)   
                VALUES (:name, :image, :code, :price, :description)");
            $result = $stmt->execute(array(
                ":name" => $name,
                ":image" => $file,
                ":code" => $code,
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
        echo "Name, code, image, price and description must not be empty.";
    }
}
?>
