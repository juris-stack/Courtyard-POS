<!DOCTYPE html>
<?php include'config.php'?>
<?php
$editID = $_GET['id'];
$res1 = "SELECT * FROM product WHERE `product_id` = '$editID'";
$result1 = mysqli_query($link, $res1) or die(mysql_error());
      for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
        $productidupdate=$num_rows["product_id"];
        $nameupdate=$num_rows["product_name"];
        $priceupdate=$num_rows["product_price"];
        $stockupdate=$num_rows["remaining_stock"];
        $barcodeupdate=$num_rows["barcode_no"];
        $descriptionupdate=$num_rows["product_description"];
        $productmediaupdate=$num_rows["product_media"];
            }
?>
<?php
if(isset($_POST['submit-name'])){

    $name = $_POST['product-name'];

    $editID = $_GET['id'];
        $sql = "UPDATE product SET `product_name` = '$name' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE product_stock_inventory SET `product_name` = '$name' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $sql = "UPDATE product_price_updates SET `product_name` = '$name' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $message = "Product name successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('edit_product.php?id=".$editID."')</script>";
    }


else if(isset($_POST['submit-price'])){

    $priorprice=$_POST['priorprice'];
    $newprice = $_POST['price'];
    date_default_timezone_set('Asia/Manila');
    $date = date('h:i a | Y/m/d');

    $editID = $_GET['id'];
         $sql = "UPDATE product SET `product_price` = '$newprice' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

    $sql1 = "INSERT INTO `pos`.`product_price_updates`(`price_inventory_id`,`product_id`,`product_name`,`prior_price`,`new_price`,`date_updated`) VALUES('','$editID','$nameupdate','$priorprice','$newprice','$date')";
    mysqli_query($link, $sql1) or die(mysqli_error());

    $message = "Price successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('edit_product.php?id=".$editID."')</script>";

    }
else if(isset($_POST['submit-stock'])){

    $stockupdate=$_POST['priorstock'];
    $newstock = $_POST['newstock'];
    $addedstock = $stockupdate + $newstock;
    date_default_timezone_set('Asia/Manila');
    $date = date('h:i a | Y/m/d');

    $editID = $_GET['id'];
    $sql = "UPDATE product SET `total_stock` = '$addedstock', `remaining_stock` = '$addedstock' WHERE `product_id`  = '$editID' ";
    mysqli_query($link, $sql) or die(mysqli_error());

    $sql1 = "INSERT INTO `pos`.`product_stock_inventory`(`stock_inventory_id`,`product_id`,`product_name`,`prior_stock`,`added_stock`,`new_stock`,`date_updated`) VALUES('','$editID','$nameupdate','$stockupdate','$newstock','$addedstock','$date')";
    mysqli_query($link, $sql1) or die(mysqli_error());

    $message = "Stock successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('edit_product.php?id=".$editID."')</script>";

    }
else if(isset($_POST['submit-description'])){

    $description = $_POST['description'];

    $editID = $_GET['id'];
    $sql = "UPDATE product SET `product_description` = '$description' WHERE `product_id`  = '$editID' ";
    mysqli_query($link, $sql) or die(mysqli_error());
    $message = "Description successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('edit_product.php?id=".$editID."')</script>";
    }

else if(isset($_POST['submit-media'])){

    $newNamePrefix = time() . '_';
    $target_dir = "upl/";
    $target_file = $target_dir .$newNamePrefix. basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if file already exists
    if (file_exists($target_file)) {   
      echo "string";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
        $message = "Wrong image!!";
            echo "<script type='text/javascript'>alert('$message'); window.location.assign('admin-edit-staff.php?id=".$editID."')</script>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $target_file = $_POST['media'];
      $saveData = 'true';
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $saveData = 'true';
        } else {
            $message = "There was a problem uploading the image!";
            echo "<script type='text/javascript'>alert('$message'); window.location.assign('admin-edit-staff.php?id=".$editID."')</script>";
        }
    }

    if($saveData == 'true'){
        $editID = $_GET['id'];
        $sql = "UPDATE product SET `product_media` = '$target_file' WHERE `product_id`  = '$editID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
        $message = "Product picture successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('edit_product.php?id=".$editID."')</script>";
    }
}

