
<?php 
	 include 'config.php';
	 
        $name = $_GET["name"];

	     $res = "SELECT * FROM product_price_updates WHERE `product_name` = '$name'";
        $result = mysqli_query($link, $res) or die(mysql_error());

       $data = [];

      for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
      		$item = new stdClass();
                        $item->prior_price=$num_rows["prior_price"];
                        $item->id=$num_rows["price_inventory_id"];
                        $item->new_price=$num_rows["new_price"];
                        $item->date_updated=$num_rows["date_updated"];
                     array_push($data, $item);        
                }
	$r = $data;
	header('Content-Type: application/json');
	echo json_encode($r);
 ?>