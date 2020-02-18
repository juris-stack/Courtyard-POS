<!DOCTYPE html>
<?php include 'config.php';?>
<?php
	if(isset($_POST['submit'])){

		session_start();
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
					
					if( $row['employee_access'] == 'employee' and $row['status'] == 'active' and $row['logs'] == 'logout' ) {
						$sql = "UPDATE employee SET `logs` = 'login' WHERE `employee_username`  = '$username' ";
                		mysqli_query($link, $sql) or die(mysqli_error());

						header("Location:dashboard.php");
						$_SESSION['id']=$row['employee_id'];
					}
					else if( $row['employee_access'] == 'employee' and $row['status'] == 'block' ) {
						$error_msg = "<div class='login-modal'>Your acces is blocked!</div>";      
						$script =  "<script> $(document).ready(function(){ $('#login-error').modal('show'); }); </script>";

					}
					else if( $row['employee_access'] == 'employee' and $row['logs'] == 'login') {
						$error_msg = "<div class='login-modal'>You are already log in!</div>";      
						$script =  "<script> $(document).ready(function(){ $('#login-error-force').modal('show'); }); </script>";

					}
					else if( $row['employee_access'] == 'admin' and $row['status'] == 'active' and $row['logs'] == 'logout' ) {
						$sql = "UPDATE employee SET `logs` = 'login' WHERE `employee_username`  = '$username' ";
                		mysqli_query($link, $sql) or die(mysqli_error());

						header("Location:dashboard.php");
						$_SESSION['id']=$row['employee_id'];
					}
					else if( $row['employee_access'] == 'admin' and $row['status'] == 'block' ) {
						$error_msg = "<div class='login-modal'>Your acces is blocked!</div>";      
						$script =  "<script> $(document).ready(function(){ $('#login-error').modal('show'); }); </script>";

					}
					else if( $row['employee_access'] == 'admin' and $row['logs'] == 'login') {
						$error_msg = "<div class='login-modal'>You are already log in!</div>";      
						$script =  "<script> $(document).ready(function(){ $('#login-error-force').modal('show'); }); </script>";

					}
				}
				else{
						$error_msg = "<div class='login-modal'>Invalid Password!</div>";      
						$script =  "<script> $(document).ready(function(){ $('#login-error').modal('show'); }); </script>";
					}

			}
			
		}
		else{
			$error_msg = "<div class='login-modal'>Invalid Login Credintials.</div>";      
			$script =  "<script> $(document).ready(function(){ $('#login-error').modal('show'); }); </script>";
		}
	}

if(isset($_POST['submit-password'])){

		$name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $name = strip_tags(mysqli_real_escape_string($link,trim($name)));
        $username = strip_tags(mysqli_real_escape_string($link,trim($username)));
        $password = strip_tags(mysqli_real_escape_string($link,trim($password)));

        $sql = "SELECT * FROM `employee` where `employee_username` = '".$username."' and `employee_name` = '".$name."'";
        $result = mysqli_query($link,$sql) or die (mysqli_error());
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_array($result)){
                $password_hash = $row['employee_password'];
                if(password_verify($password,$password_hash)){
                    $updateLogs = "UPDATE employee SET `logs` = 'logout' WHERE `employee_name`  = '$name' ";
        			mysqli_query($link, $updateLogs) or die(mysqli_error());
        			$error_msg = "<div class='login-modal'>You can now Login. Input your access again.</div>";      
					$script =  "<script> $(document).ready(function(){ $('#login-force').modal('show'); }); </script>";

                }
            }
        }else{
			$error_msg = "<div class='login-modal'>Invalid Login Credintials.</div>";      
			$script =  "<script> $(document).ready(function(){ $('#login-error').modal('show'); }); </script>";
		}
    }

?>
<html lang="en">
    <head>
      <title>POS</title>
      <meta charset="utf-8"/>  
      <meta name="viewport" content="width=device=width, initial-scale=1.0"> 
      <link rel="stylesheet" href="index-main-style.css" type="text/css"/>
      <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css">
      <link href="asset/css/style.css" rel="stylesheet">
      <link rel="stylesheet" href="web-fonts-with-css/css/fontawesome-all.min.css"/>
      <script type="text/javascript" src="asset/js/jquery.js"></script>
    </head>
	<body class="index-background">
		<div class="login-page">
				<div class="form-wrapper">
					<div class="login-page-content">
						<center>
							<img src="img/logo.png">
						</center>
							<form method="post" enctype="multipart/form-data">
								<center>
										<div class="login-form-wrapper">
											<div class="login-form">
												 <div class="input-group">
										          <span class="input-group-addon"><i class="fas fa-user ic"></i></span>
										          <input type="text" name="username" class="form-control" placeholder="Username" autofocus required>
										        </div><br/>
										        <div class="input-group">
										          <span class="input-group-addon"><i class="fas fa-key ic"></i></span>
										          <input type="password" name="password" class="form-control" placeholder="Password" required>
										        </div>

												<input type="submit" class="btn" name="submit" value="Login">
											</div>
										</div>
								</center>
							</form>
					</div>
				</div>
		</div>

		<div class="modal fade" id="login-error" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                       
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h3 class="modal-title" id="modal-login-label"> <i class="fas fa-exclamation-triangle"></i> Error!</h3>
                        
                    </div>
                      
                      <div class="modal-body">
                      	<h5><?php if(isset($error_msg)){ echo $error_msg; } ?></h5> 
                      </div>
                      <div class="modal-footer">
                      	<button class="btn btn-primary" data-dismiss="modal">Ok</button>
                      </div>
                      
                </div>
            </div>
        </div>
        <div class="modal fade" id="login-error-force" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                       
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h3 class="modal-title" id="modal-login-label"> <i class="fas fa-exclamation-triangle"></i> Error!</h3>
                        
                    </div>
                      
                      <div class="modal-body">
                      	<h5><?php if(isset($error_msg)){ echo $error_msg; } ?></h5> 
                      </div>
                      <div class="modal-footer">
                      	<a href='#' data-modal-id='modal-password' class='launch-modal' data-dismiss="modal"><button class="btn btn-danger">Force to Login?</button></a>
                      	<button class="btn btn-primary" data-dismiss="modal">Ok</button>                
                      </div>
                      
                </div>
            </div>
        </div>
        <div class="modal fade" id="login-force" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                       
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h3 class="modal-title" id="modal-login-label"> <i class="fas fa-exclamation-triangle"></i> Success</h3>
                        
                    </div>
                      
                      <div class="modal-body">
                      	<h5><?php if(isset($error_msg)){ echo $error_msg; } ?></h5> 
                      </div>
                      <div class="modal-footer">
                      	<button class="btn btn-primary" data-dismiss="modal">Ok</button>
                      </div>
                      
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-key ic"></i> Account Confirmation</h3>
                                </div>
                                <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                	<label>Name:</label>
                                    <input type="text" name="name" class="form-control">
                                    <label>Username:</label>
                                    <input type="text" name="username" class="form-control">
                                    <label>Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" style="font-size: 18px;" required autofocus>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-password">Submit</button>
                                </form>     
                                </div>
                                  
                            </div>
                        </div>
                    </div>
        <?php if(isset($script)){ echo $script; } ?>
        <script src="asset/js/jquery-1.11.1.min.js"></script>
	    <script src="asset/bootstrap/js/bootstrap.min.js"></script>
	    <script src="asset/js/jquery.backstretch.min.js"></script>
	    <script src="asset/js/scripts.js"></script>
	</body>
</html>