?>
<html lang="en">
<?php include 'session_destroyer.php'?>
<?php include 'links.php'?>
<?php include 'session_select.php'?>
<body>
    <?php
        if($access=='admin'){
    ?> 
        <div class="navigation">
            <center>
                <img src="img/logo.png">
             </center>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="product.php">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li>
                    <a href="#pagepeople" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-chart-bar"></i> <span>Sales Report</span><b class="caret" style="margin-left: 5%;"></b></a>
                    <ul class="collapse list-unstyled" id="pagepeople">
                        <li class="sales-report-list">
                            <a href="sales_report.php">View all Sales</a>
                        </li>
                        <li class="sales-report-list">
                            <a href="cashier_daily_sales.php">Cashier Daily Sales</a>
                        </li>
                        <li class="sales-report-list">
                            <a href="view_invoices.php">Invoices</a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <li>
                    <a href="employee.php">
                        <i class="fa fa-users"></i>
                        <span>Employee</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php
        }else if($access=='employee'){
    ?>
        <div class="navigation">
            <center>
                <img src="img/logo.png">
             </center>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="POS.php">
                        <i class="fa fa-th"></i>
                        <span>POS</span>
                    </a>
                </li>
                <li class="active">
                    <a href="product.php">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Product</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php } ?>

    <?php include 'header.php' ?>
    <?php
        if($access=='admin'){
    ?> 

        <div class="scroll-content">

            <span style="font-size: 22px;"><i class='fas fa-cog'></i> Manage Product Inforamtion</span>
            <a href="product.php"><button class="btn btn-primary" style="float: right;"><i class="fas fa-arrow-left"></i> View product table</button></a>
            <hr>

            <div class="sign-up-content-media">
                <span style="font-size: 18px;"><i class="fas fa-image"></i> Product Picture:</span>
                <hr>
                    <center>
                    <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="media" value="<?php echo $productmediaupdate; ?>" id="media">
                    <img class="img-responsive" id="imageSamp" style="height:225px; width:225px;" src="img/upload.png">
                    <img class="img-responsive" id="image" style="height:225px; width:225px;; display: none;">
                        <label for="fileToUpload" data-toggle="collapse" data-target="#picture" aria-expanded="false" aria-controls="picture">              
                            <div class="fileToUpdate">
                            <input type="file" class="hidden" name="fileToUpload" id="fileToUpload"><i class="fas fa-camera-retro"></i> Update Product Picture
                            </div>
                        </label>
                        <hr>
                        <button type="submit" class="update" name="submit-media"><i class="far fa-save"></i> Save Changes</button>
                    </form>
                    </center>
            </div>

            <div class="sign-up-content"> 
                <span style="font-size: 18px;"><i class="fas fa-info-circle"></i> Product Information:</span>
                <hr>
                    <strong>Product Name:</strong> <br/><br/>
                    <?= $nameupdate; ?>
                    <a href='#' data-modal-id='modal-name' class='launch-modal'><button class="btn btn-primary" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button></a>


                    <div class="modal fade" id="modal-name" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-edit"></i> Edit Name</h3>
                                </div>
                                <div class="modal-body">
                                    <label>Name:</label>
                                    <form method="post" enctype="multipart/form-data">
                                    <input type="text" class="edit-staff" id="name" name="product-name" placeholder="Name" minlength="5" value="<?= $nameupdate; ?>" required autofocus>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-name">Save Changes</button>
                                    </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    <br/><br/>
                    <hr>
                    <strong>Price:</strong> <br/><br/>
                    ₱ <?= $priceupdate; ?>
                    <a href='#' data-modal-id='modal-price' class='launch-modal'><button class="btn btn-primary" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button></a>


                    <div class="modal fade" id="modal-price" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-edit"></i> Change Price</h3>
                                </div>
                                <div class="modal-body">
                                    <label>Prior Price: ₱ <?=$priceupdate;?></label>
                                    <hr>
                                    <label>Input new price:</label>
                                    <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="edit-product" name="productname" placeholder="Name" value="<?= $nameupdate; ?>">
                                    <input type="hidden" class="edit-product" name="priorprice" value="<?= $priceupdate; ?>">
                                    <input type="number" step="any" class="edit-product" name="price" placeholder="Price" required autofocus>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-price">Save Changes</button>
                                    </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    <br/><br/>
                    <hr>
                    <strong>Stock:</strong> <br/><br/>
                    <?php
                        if($stockupdate=="0"){
                            echo"<span style='color: #d9534f;'><strong>Out of Stock</strong></span>";
                        }else{
                             echo"".$stockupdate."";     
                        }
                    ?>
                    <a href='#' data-modal-id='modal-stock' class='launch-modal'><button class="btn btn-primary" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button></a>


                    <div class="modal fade" id="modal-stock" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-edit"></i> Edit Stock</h3>
                                </div>
                                <div class="modal-body">
                                    <label>Prior Stock: 
                                        <?php
                                            if($stockupdate=="0"){
                                            echo"<span style='color: #d9534f;'><strong>Out of Stock</strong></span>";
                                            }else{
                                            echo"".$stockupdate."";     
                                            }
                                        ?></label>
                                    <hr>
                                    <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="edit-product" name="priorstock" value="<?= $stockupdate; ?>">
                                    <label>Input newly added stock:</label>
                                    <input type="number" class="edit-product" name="newstock" placeholder="Stock" required autofocus>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-stock">Save Changes</button>
                                    </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    <br/><br/>
                    <hr>
                    <strong>Description:</strong> <br/><br/>
                    <?php echo $descriptionupdate; ?>
                    <a href='#' data-modal-id='modal-description' class='launch-modal'><button class="btn btn-primary" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button></a>


                    <div class="modal fade" id="modal-description" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-edit"></i> Edit Description</h3>
                                </div>
                                <div class="modal-body">
                                    <label>Description:</label>
                                    <form method="post" enctype="multipart/form-data">
                                    <textarea class="modal-textarea" name="description" required="required"><?= $descriptionupdate; ?></textarea>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-description">Save Changes</button>
                                    </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    
        </div>
    <?php
        }else if($access=='employee'){
    ?>
        <div class="scroll-content">

            <span style="font-size: 22px;"><i class='fas fa-cog'></i> Manage Product Inforamtion</span>
            <hr>

            <div class="sign-up-content-media">
                <span style="font-size: 18px;"><i class="fas fa-image"></i> Product Picture:</span>
                <center>
                <hr>
                
                    <input type="hidden" name="media" value="<?php echo $productmediaupdate; ?>" id="media">
                    <img class="img-responsive" id="imageSamp" style="height:225px; width:225px;" src="img/upload.png">
                    <img class="img-responsive" id="image" style="height:225px; width:225px;; display: none;">
                    
                <hr>
                <span>Only admin can update photo</span>
                </center>
            </div>

            <div class="sign-up-content"> 
                <span style="font-size: 18px;"><i class="fas fa-info-circle"></i> Product Information:</span>
                <hr>
                    <strong>Product Name:</strong> <br/><br/>
                    <?= $nameupdate; ?>
                    <button class="btn btn-danger" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button>
                    <br/><br/>
                    <hr>
                    <strong>Price:</strong> <br/><br/>
                    ₱ <?= $priceupdate; ?>
                    <button class="btn btn-danger" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button>
                    <br/><br/>
                    <hr>
                    <strong>Stock:</strong> <br/><br/>
                    <?php
                        if($stockupdate=="0"){
                            echo"<span style='color: #d9534f;'><strong>Out of Stock</strong></span>";
                        }else{
                             echo"".$stockupdate."";     
                        }
                    ?>
                    <a href='#' data-modal-id='modal-stock' class='launch-modal'><button class="btn btn-primary" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button></a>


                    <div class="modal fade" id="modal-stock" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-edit"></i> Edit Stock</h3>
                                </div>
                                <div class="modal-body">
                                    <label>Prior Stock: 
                                        <?php
                                            if($stockupdate=="0"){
                                            echo"<span style='color: #d9534f;'><strong>Out of Stock</strong></span>";
                                            }else{
                                            echo"".$stockupdate."";     
                                            }
                                        ?></label>
                                    <hr>
                                    <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="edit-product" name="priorstock" value="<?= $stockupdate; ?>">
                                    <label>Input newly added stock:</label>
                                    <input type="number" class="edit-product" name="newstock" placeholder="Stock" required autofocus>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-stock">Save Changes</button>
                                    </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>
                    <br/><br/>
                    <hr>
                    <strong>Description:</strong> <br/><br/>
                    <?php echo $descriptionupdate; ?>
                    <button class="btn btn-danger" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button>
                    
        </div>
    <?php } ?>
        <?php include 'footer_links.php' ?>
    </body>
</html>