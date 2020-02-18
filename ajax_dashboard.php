
<?php 
	 include 'config.php';
	 
          $item = new stdClass();

                    $query = "SELECT count(product_id) as result FROM product ";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                    $item->totalProducts = $row['result'];


                    $query = "SELECT count(sales_id) as result FROM sales where DATE(transaction_time) = CURDATE()";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);

                    $item->dailySales = $row['result'];

                    $query = "SELECT Sum(total_amount) as result FROM transactions";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                    $item->totalSales = $row['result'];

                    $query = "SELECT SUM(total_amount) as result FROM transactions where DATE(transaction_date) = CURDATE() - INTERVAL 1 DAY";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);

                    $item->yesterdaySales = $row['result'] == null ? 0:$row['result'];


                    $query = "SELECT SUM(total_amount) as result FROM transactions where DATE(transaction_date) = CURDATE()";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);

                    $item->todaySales = $row['result'] == null ? 0:$row['result'];

                     $query = "SELECT SUM(total_amount) as result FROM transactions WHERE DATE(transaction_date) > CURDATE() - INTERVAL 7 DAY";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                    $item->weeklySales = $row['result'] == null ? 0:$row['result'];

                    $query = "SELECT SUM(total_amount) as result FROM transactions WHERE MONTH(transaction_date) = MONTH(CURDATE())";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                    $item->monthlySales = $row['result'] == null ? 0:$row['result'];

                    $query = "SELECT count(sales_id) as result FROM sales where DATE(transaction_time) = CURDATE()";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                    

                    $item->dailySales = $row['result'];








	$r = $item;
	header('Content-Type: application/json');
	echo json_encode($r);
 ?>