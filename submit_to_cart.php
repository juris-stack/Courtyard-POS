<?php include'config.php'?>
<?php include 'session_destroyer.php'?>
<?php include 'session_select.php'?>
<?php
$submitID = $_GET['id'];
date_default_timezone_set('Asia/Manila');
$addtcarttime = date('y-m-d h:i:s');
$date = date('y-m-d');
$query = "SELECT * FROM product WHERE `product_id` = '$submitID'";
$result = mysqli_query($link, $query) or die(mysql_error());
      for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
              $productid=$num_rows["product_id"];
              $productname=$num_rows["product_name"];
              $productdescription=$num_rows["product_description"];
              $price=$num_rows["product_price"];
              $productremaining=$num_rows["remaining_stock"];
              $media=$num_rows["product_media"];
            }

  $stock = $productremaining - '1';
  $query = "SELECT * FROM `cart` WHERE `cart_name` = '$productname' and `cashier` = '$cashier' and `cart_description` = '$productdescription'";
  $result = mysqli_query($link, $query) or die(mysql_error());
  if(mysqli_num_rows($result)>0){
    $message = "Purchase already exist!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('pos.php') </script>";
  }else if($productremaining==1){
    $sql = "UPDATE product SET `notif_status` = 0 , `remaining_stock`='$stock'  WHERE `product_id`  = '$submitID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
    $sql = "INSERT INTO `pos`.`cart`(`cart_id`,`product_id`,`cart_name`,`cart_description`,`product_price`,`quantity`,`total_amount`,`product_media`,`transaction_time`,`cashier`) VALUES('','$submitID','$productname','$productdescription','$price','1','$price','$media','$addtcarttime','$cashier')";
    mysqli_query($link, $sql) or die(mysqli_error());
    $sql = "INSERT INTO `pos`.`sales`(`sales_id`,`product_id`,`employee_id`,`purchase_name`,`product_description`,`product_price`,`quantity`,`total_amount`,`product_media`,`cashier`,`transaction_time`,`invoice_number`) VALUES('','$submitID','$logid','$productname','$productdescription','$price','1','$price','$media','$cashier','$addtcarttime','0')";
    mysqli_query($link, $sql) or die(mysqli_error());
    header("location: pos.php");
  }else if($productremaining<=4){
    $sql = "UPDATE product SET `notif_status` = 0 , `remaining_stock`='$stock'  WHERE `product_id`  = '$submitID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
    $sql = "INSERT INTO `pos`.`cart`(`cart_id`,`product_id`,`cart_name`,`cart_description`,`product_price`,`quantity`,`total_amount`,`product_media`,`transaction_time`,`cashier`) VALUES('','$submitID','$productname','$productdescription','$price','1','$price','$media','$addtcarttime','$cashier')";
    mysqli_query($link, $sql) or die(mysqli_error());
    $sql = "INSERT INTO `pos`.`sales`(`sales_id`,`product_id`,`employee_id`,`purchase_name`,`product_description`,`product_price`,`quantity`,`total_amount`,`product_media`,`cashier`,`transaction_time`,`invoice_number`) VALUES('','$submitID','$logid','$productname','$productdescription','$price','1','$price','$media','$cashier','$addtcarttime','0')";
    mysqli_query($link, $sql) or die(mysqli_error());
    header("location: pos.php");
  }else{
    $sql = "INSERT INTO `pos`.`cart`(`cart_id`,`product_id`,`cart_name`,`cart_description`,`product_price`,`quantity`,`total_amount`,`product_media`,`transaction_time`,`cashier`) VALUES('','$submitID','$productname','$productdescription','$price','1','$price','$media','$addtcarttime','$cashier')";
    mysqli_query($link, $sql) or die(mysqli_error());
    $sql = "INSERT INTO `pos`.`sales`(`sales_id`,`product_id`,`employee_id`,`purchase_name`,`product_description`,`product_price`,`quantity`,`total_amount`,`product_media`,`cashier`,`transaction_time`,`invoice_number`) VALUES('','$submitID','$logid','$productname','$productdescription','$price','1','$price','$media','$cashier','$addtcarttime','0')";
    mysqli_query($link, $sql) or die(mysqli_error());
    $sql = "UPDATE product SET `remaining_stock` = '$stock' WHERE `product_id`  = '$submitID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
    header("location: pos.php");
  }
?>