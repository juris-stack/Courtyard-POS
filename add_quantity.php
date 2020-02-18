<?php include'config.php'?>
<?php
$addID = $_GET['id'];
$res1 = "SELECT * FROM cart WHERE `product_id` = '$addID'";
$result1 = mysqli_query($link, $res1) or die(mysql_error());
    for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
        $productid=$num_rows["cart_id"];
        $productname=$num_rows["cart_name"];
        $price=$num_rows["product_price"];
        $quantity=$num_rows["quantity"];
        $total=$num_rows["total_amount"];
        $time=$num_rows["transaction_time"];
    }
$res2 = "SELECT * FROM product WHERE `product_id` = '$addID'";
$result2 = mysqli_query($link, $res2) or die(mysql_error());
    for($i=0; $i<$num_rows=mysqli_fetch_array($result2);$i++) {
        $remaining_stock=$num_rows["remaining_stock"];
    }
    
    if($remaining_stock == '1'){
        $zero_stock = $remaining_stock - '1';
        $zero_quantity = $quantity + '1';
        $total_price = $price + $total;

        $addstock = "UPDATE product SET `remaining_stock` = '$zero_stock', `notif_status` = '0' WHERE `product_id` = '$addID' ";
        mysqli_query($link, $addstock) or die(mysqli_error());
            
        $sql = "UPDATE cart SET `quantity` = '$zero_quantity', `total_amount` = '$total_price' WHERE `cart_id`  = '$productid' ";
        mysqli_query($link, $sql) or die(mysqli_error());


        $sql1 = "UPDATE sales SET `quantity` = '$zero_quantity', `total_amount` = '$total_price' WHERE `transaction_time`  = '$time' ";
        mysqli_query($link, $sql1) or die(mysqli_error());

        header('location: pos.php');


    }else if($remaining_stock == '4'){
        $zero_stock = $remaining_stock - '1';
        $zero_quantity = $quantity + '1';
        $total_price = $price + $total;

        $addstock = "UPDATE product SET `remaining_stock` = '$zero_stock', `notif_status` = '0' WHERE `product_id` = '$addID' ";
        mysqli_query($link, $addstock) or die(mysqli_error());
            
        $sql = "UPDATE cart SET `quantity` = '$zero_quantity', `total_amount` = '$total_price' WHERE `cart_id`  = '$productid' ";
        mysqli_query($link, $sql) or die(mysqli_error());


        $sql1 = "UPDATE sales SET `quantity` = '$zero_quantity', `total_amount` = '$total_price' WHERE `transaction_time`  = '$time' ";
        mysqli_query($link, $sql1) or die(mysqli_error());

        header('location: pos.php');


    }else{
        $minus_stock = $remaining_stock - '1';
        $add_quantity = $quantity + '1';
        $total_price = $price + $total;

        $addstock = "UPDATE product SET `remaining_stock` = '$minus_stock' WHERE `product_id` = '$addID' ";
        mysqli_query($link, $addstock) or die(mysqli_error());

        $sql = "UPDATE cart SET `quantity` = '$add_quantity', `total_amount` = '$total_price' WHERE `cart_id`  = '$productid' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql1 = "UPDATE sales SET `quantity` = '$add_quantity', `total_amount` = '$total_price' WHERE `transaction_time`  = '$time' ";
        mysqli_query($link, $sql1) or die(mysqli_error());

        header('location: pos.php');
    }
    

?>