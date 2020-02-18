<!DOCTYPE html>
<?php include'config.php'?>
<?php
$manageID = $_GET['id'];
$res1 = "SELECT * FROM employee WHERE `employee_id` = '$manageID'";
$result1 = mysqli_query($link, $res1) or die(mysql_error());
      for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
              $employeeid=$num_rows["employee_id"];
              $employeename=$num_rows["employee_name"];
              $employeeusername=$num_rows["employee_username"];
              $employeeaccess=$num_rows["employee_access"];
              $employeestatus=$num_rows["status"];
              $employeemedia=$num_rows["employee_media"];
            }
?>
<?php
if(isset($_POST['submit-name'])){

    $name = $_POST['employeename'];

    $manageID = $_GET['id'];
        $sql = "UPDATE employee SET `employee_name` = '$name' WHERE `employee_id`  = '$manageID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
        $message = "Name successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('manage_profile.php?id=".$manageID."')</script>";
    }


else if(isset($_POST['submit-username'])){

    $username = $_POST['username'];

    $manageID = $_GET['id'];
        $sql = "UPDATE employee SET `employee_username` = '$username' WHERE `employee_id`  = '$manageID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
        $message = "Username successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('manage_profile.php?id=".$manageID."')</script>";
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
            echo "<script type='text/javascript'>alert('$message'); window.location.assign('manage-profile.php?id=".$manageID."')</script>";
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
            echo "<script type='text/javascript'>alert('$message'); window.location.assign('manage-profile.php?id=".$manageID."')</script>";
        }
    }

    if($saveData == 'true'){
        $manageID = $_GET['id'];
        $sql = "UPDATE employee SET `employee_media` = '$target_file' WHERE `employee_id`  = '$manageID' ";
        mysqli_query($link, $sql) or die(mysqli_error());
        $message = "Profile picture successfully updated!";
        echo "<script type='text/javascript'>alert('$message'); window.location.assign('manage_profile.php?id=".$manageID."')</script>";
    }
}
else if(isset($_POST['submit-password'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = strip_tags(mysqli_real_escape_string($link,trim($username)));
        $password = strip_tags(mysqli_real_escape_string($link,trim($password)));

        $sql = "SELECT * FROM `employee` where `employee_username` = '".$username."'";
        $result = mysqli_query($link,$sql) or die (mysqli_error());
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_array($result)){
                $password_hash = $row['employee_password'];
                if(password_verify($password,$password_hash)){
                    $script =  "<script> $(document).ready(function(){ $('#login-success').modal('show'); }); </script>";
                    }
                else{
                    $message = "Invalid password!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                    $script =  "<script> $(document).ready(function(){ $('#modal-password').modal('show'); }); </script>";


                }
            }
        }
    }
