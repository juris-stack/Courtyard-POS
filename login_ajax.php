
<?php 
	 include 'config.php';
	 
$username = $_POST['username'];
		$password = $_POST['password'];

		$username = strip_tags(mysqli_real_escape_string($link,trim($username)));
		$password = strip_tags(mysqli_real_escape_string($link,trim($password)));
		$data = ['ad' => 'aa'];
		$sql = "SELECT * FROM `employee` where `employee_username` = '".$username."'";
		$result = mysqli_query($link,$sql) or die (mysqli_error());
		if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_object($result)){
				$password_hash = $row->employee_password;
				if(password_verify($password,$password_hash)){
						 echo json_encode($row);
						 return;
					}
				}
			}

		 header("HTTP/1.1 422 Unprocessable Entity");
    	 exit;

 ?>
