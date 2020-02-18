<?php include'config.php'?>
<?php
$ID = $_SESSION['id'];
$res1 = "SELECT * FROM employee WHERE `employee_id` = '$ID'";
$result1 = mysqli_query($link, $res1) or die(mysql_error());
    for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
        $logid=$num_rows["employee_id"];
        $name=$num_rows["employee_name"];
        $username=$num_rows["employee_username"];
        $access=$num_rows["employee_access"];
        $media=$num_rows["employee_media"];
        
    }
?>
        <nav class="navbar navbar-inverse">
        <div class="container-fluid">
         <ul class="nav navbar-nav navbar-right">
          <li><img src="<?php echo $media; ?>"></li>
          <li><a href='manage_profile.php?id=<?php echo $_SESSION['id'];?>'><strong><?php echo $username; ?></strong></a></li>
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
                        <form method="post" enctype="multipart/form-data">
                            <button class="btn btn-primary" data-dismiss="modal">No</button>
                            <button type="submit" name="submit-logout" class="btn btn-danger">Yes</button>
                        </form>      
                    </div>
                      
                </div>
            </div>
        </div>

        <?php

            if(isset($_POST['submit-logout'])){
                $sql = "SELECT * FROM cart where cashier = '$name'";
                $result = mysqli_query($link, $sql) or die(mysqli_error());
                while($row = mysqli_fetch_array($result))
                { 
                  if($row["quantity"]>=1){
                    $message = "You still have purchase on your cart.";
                    echo "<script type='text/javascript'>alert('$message');window.location.assign('pos.php')</script>";
                  }
                }
                $sql = "UPDATE employee SET `logs` = 'logout' WHERE `employee_username`  = '$username' ";
                mysqli_query($link, $sql) or die(mysqli_error());
                echo "<script type='text/javascript'>window.location.assign('logout.php')</script>";


                
            }


        ?>