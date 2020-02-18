<?php include'config.php'?>
<?php
        if(isset($_POST['submit-delete'])){
            $deleteid = strip_tags($_POST['delete-id']);
            $productname = strip_tags($_POST['delete-name']);
            $remainingquantity = strip_tags($_POST['remaining-quantity']);

            $sql = "SELECT * FROM cart WHERE `product_id` = '$deleteid'";
            $result = mysqli_query($link, $sql) or die(mysql_error());
                  for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                          $purchaseid=$num_rows["cart_id"];
                          $time=$num_rows["transaction_time"];
                }
            $sql = "SELECT * FROM sales WHERE `transaction_time` = '$time'";
            $result = mysqli_query($link, $sql) or die(mysql_error());
                  for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                          $id=$num_rows["sales_id"];
                }
            $sql = "SELECT * FROM product WHERE `product_id` = '$deleteid'";
            $result = mysqli_query($link, $sql) or die(mysql_error());
                  for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                          $productname=$num_rows["product_name"];
                          $remainingstock=$num_rows["remaining_stock"];
                } 
            $stocks = $remainingquantity + $remainingstock;
            $sql = "UPDATE product SET `remaining_stock` = '$stocks' , `notif_Status` = '1' WHERE `product_id` = '$deleteid' ";
            mysqli_query($link, $sql) or die(mysqli_error());

            $deleteQuery = "DELETE FROM cart WHERE `cart_id` = '$purchaseid'";
            mysqli_query($link, $deleteQuery) or die(mysql_error());

            $deleteQuery = "DELETE FROM sales WHERE `sales_id` = '$id'";
            mysqli_query($link, $deleteQuery) or die(mysqli_error());
                
            header("location: pos.php");
        }

    ?>