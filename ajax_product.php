
<?php 
	 include 'config.php';
	 
	 $res = "SELECT * FROM product";
                $result = mysqli_query($link, $res) or die(mysql_error());
       $data = [];

      for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
      		$item = new stdClass();
                        $item->productid=$num_rows["product_id"];
                        $item->name=$num_rows["product_name"];
                        $item->price=$num_rows["product_price"];
                        $item->stock=$num_rows["total_stock"];
                        $item->remainingstock=$num_rows["remaining_stock"];
                        $item->barcode=$num_rows["barcode_no"];
                        $item->description=$num_rows["product_description"];
                        $item->productmedia=$num_rows["product_media"];
                      
                     array_push($data, $item);        
                                  
                }
	$r = $data;
	header('Content-Type: application/json');
	echo json_encode($r);
 ?>