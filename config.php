<?php
	$link = mysqli_connect("localhost","root","","pos");
	if(mysqli_connect_errno()){
		echo "Failed to connect:".mysqli_connect_errno();
	}
?>