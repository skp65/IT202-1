<?php
session_start();
include('../config1.php');
$status="";
if (isset($_POST['code']) && $_POST['code']!=""){
    $code = $_POST['code'];
    $result = mysqli_query($db,"SELECT * FROM `Products` WHERE `code`='$code'");
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $code = $row['code'];
    $price = $row['price'];
    $image = $row['image'];

//echo "<BR> " . $name . "<BR>" . $code . "<BR>" . $prince . "<Br>" . $image;
    $cartArray = array(
        $code=>array(
            'name'=>$name,
            'code'=>$code,
            'price'=>$price,
            'quantity'=>1,
            'image'=>$image)
    );

    if(empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box'  style='color:green; border:1px solid green;padding:15px'>Product is added to your cart!</div>";
    }else{
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if(in_array($code,$array_keys)) {
            $status = "<div class='box' style='color:red;border:1px solid red; padding:15px'>
		Product is already added to your cart!</div>";
        } else {
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
            $status = "<div class='box' style='color:green;border: 1px solid green;padding:15px'>Product is added to your cart!</div>";
        }

    }
}


if(isset($_REQUEST['Logout']) && $_REQUEST['Logout']=="logout")
{
    unset($_SESSION['Logged']);
    header("location:index.php?Msg=You are successfully Logout ");
}


?>
<html>
<head>
    <link rel='stylesheet' href='style.css' type='text/css' media='all' />
</head>
<body >
<div style="width:700px; margin:50 auto;">
    <?php

    ?>
    <form>
        <button type='submit' name="Logout" value="logout" name="logout" class='logout'>Logout</button>
    </form>
    <?php
    if(!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
        ?>
        <div class="cart_div">
            <a href="cart.php"><meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <button style="font-size:24px"><i class="fa fa-shopping-cart"></i></button>
            </a>
        </div>

        <?php
        echo "<BR><BR>";
    }

    $result = mysqli_query($db,"SELECT * FROM `Products`");
    while($row = mysqli_fetch_assoc($result)){
        echo "<div class='product_wrapper'>
			  <form method='post' action=''>
			  <input type='hidden' name='code' value=".$row['code']." />
			  <div class='image'><img src='".$row['image']."' /></div>
			  <div class='name'>".$row['name']."</div>
		   	  <div class='price'>$".$row['price']."</div>
			  <button type='submit' class='buy'>Buy Now</button>
			  </form>
		   	  </div>";
    }
    mysqli_close($db);
    ?>

    <div style="clear:both;"></div>
    <!DOCTYPE html>
    <html>
    <head>
        <div class="message_box" style="margin:10px 0px;">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <button style="font-size:24px"><i class="fa fa-shopping-cart"></i></button>
            </head>
    </html>

    <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
    </div>

</div>
</body>
</html>