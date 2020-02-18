
<?php 
	 include 'config.php';
	 
        $name = $_GET["name"];

        $res = "SELECT * FROM product_stock_inventory WHERE `product_name` = '$name'";
        $result = mysqli_query($link, $res) or die(mysql_error());

       $data = [];

      for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
      		$item = new stdClass();
                        $item->prior_stock=$num_rows["prior_stock"];
                        $item->added_stock=$num_rows["added_stock"];
                        $item->new_stock=$num_rows["new_stock"];
                        $item->id=$num_rows["stock_inventory_id"];
                        $item->date_updated=$num_rows["date_updated"];
                     array_push($data, $item);        
                }
	$r = $data;
	header('Content-Type: application/json');
	echo json_encode($r);

 ?>