<!DOCTYPE html>
<html lang="en">
<?php include 'config.php'?>
<?php include 'session_destroyer.php'?>
<?php include 'links.php'?>
<?php include 'session_select.php'?>
<body>
    <?php
        if($access=='admin'){
    ?> 
        <div class="navigation">
            <center>
                <img src="img/logo.png">
             </center>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="product.php">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li>
                    <a href="#pagepeople" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-chart-bar"></i> <span>Sales Report</span><b class="caret" style="margin-left: 5%;"></b></a>
                    <ul class="collapse list-unstyled" id="pagepeople">
                        <li>
                            <a href="sales_report.php">View all Sales</a>
                        </li>
                        <li>
                            <a href="cashier_daily_sales.php">Cashier Daily Sales</a>
                        </li>
                        <li class="sales-report-list">
                            <a href="view_invoices.php">Invoices</a>
                        </li>
                        <li class="divider"></li>
                    </ul>
                </li>
                <li>
                    <a href="employee.php">
                        <i class="fa fa-users"></i>
                        <span>Employee</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php
        }else if($access=='employee'){
    ?>
        <div class="navigation">
            <center>
                <img src="img/logo.png">
             </center>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="POS.php">
                        <i class="fa fa-th"></i>
                        <span>POS</span>
                    </a>
                </li>
                <li>
                    <a href="product.php">
                        <i class="fa fa-shopping-bag"></i>
                        <span>Product</span>
                    </a>
                </li>
            </ul>
        </div>
    <?php } ?>
	<?php include 'header.php' ?>
    <div class="scroll-content">
        <span style="font-size: 22px;"><i class="fa fa-th"></i> POS</span>
            <?php
                date_default_timezone_set('Asia/Manila');
                $date = date('Y/m/d');
                $query = "SELECT SUM(total_amount) as result FROM transactions where transaction_date = '$date' and cashier = '$cashier'";
                $result = mysqli_query($link, $query) or die(mysql_error());
                $row = mysqli_fetch_array($result);

                ?>
                    <?php
                    if($row['result']==0){
                    ?>
                    <label style='float: right; margin-right: 1.5%; margin-top: 0.6%;'><span>Sales Today</span><span style='color: #5cb85c;'> : ₱ 0.00</span></label>
                    <?php
                    }else{
                    ?>
                    <label style='float: right; margin-right: 1.5%; margin-top: 0.6%;'><span>Sales Today</span><span style='color: #5cb85c;'> : ₱ <?php echo $row['result']?></span></label>
                    <?php
                    }
            ?>
        <hr>
        <div class="cart">
            <div class="cart-title">
                <span style="font-size: 18px;"><i class="fas fa-shopping-cart"></i> Purchases</span>

            </div>
            <div class="container" style="padding: 5px 0; float: left; width: 100%;">
            <table id="tableCart" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" style="background-color: white;">  
                <thead>  
                    <tr> 
                        <th style="text-align: center;">Photo</th>
                        <th>Product Name</th>
                        <th>Stock</th>  
                        <th>Qty.</th>   
                        <th>Amount</th>
                        <th style="text-align: center;">Action</th>  
                    </tr>  
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM cart where cashier = '$cashier' ";
                    $results = mysqli_query($link, $query) or die(mysql_error());

                        for($i=0; $i<$num_rows=mysqli_fetch_array($results);$i++) {
                            $cartid=$num_rows["cart_id"];
                            $productid=$num_rows["product_id"];
                            $name=$num_rows["cart_name"];
                            $price=$num_rows["product_price"];
                            $quantity=$num_rows["quantity"];
                            $totalamount=$num_rows["total_amount"];
                            $productmedia=$num_rows["product_media"];
                            $cartcashier=$num_rows["cashier"];
                            $description=$num_rows["cart_description"];  
                    ?>
                    <tr>

                        <td><center><img style='height:25px; width:25px; border-radius: 100%;' src="<?=$productmedia;?>"></center></td>
                        <td><input type='hidden' value='<?php echo $cartid;?>'><?=$name;?></td>
                        <?php
                            $query = "SELECT * FROM product where product_name = '$name' and product_description = '$description' ";
                            $result = mysqli_query($link, $query) or die(mysql_error());

                            for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                                $stock=$num_rows["remaining_stock"];

                        ?>
                        <td><?=$stock;?></td>
                        <td>
                            <?php if($stock==0){?>
                            <div class="quantity-change"><a href='minus_quantity.php?id=<?= $productid;?>' ><button class="minus-quantity">-</button></a><?=$quantity;?><a href='#' ><button class="add-quantity">+</button></a></div>
                            <?php }else if($quantity==0){?>
                            <div class="quantity-change"><a href='#' ><button class="minus-quantity">-</button></a><?=$quantity;?><a href='add_quantity.php?id=<?= $productid;?>' ><button class="add-quantity">+</button></a></div>
                            <?php }else{?>
                            <div class="quantity-change"><a href='minus_quantity.php?id=<?= $productid;?>' ><button class="minus-quantity">-</button></a><?=$quantity;?><a href='add_quantity.php?id=<?= $productid;?>' ><button class="add-quantity">+</button></a></div>
                            <?php } } ?>
                        </td>
                        <td>
                            ₱ <?=$totalamount;?>
                        </td>
                        <td><center>
                            <button type="button" class="block" data-toggle="modal" data-target="#delete<?=$cartid;?>">
                            <i class="fas fa-trash"></i></button></center></td>
                    </tr>
                    <div id="delete<?=$cartid;?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">                        
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-exclamation-circle x"></i> Validation</h3>
                                </div>
                                <div class="modal-body">
                                    <h4>Are you sure you want to <span style="color: red;">remove</span> this purchase?</h4>
                                </div>
                                                          
                                <div class="modal-footer">
                                    <form action="delete_purchase.php" method="post" >                                    
                                    <input type="hidden" name="delete-id" value="<?=$productid;?>">
                                    <input type="hidden" name="delete-name" value="<?=$name;?>">
                                    <input type="hidden" name="remaining-quantity" value="<?=$quantity;?>">
                                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger" name="submit-delete">Yes</button>
                                    </form>     
                                </div>
                                                          
                            </div>
                        </div>
                    </div>
                                    
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
        <div class="search-proccess">
            <input type="text" class="search-product" id="search" name="search" placeholder="Scan Product..." autofocus>
            <div class="display-scanned">
                <span style="font-size: 16px; color: #688a7e;"><i class="fa fa-shopping-bag"></i> Product</span>
                <table  class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
                <div id="result"></div>
            </table>
                
            </div>
            <?php
                $query = "SELECT Sum(total_amount) as result FROM cart where cashier = '$cashier'";
                $result = mysqli_query($link, $query) or die(mysql_error());
                $row = mysqli_fetch_array($result);

            ?>
            <?php
                if($row['result']==0){
            ?>
            <a href='#' data-modal-id='modal-payment-x' class='launch-modal'>
                <div class="reciept">
                    <?php
                    if($row['result']==0){
                    ?>
                    <span style='letter-spacing: 2px;'>TOTAL</span> <span style='float: right; letter-spacing: 2px;'>₱ 0.00</span>
                    <?php
                    }else{
                    ?>
                    <span style='letter-spacing: 2px;'>TOTAL</span> <span style='float: right; letter-spacing: 2px;'>₱ <?php echo $row['result']?></span>
                    <?php
                    }
                ?>
                    
                </div>
            </a>
            <?php        
                }else{
            ?>
            <a href='#' data-modal-id='modal-payment' class='launch-modal'>
                <div class="reciept">
                    <?php
                    if($row['result']==0){
                    ?>
                    <span style='letter-spacing: 2px;'>TOTAL</span> <span style='float: right; letter-spacing: 2px;'>₱ 0.00</span>
                    <?php
                    }else{
                    ?>
                    <span style='letter-spacing: 2px;'>TOTAL</span> <span style='float: right; letter-spacing: 2px;'>₱ <?php echo $row['result']?></span>
                    <?php
                    }
                ?>
                    
                </div>
            </a>
            <?php        
                }
            ?>
                <div class="modal fade" id="modal-payment-x" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">                        
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-exclamation-circle x"></i> Error</h3>
                                </div>
                                <div class="modal-body">
                                    <h4>Nothing to process!</h4>
                                </div>
                                                          
                                <div class="modal-footer">
                                    <button class="btn btn-primary" data-dismiss="modal">Ok</button> 
                                </div>
                                                          
                            </div>
                        </div>
                    </div>

                <div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                   
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                    </button> 
                                    <h3 class="modal-title" id="modal-login-label"><i class="fas fa-cash-register"></i> Payment</h3>
                                </div>
                                <div class="modal-body">
                                    <label> <?php
                                        $query = "SELECT Sum(total_amount) as result FROM cart";
                                        $result = mysqli_query($link, $query) or die(mysql_error());
                                        $row = mysqli_fetch_array($result);

                                        ?>
                                        <?php
                                        if($row['result']==0){
                                        ?>
                                        TOTAL<br/> <span style="color: red; font-size: 20px; letter-spacing: 2px;">₱ 0.00</span>
                                        <?php
                                        }else{
                                        ?>
                                        TOTAL<br/> <span style="color: red; font-size: 20px; letter-spacing: 2px;">₱ <?php echo $row['result']?></span>
                                        <?php
                                        }
                                    ?></label>
                                    <hr>
                                    <label>Payment:</label><br/>
                                    <form method="POST" enctype="multipart/form-data" class="form-horizontal">
                                    <input type="hidden" name="cashier" value="<?=$cashier;?>">
                                    <input type="hidden" class="pos-input" id="total" name="total" value="<?php echo$row['result'];?>">
                                    <input type="hidden" class="pos-input" name="product-id" value="<?=$productid2;?>">
                                    <input type="hidden" class="pos-input" name="product-name" value="<?=$name;?>">
                                    ₱ <input type="number" class="pos-input" id="payment" name="payment" placeholder="0.00" value="" required autofocus>
                                    <br/><br/>
                                    <label>Change:</label><br/>
                                    ₱ <input type="number" class="pos-input-change" id="change" name="change" placeholder="0.00">
                                    <br/><br/>
                                </div>
                                  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="submit-payment">Submit</button>
                                    </form>   
                                </div>
                                  
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit-payment'])){
            $payment = strip_tags($_POST['payment']);
            $total = strip_tags($_POST['total']);
            $change = strip_tags($_POST['change']);
            $date = date('Y/m/d');

            if($payment < $total){
                $message = "Cannot process, Payment is not enough.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }else{

            $sqlquery = "INSERT INTO `pos`.`transactions`(`transaction_id`,`total_amount`,`payment`,`change`,`cashier`,`transaction_date`) VALUES('','$total','$payment','$change','$cashier','$date')";
            $resultquery = mysqli_query($link, $sqlquery) or die(mysql_error());
            echo "<script type='text/javascript'>window.location.assign('print.php')</script>";
            }
        }
        
    ?>
    
    <script type="text/javascript">
        $(function(){
            $("#payment").keyup(function(){  
                if($(this).val() == ''){  
                  $("#change").val(0);
                }else{

                var payment = parseInt($("#payment").val());
                var price = parseInt($("#total").val());

                  $("#change").val(payment - price);
                }
            });
        });
    </script>
    
    <script>
    $(document).ready(function(){

     load_data();

     function load_data(query)
     {
      $.ajax({
       url:"fetch_product.php",
       method:"POST",
       data:{query:query},
       success:function(data)
       {
        $('#result').html(data);
       }
      });
     }
     $('#search').keyup(function(){
      var search = $(this).val();
      if(search != '')
      {
       load_data(search);
      }
      else
      {
       load_data();
      }
     });
    });
    </script>
    <?php include 'footer_links.php' ?>
	</body>
</html>