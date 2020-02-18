
<?php 
	 include 'config.php';
	 
	 $res = "SELECT * FROM product";
                $result = mysqli_query($link, $res) or die(mysql_error());
       $data = [];

       $res = "SELECT * FROM sales where quantity != 0 ORDER BY sales_id desc";
                            $result = mysqli_query($link, $res) or die(mysql_error());

                                for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
          $item = new stdClass();

                                        $item->productname=$num_rows["purchase_name"];
                                        $item->description=$num_rows["product_description"];
                                        $item->numberorder=$num_rows["quantity"];
                                        $item->amount=$num_rows["total_amount"];
                                        $item->cashier=$num_rows["cashier"];
                                        $item->transactiondate=$num_rows["transaction_time"];
                      
                     array_push($data, $item);        
                                  
                }

  $r = new stdClass();
	$r->items = $data;

  $date = date('y-m-d');
                $query = "SELECT SUM(total_amount) as result FROM sales";
                $result = mysqli_query($link, $query) or die(mysql_error());
                $row = mysqli_fetch_array($result);
  $r->total = $row['result'] == null ? 0:$row['result'];
	header('Content-Type: application/json');
	echo json_encode($r);
 ?>