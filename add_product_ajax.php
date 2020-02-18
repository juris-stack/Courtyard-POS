
<?php 
	 include 'config.php';
	
    $productname = strip_tags($_POST['product_name']);
    $price = strip_tags($_POST['price']);
    $stock = strip_tags($_POST['stock']);
    $barcode = strip_tags($_POST['barcode']);
    $description = strip_tags($_POST['description']);
    $uploadfile = "img/upload-product.png";

    if($_FILES["fileToUpload"]["name"] == null){
    $sql = "INSERT INTO `pos`.`product`(`product_id`,`product_name`,`product_description`,`product_price`,`total_stock`,`remaining_stock`,`barcode_no`,`product_media`,`notif_status`) VALUES('','$productname','$description','$price','$stock','$stock','$barcode','$uploadfile','1')";
    mysqli_query($link, $sql) or die(mysqli_error());

      $r = ['success' => true];
      header('Content-Type: application/json');
      echo json_encode($r);
      return;

    }else{

    $newNamePrefix = time() . '_';
    $target_dir = "upl/";
    $target_file = $target_dir .$newNamePrefix. basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
       $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            header("HTTP/1.1 422 Unprocessable Entity");
            exit;
            return;
            $uploadOk = 0;
        }
    // Check if file already exists
    if (file_exists($target_file)) {   
        header("HTTP/1.1 422 Unprocessable Entity");
            exit;
            return;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
        header("HTTP/1.1 422 Unprocessable Entity");
            exit;
            return;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        header("HTTP/1.1 422 Unprocessable Entity");
            exit;
            return;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    // if everything is ok, try to upload file
            header("HTTP/1.1 422 Unprocessable Entity");
            exit;
            return;
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $saveData = 'true';
        } else {
           header("HTTP/1.1 422 Unprocessable Entity");
            exit;
            return;
        }
    }
    if($saveData == 'true'){
   $sql = "INSERT INTO `pos`.`product`(`product_id`,`product_name`,`product_description`,`product_price`,`total_stock`,`remaining_stock`,`barcode_no`,`product_media`,`notif_status`) VALUES('','$productname','$description','$price','$stock','$stock','$barcode','$target_file','1')";
        mysqli_query($link, $sql) or die(mysqli_error());
        
        $r = ['success' => true];
        header('Content-Type: application/json');
        echo json_encode($r);
        return;

    }
    }

    header("HTTP/1.1 422 Unprocessable Entity");
         exit;


 ?>