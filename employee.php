<!DOCTYPE html>
<?php include'config.php'?>
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
                <li>
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
                <li  class="active">
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
                    <a href="POS.php">
                        <i class="fa fa-th"></i>
                        <span>POS</span>
                    </a>
                </li>
                <li>
                    <a href="product.php">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li>
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
            <span style="font-size: 22px;"><i class="fa fa-users"></i> Employee</span>
            <a href='#' data-modal-id='modal-add-employee' class='launch-modal'><button class="btn btn-primary" style="float: right;"><i class="fas fa-user-plus"></i> Add Employee</button></a>
            <hr>

            <table id="dtTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
                        <thead>  
                            <tr> 
                                <th style="text-align: center;">Photo</th>
                                <th>Name</th>  
                                <th>Username</th>   
                                <th>Access</th>
                                <th>Status</th>
                                <th style="text-align: center;">Action</th>  
                            </tr>  
                        </thead>
                        <?php
                            $res = "SELECT * FROM employee where `employee_username` != '$username'";
                            $result = mysqli_query($link, $res) or die(mysql_error());

                                for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                                        $empid=$num_rows["employee_id"];
                                        $fname=$num_rows["employee_name"];
                                        $uname=$num_rows["employee_username"];
                                        $acslvl=$num_rows["employee_access"];
                                        $status=$num_rows["status"];
                                        $stfmedia=$num_rows["employee_media"];
                                  
                         ?>

                                <tr>
                                    <td><center><img style='height:30px; width:30px; border-radius: 100%;' src="<?php echo $stfmedia;?>"></center></td>
                                    <td><input type='hidden' value='<?=$empid;?>'><?=$fname;?></td>
                                    <td><?=$uname;?></td>
                                    <td><?=$acslvl;?></td>
                                    <td><?php
                                            if($status=="block"){
                                                echo"<span style='color: #d9534f;'><strong>".$status."</strong></span>";
                                            }else if($status=="active"){
                                                echo"<span style='color: #5cb85c;'><strong>".$status."</strong></span>";     
                                            }
                                        ?>
                                    </td>                  
                                    <td>
                                        <center>
                                            <?php
                                                if($status=='active'){
                                                ?>
                                                    <button type="button" class="block" data-toggle="modal" data-target="#block<?=$empid;?>"><i class='fas fa-ban'></i></button>
                                                <?php
                                                }else if($status=='block'){
                                                ?>
                                                    <button type="button" class="unblock" data-toggle="modal" data-target="#unblock<?=$empid;?>"><i class='fas fa-circle-notch'></i></button>
                                                <?php
                                                }
                                            ?>
                                            <a href='edit_employee.php?id=<?php echo $empid;?>' ><button class='manage'><i class="fas fa-user-cog"></i></button></a>
                                        </center>
                                            <div id="block<?=$empid;?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                           
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                            </button> 
                                                            <h3 class="modal-title" id="modal-login-label"><i class="fas fa-exclamation-circle x"></i> Validation</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>Are you sure you want to <span style="color: red;">block</span> this staff?</h4>
                                                        </div>
                                                          
                                                        <div class="modal-footer">
                                                            <form method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" value="<?=$empid;?>">
                                                            <button class="no" data-dismiss="modal">No</button>
                                                            <button type="submit" class="yes" name="submit-block">Yes</button>
                                                            </form>  
                                                        </div>
                                                          
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="unblock<?=$empid;?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                           
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                                            </button> 
                                                            <h3 class="modal-title" id="modal-login-label"><i class="fas fa-exclamation-circle x"></i> Validation</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4>Are you sure you want to <span style="color: #5cb85c;">unblock</span> this staff?</h4>
                                                        </div>
                                                          
                                                        <div class="modal-footer">
                                                            <form method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="id" value="<?=$empid;?>">
                                                            <button class="no" data-dismiss="modal">No</button>
                                                            <button type="submit" class="yes" name="submit-unblock">Yes</button>
                                                            </form>     
                                                        </div>
                                                          
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                </tr>             
                    <?php } ?>  
                        
            </table>
        </div>
        <div class="modal fade" id="modal-add-employee" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                       
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button> 
                        <h3 class="modal-title" id="modal-login-label"> <i class="fa fa-users"></i> Add Employee</h3>
                    </div>
                    <div class="modal-body">
                        <span><i class="fas fa-info-circle"></i> Fill up:</span>
                        <hr>
                        <div class="media-content">
                        <form method="POST" enctype="multipart/form-data" class="form-horizontal">
                          <span><i class="fas fa-image"></i> Upload Employee Photo:</span>
                          <hr>
                            <center>
                                <img class="img-responsive" id="imageSamp" style="height:100px; width:100px; margin-bottom: 5%;" src="img/upload.png">
                                <img class="img-responsive" id="image" style="height:100px; width:100px; margin-bottom: 5%; display: none;">
                                <label for="fileToUpload">
                                    <div class="fileToUpload">
                                        <input type="file" class="hidden" name="fileToUpload" id="fileToUpload"><i class="fas fa-camera-retro"></i> Photo 
                                    </div>
                                </label>
                            </center>
                        </div>
                            <center>
                                <input type="text" id="name" name="name" placeholder="Name" minlength="5" required autofocus><br/><br/>           
                                <input type="text" id="username" name="username" placeholder="Username" minlength="5" required autofocus><br/><br/>
                                <input type="password" id="pass" name="password" placeholder="Password" minlength="5" required><br/><br/>
                                <input type="password" id="confirm" name="confirm" placeholder="Confirm Password">
                            </center>
                            <hr>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" name="submit-employee">Submit</button>
                    </form>  
                    </div>
                      
                </div>
            </div>
        </div>