else if(isset($_POST['submit-new-password'])){

    $newpassword = $_POST['new-password'];
    $confirmpassword = $_POST['confirm-password'];

        if($newpassword != $confirmpassword){
                $message = "Password did not match!";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                $script =  "<script> $(document).ready(function(){ $('#login-success').modal('show'); }); </script>";
        }
        else{


        $manageID = $_GET['id'];
        $hash = password_hash($confirmpassword, PASSWORD_BCRYPT);
        $sql = "UPDATE employee SET `employee_password` = '$hash' WHERE `employee_id`  = '$manageID' ";
        mysqli_query($link, $sql) or die(mysqli_error());

        $message = "Password successfully updated!";
            echo "<script type='text/javascript'>alert('$message'); window.location.assign('manage_profile.php?id=".$manageID."')</script>";
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
                            <a href="sales_report.php">View all Sales Reports</a>
                        </li>
                        <li class="sales-report-list">
                            <a href="cashier_daily_sales.php">Cashier Daily Sales</a>
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
                <li>
                    <a href="product.php">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Product</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php } ?>
        
        <nav class="navbar navbar-inverse">
        <div class="container-fluid">
         <ul class="nav navbar-nav navbar-right">
          <li><img src="<?php echo $media; ?>"></li>
          <li class="active"><a href='manage_profile.php?id=<?php echo $_SESSION['id'];?>'><strong><?php echo $username; ?></strong></a></li>
          <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
           <ul class="dropdown-menu"></ul>
          </li>
          <li><a href='#' data-modal-id='modal-logout' class='launch-modal'><i class="fas fa-power-off"></i></a></li>
         </ul>
        </div>
       </nav>
        <div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                       
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button> 
                        <h3 class="modal-title" id="modal-login-label"> <i class="fas fa-sign-out-alt"></i> Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <label>Are you sure you want to logout?</label>
                    </div>
                      
                    <div class="modal-footer">
                            <button class="btn btn-primary" data-dismiss="modal">No</button>
                            <a href="logout.php"><button type="submit"class="btn btn-danger">Yes</button></a>    
                    </div>
                      
                </div>
            </div>
        </div>

        <div class="scroll-content">

            <span style="font-size: 22px;"><i class="fas fa-user-cog"></i> Manage Profile Inforamtion</span>
            <hr>

            <div class="sign-up-content-media">
                <span style="font-size: 18px;"><i class="fas fa-image"></i> Profile Picture:</span>
                <hr>
                <form method="post" enctype="multipart/form-data">
                    <center>
                    <input type="hidden" name="media" value="<?= $employeemedia; ?>" id="media"> 
                    <img class="img-responsive" id="imageSamp" style="height:225px; width:225px;" src="img/upload.png">
                    <img class="img-responsive" id="image" style="height:225px; width:225px;; display: none;">
                        <label for="fileToUpload" data-toggle="collapse" data-target="#picture" aria-expanded="false" aria-controls="picture">              
                            <div class="fileToUpdate">
                            <input type="file" class="hidden" name="fileToUpload" id="fileToUpload"><i class="fas fa-camera-retro"></i> Update Profile Picture
                            </div>
                        </label>
                        <hr>
                        <button type="submit" class="update" name="submit-media"><i class="far fa-save"></i> Save Changes</button>
                    </center>
                </form>
            </div>

            <div class="sign-up-content">
                <span style="font-size: 18px;"><i class="fas fa-info-circle"></i> Profile Information:</span>
                <hr>
                    Name: <br/><br/>
                    <?= $employeename; ?>
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
                                    <input type="text" class="edit-staff" id="name" name="employeename" placeholder="Name" minlength="5" value="<?= $employeename; ?>" required autofocus>
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
                    Username: <br/><br/>
                    <?= $employeeusername; ?>
                    <a href='#' data-modal-id='modal-username' class='launch-modal'><button class="btn btn-primary" style="float: right;" type="button"><i class="fas fa-pen-square"></i> Edit
                    </button></a>


                    <div class="modal fade" id="modal-username" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-edit"></i> Edit Username</h3>
                                </div>
                                <div class="modal-body">
                                    <label>Username:</label>
                                    <form method="post" enctype="multipart/form-data">
                                    <input type="text" class="edit-staff" id="username" name="username" placeholder="Username" minlength="5" value="<?= $employeeusername; ?>" required autofocus>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-username">Save Changes</button>
                                    </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>              
                    <br/><br/>
                    <hr>
                    <br/>
                    Password:
                    <a href='#' data-modal-id='modal-password' class='launch-modal'><button class="btn btn-success" style="float: right;" type="button"><i class="fas fa-key ic"></i> Change Password
                    </button></a>


                    <div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-key ic"></i> Enter Password</h3>
                                </div>
                                <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <label>Password:</label>
                                    <input type="hidden" name="username" value="<?php echo $employeeusername; ?>">
                                    <input type="password" class="edit-staff" id="password" name="password" placeholder="••••••••" style="font-size: 18px;" required autofocus>
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-password">Submit</button>
                                </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>                   
                    <div class="modal fade" id="login-success" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h3 class="modal-title" id="modal-login-label"> <i class="fas fa-key ic"></i> Change Password!</h3>
                                    
                                </div>
                                  
                                <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <label>Enter New Password:</label>
                                        <input type="password" class="edit-staff" id="new-password" name="new-password" placeholder="••••••••" style="font-size: 18px;" required autofocus>
                                    <br/><br/>
                                    <label>Confirm New Password:</label>
                                        <input type="password" class="edit-staff" id="confirm-password" name="confirm-password" placeholder="••••••••" style="font-size: 18px;" required autofocus>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-new-password">Submit</button>
                                </form>
                                </div>
                                  
                            </div>
                        </div>
                    </div>
        </div>
        <?php include 'footer_links.php' ?>
	</body>
</html>