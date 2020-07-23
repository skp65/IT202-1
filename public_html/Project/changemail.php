<?php
include_once(__DIR__."/partials/header.php");
$id = -1;
$result = array();
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $db->prepare("SELECT email FROM Users where id = :id");
    $stmt->execute([":id" => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No id provided in url, don't forget this or email won't change.";
}
?>
    <div class="wrapper">
        <form method="POST">
            <div>
                <label for="email">New Email</label><br>
                <input type="email" id="email" name="email" placeholder="New Email" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="update" value="Change Email"/>
                <input type="button" class="submit"
                       onclick="window.location.href='login.php'"
                       value="Login"/>
            </div>
        </form>
    </div>
<?php
if (isset($_POST["update"])) {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $id = $_GET["id"];
            require ("common.inc.php");
            try {
                $stmt = getDB()->prepare("SELECT email FROM Users where id = :id  ");
                $stmt->execute(array(
                    ":email" => $email,
                    ":id" => $id
                ));

                if ($stmt->rowCount()>0){
                    echo "<div style='text-align: center'>Email exists! Use another Email</div>";
                }else{
                    $query = getDB()->prepare("UPDATE Users set email = :email where id = :id" );
                    $query->execute(array(":email" => $email,
                                          ":id" => $id
                    ));
                    echo "<div style='text-align: center'>Email Changed! </div>";
                }
                $e = $stmt->errorInfo();
               /* if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    echo "<div style='text-align: center'>Email Changed! </div>";
                }*/
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "<div style='text-align: center'>Error Changing email </div>";
        }
}
?>