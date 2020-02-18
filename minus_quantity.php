<?php include'config.php'?>
<?php
$ID = $_GET['id'];
$res1 = "SELECT * FROM cart WHERE `product_id` = '$ID'";
$result1 = mysqli_query($link, $res1) or die(mysql_error());
    for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
        $productidcart=$num_rows["cart_id"];
        $productname=$num_rows["cart_name"];
        $getminusid=$num_rows["product_id"];
        $price=$num_rows["product_price"];
        $quantity=$num_rows["quantity"];
        $total=$num_rows["total_amount"];
        $time=$num_rows["transaction_time"];
    }
$res2 = "SELECT * FROM product WHERE `product_id` = '$ID'";
$result2 = mysqli_query($link, $res2) or die(mysql_error());
    for($i=0; $i<$num_rows=mysqli_fetch_array($result2);$i++) {
        $remainingstock=$num_rows["remaining_stock"];
        $status=$num_rows["notif_status"];
    }
    if($quantity == '0'){
        $remaining = $remainingstock + 0;
        $sql = "UPDATE product SET `remaining_stock` = '$remaining' WHERE `product_id` = '$ID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE cart SET `quantity` = '0', `total_amount` = '0' WHERE `cart_id`  = '$productidcart' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE sales SET `quantity` = '0', `total_amount` = '0' WHERE `transaction_time`  = '$time' ";
        mysqli_query($link, $sql) or die(mysqli_error());
        
        header('location: pos.php');

    }else{
        $add_stock = $remainingstock + 1;
        $minus_quantity = $quantity - 1;
        $total_amount = $total - $price;
        $sql = "UPDATE product SET `remaining_stock` = '$add_stock' WHERE `product_id` = '$ID'  ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE cart SET `quantity` = '$minus_quantity', `total_amount` = '$total_amount' WHERE `cart_id`  = '$productidcart' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE sales SET `quantity` = '$minus_quantity', `total_amount` = '$total_amount' WHERE `transaction_time`  = '$time' ";
        mysqli_query($link, $sql) or die(mysqli_error());
            
        header('location: pos.php');
    }
    if($status == '0'){
        $sql = "UPDATE product SET `notif_status` = '1' WHERE `product_id` = '$ID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
            header('location: pos.php');
    }
?>