<?php
//fetch.php
include 'config.php';
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($link, $_POST["query"]);
 $query = "
  SELECT * FROM product 
  WHERE barcode_no LIKE '%".$search."%' or product_name LIKE '%".$search."%' or product_description LIKE '%".$search."%' LIMIT 3 ";
  $result = mysqli_query($link, $query);
  if(mysqli_num_rows($result) > 0)
  {
   $output .= ' ';
   for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
    $idproduct=$num_rows["product_id"];
    $product=$num_rows["product_name"];
    $description=$num_rows["product_description"];
    $stock=$num_rows["remaining_stock"];
    $price=$num_rows["product_price"];

    ?>
    <table class="table table bordered">
     <tr>
      <td class="product-name-td"><span style="font-size: 18px;"><?=$product;?></span><br><span style="color: #688a7e;"><?=$description;?> | ₱ <?=$price;?></span></td>
      <td>
        <?php
        if($stock == '0'){
        ?>
        <button class="btn btn-danger" data-toggle="modal" data-target="#error<?=$idproduct;?>">Out of stock</button>
        <?php
        }else{
        ?>
        <a href='submit_to_cart.php?id=<?= $idproduct;?>' ><button class="btn btn-success"><i class="fas fa-plus-circle"></i> Add</button></a>
        <?php
        }
        ?>
      </td>      
     </tr>
     </table>
     <div id="error<?=$idproduct;?>" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
                            <div class="modal-content">                        
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-exclamation-circle x"></i> Error</h3>
                                </div>
                                <div class="modal-body">
                                    <h4>Product is out of stock!</h4>
                                </div>
                                                          
                                <div class="modal-footer">
                                    <button class="btn btn-primary" data-dismiss="modal">Ok</button> 
                                </div>
                                                          
                            </div>
                        </div>
                    </div>
   
   <?php
 }
  }
  else
  {
   echo 'Product not found';
  }
}
?>

