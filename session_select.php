<?php include'config.php'?>
<?php
$ID = $_SESSION['id'];
$res1 = "SELECT * FROM employee WHERE `employee_id` = '$ID'";
$result1 = mysqli_query($link, $res1) or die(mysql_error());
    for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
        $logid=$num_rows["employee_id"];
        $cashier=$num_rows["employee_name"];
        $username=$num_rows["employee_username"];
        $access=$num_rows["employee_access"];
        $media=$num_rows["employee_media"];
        
    }
?>