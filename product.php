<!DOCTYPE html>
<html lang="en">
<?php include 'config.php'?>
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
                    <a href="pos.php">
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
    <div class="scroll-content">
        <span style="font-size: 22px;"><i class="fa fa-shopping-bag"></i> Products</span>
        <?php if($access=='admin'){ ?>
        <a href='#' data-modal-id='modal-add-product' class='launch-modal'><button class="btn btn-primary" style="float: right;"><i class="fas fa-plus"></i> Add Product</button></a>
        <?php }else if($access=='employee'){ ?>
        
        <?php } ?>
                    <div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">                        
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-exclamation-circle x"></i> Validation</h3>
                                </div>
                                <div class="modal-body">
                                    <h4>Please contact the admin!</h4>
                                </div>
                                                          
                                <div class="modal-footer">
                                    <button class="btn btn-primary" data-dismiss="modal">Ok</button> 
                                </div>
                                                          
                            </div>
                        </div>
                    </div>
        <hr>
        <table id="dtTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
            <thead>  
                <tr> 
                    <th style="text-align: center;">Photo</th>
                    <th>Product Name</th>    
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Barcode #</th>
                    <th>Description</th> 
                    <th style="text-align: center;">Action</th>  
                </tr>  
            </thead>
                <?php
                $res = "SELECT * FROM product order by remaining_stock > 0";
                $result = mysqli_query($link, $res) or die(mysql_error());

                    for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                        $productid=$num_rows["product_id"];
                        $name=$num_rows["product_name"];
                        $price=$num_rows["product_price"];
                        $stock=$num_rows["total_stock"];
                        $remainingstock=$num_rows["remaining_stock"];
                        $barcode=$num_rows["barcode_no"];
                        $description=$num_rows["product_description"];
                        $productmedia=$num_rows["product_media"];
                                
                                  
                ?>

                <tr>
                    <td><center><img style='height:25px; width:25px; border-radius: 100%;' src="<?=$productmedia;?>"></center></td>
                    <td><input type='hidden' value='<?php echo $productid;?>'><?=$name;?></td>
                    <td>₱ <?=$price;?></td>
                    <td><?php
                        if($remainingstock=="0"){
                            echo"<span style='color: #d9534f;'><strong>Out of Stock</strong></span>";
                        }else{
                            echo"".$remainingstock." out of ".$stock."";     
                        }
                        ?>
                    </td> 
                    <td><?=$barcode;?></td>
                    <td><?=$description;?></td>               
                    <td>
                        <center>
                            <?php if($access=='admin'){ ?>
                            <a href='product_inventories.php?id=<?php echo $productid;?>' ><button class='unblock'><i class='fas fa-clipboard-list'></i></button></a>
                            <a href='edit_product.php?id=<?php echo $productid;?>' ><button class='manage'><i class='fas fa-cog'></i></button></a>
                            <?php }else if($access=='employee'){ ?>
                            <a href='product_inventories.php?id=<?php echo $productid;?>' ><button class='unblock'><i class='fas fa-clipboard-list'></i></button></a>
                            <?php } ?>
                         </center>
                    </td>
                </tr>
                                
                <?php } ?>
                
                        
            </table>
    </div>
    <div class="modal fade" id="modal-add-product" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                       
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button> 
                        <h3 class="modal-title" id="modal-login-label"> <i class="fa fa-shopping-bag"></i> Add Product</h3>
                    </div>
                    <div class="modal-body">
                        <span><i class="fas fa-info-circle"></i> Fill up:</span>
                        <hr>
                        <div class="media-content">
                        <form method="POST" enctype="multipart/form-data" class="form-horizontal">
                          <span><i class="fas fa-image"></i> Upload Product Photo:</span>
                          <hr>
                            <center>
                                <img class="img-responsive" id="imageSamp" style="height:100px; width:100px; margin-bottom: 5%;" src="img/upload-product.png">
                                <img class="img-responsive" id="image" style="height:100px; width:100px; margin-bottom: 5%; display: none;">
                                <label for="fileToUpload">
                                    <div class="fileToUpload">
                                        <input type="file" class="hidden" name="fileToUpload" id="fileToUpload"><i class="fas fa-camera-retro"></i> Photo 
                                    </div>
                                </label>
                            </center>
                        </div>
                            <center>
                                <input type="text" name="product-name" placeholder="Product Name" required autofocus><br/><br/>
                                <input type="number" step="any" name="price" placeholder="Price"required><br/><br/>
                                <input type="number"  name="stock" placeholder="Stock" required><br/><br/>
                                <input type="number"  name="barcode" placeholder="Barcode" required><br/><br/>
                            </center>
                        <br/><br/>
                        <textarea name="description" placeholder="Description" id="description" value="" required="required"></textarea>
                    </div>
                      
                    <div class="modal-footer">
                            <button class="btn btn-primary" name="submit-product">Submit</button>
                        </form>    
                    </div>
                      
                </div>
            </div>
        </div>
<?php
if(isset($_POST['submit-product'])){

    $productname = strip_tags($_POST['product-name']);
    $price = strip_tags($_POST['price']);
    $stock = strip_tags($_POST['stock']);
    $barcode = strip_tags($_POST['barcode']);
    $description = strip_tags($_POST['description']);
    $uploadfile = "img/upload-product.png";

    if($_FILES["fileToUpload"]["name"] == null){
    $sql = "INSERT INTO `pos`.`product`(`product_id`,`product_name`,`product_description`,`product_price`,`total_stock`,`remaining_stock`,`barcode_no`,`product_media`,`notif_status`) VALUES('','$productname','$description','$price','$stock','$stock','$barcode','$uploadfile','1')";
    mysqli_query($link, $sql) or die(mysqli_error());

      $message = "Product successfully added!";
      echo "<script type='text/javascript'>alert('$message'); window.location.assign('product.php')</script>";
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
            $message = "There was a problem uploading the image!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            $uploadOk = 0;
        }
    // Check if file already exists
    if (file_exists($target_file)) {   
        $uploadOk = 0;
        $message = "There was a problem uploading the image!";
            echo "<script type='text/javascript'>alert('$message');</script>";
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
        $message = "There was a problem uploading the image!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    // if everything is ok, try to upload file
      $message = "There was an error uploading the image!";
      echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $saveData = 'true';
        } else {
            $message = "There was a problem uploading the image!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
    if($saveData == 'true'){
   $sql = "INSERT INTO `pos`.`product`(`product_id`,`product_name`,`product_description`,`product_price`,`total_stock`,`remaining_stock`,`barcode_no`,`product_media`,`notif_status`) VALUES('','$productname','$description','$price','$stock','$stock','$barcode','$target_file','1')";
        mysqli_query($link, $sql) or die(mysqli_error());
        $message = "Product succesfully added!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('product.php')</script>";
    }
    }
}
?>
    <?php include 'footer_links.php' ?>
	</body>
</html>