<?php 
	 include 'config.php';


	try {
    
	

	$nameupdate = $_POST['product_name'];
	if(isset($_POST['name'])){

    $name = $_POST['name'];

    $editID =$_POST['id'];
        $sql = "UPDATE product SET `product_name` = '$name' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE product_stock_inventory SET `product_name` = '$name' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE product_price_updates SET `product_name` = '$name' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

       
    }


	else if(isset($_POST['price'])){

    $priorprice=$_POST['current'];
    $newprice = $_POST['price'];
    date_default_timezone_set('Asia/Manila');
    $date = date('h:i a | Y/m/d');

    $editID =$_POST['id'];
         $sql = "UPDATE product SET `product_price` = '$newprice' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

    $update_price = "INSERT INTO `product_price_updates` (`price_inventory_id`, `product_name`, `prior_price`, `new_price`, `date_updated`, `product_id`) VALUES (NULL, '$nameupdate', '$priorprice', '$newprice', '$date', '$editID')";

  

    mysqli_query($link, $update_price) or die(mysqli_error());

   

    }

    else if(isset($_POST['stock'])){

    $stockupdate=$_POST['current'];
    $newstock = $_POST['stock'];
    $addedstock = $stockupdate + $newstock;
    date_default_timezone_set('Asia/Manila');
    $date = date('h:i a | Y/m/d');

    $editID = $_POST['id'];
    $sql = "UPDATE product SET `total_stock` = '$addedstock', `remaining_stock` = '$addedstock' WHERE `product_id`  = '$editID' ";
    mysqli_query($link, $sql) or die(mysqli_error());

    $sql1 = "INSERT INTO `product_stock_inventory` (`stock_inventory_id`, `product_id`, `product_name`, `prior_stock`, `added_stock`, `new_stock`, `date_updated`) VALUES (NULL,'$editID' ,'$nameupdate', '$stockupdate', '$addedstock', '$newstock','$date')";
    mysqli_query($link, $sql1) or die(mysqli_error());

    }

    else if(isset($_POST['description'])){

    $description = $_POST['description'];

    $editID = $_POST['id'];
    $sql = "UPDATE product SET `product_description` = '$description' WHERE `product_id`  = '$editID' ";
    mysqli_query($link, $sql) or die(mysqli_error());
   
    }





    header('Content-Type: application/json');
    $r = ['success' => true];
	echo json_encode($r);
       return;
    } catch (Exception $e) {
	    header("HTTP/1.1 422 Unprocessable Entity");
        return;
	}


?>