<?php
if(isset($_POST['submit-employee'])){

    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $uploadfile = "img/upload.png";
    date_default_timezone_set('Asia/Manila');
    $date = date('h:i a | Y/m/d');

    $query = "SELECT * FROM `employee` WHERE `employee_username` = '$username'";
    $result = mysqli_query($link, $query) or die(mysql_error());
    if($password != $confirm){
      $message = "Password didn't match!";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
    
    else if(mysqli_num_rows($result)>0){
        $message = "Employee already exist!";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    else if($_FILES["fileToUpload"]["name"] == null){
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO `pos`.`employee`(`employee_id`,`employee_name`,`employee_username`,`employee_password`,`employee_access`,`employee_media`,`status`,`logs`) VALUES('','$name','$username','$hash','employee','$uploadfile','active','logout')";
    mysqli_query($link, $sql) or die(mysqli_error());

      $message = "Employee successfully added!";
      echo "<script type='text/javascript'>alert('$message'); window.location.assign('employee.php')</script>";
        
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
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO `pos`.`employee`(`employee_id`,`employee_name`,`employee_username`,`employee_password`,`employee_access`,`employee_media`,`status`,`logs`) VALUES('','$name','$username','$hash','employee','$target_file','active','logout')";
        mysqli_query($link, $sql) or die(mysqli_error());
        $message = "Employee succesfully added!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('employee.php')</script>";
    }
    }
    }
else if(isset($_POST['submit-block'])){

    $id = $_POST['id'];

    $sql = "UPDATE employee SET `status` = 'block' WHERE `employee_id`  = '$id' ";
    mysqli_query($link, $sql) or die(mysqli_error());
    $message = "Staff succesfully blocked!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('employee.php')</script>";
}
else if(isset($_POST['submit-unblock'])){

    $id = $_POST['id'];

    $sql = "UPDATE employee SET `status` = 'active' WHERE `employee_id`  = '$id' ";
    mysqli_query($link, $sql) or die(mysqli_error());
    $message = "Staff succesfully unblocked!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('employee.php')</script>";
}
?>                    
        <?php include 'footer_links.php' ?>
	</body>
</html>