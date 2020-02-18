<?php
//fetch.php;
include("config.php");
if(isset($_POST["view"]))
{
  if($_POST["view"] != '')
 {
  $update_query = "UPDATE product SET notif_status=1 WHERE notif_status=0";
  mysqli_query($link, $update_query);
 }
 $query = "SELECT * FROM product where remaining_stock <= 3 ORDER BY product_id Limit 8";
 $result = mysqli_query($link, $query);
 $output = '';
 
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   <li>
    <a href="edit_product.php?id='.$row["product_id"].'">
     <strong>'.$row["product_name"].'</strong><br />
     <small><em>Remaining stock '.$row["remaining_stock"].'</em></small>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }
 
 $query_1 = "SELECT * FROM product WHERE notif_status = 0";
 $result_1 = mysqli_query($link, $query_1);
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>