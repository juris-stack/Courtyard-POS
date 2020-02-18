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
                        <li class="sales-report-list">
                            <a href="sales_report.php">View all Sales</a>
                        </li>
                        <li class="sales-report-list">
                            <a href="cashier_daily_sales.php">Cashier Daily Sales</a>
                        </li>
                        <li class="active">
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
    <?php
     function fill_invoice($link)  
     {  
          $output = '';  
          $sql = "SELECT * FROM transactions";  
          $result = mysqli_query($link, $sql);  
          while($row = mysqli_fetch_array($result))  
          {  
               $output .= '<option value="'.$row["transaction_id"].'">'.$row["transaction_id"].'</option>';  
          }  
          return $output;  
     }
    ?>
    <div class="scroll-content">
        <span style="font-size: 22px;"><i class="fa fa-chart-bar"></i> Invoices</span>
        <hr>
        <label id="total_amount">Total Amount</label>
        <a href="view_invoices.php"><button class="btn btn-primary" style="float: right; margin-left: 5px; border-radius: 0; background-color: white; color: black; border: 1px solid #ccc"><i class="fa fa-sync-alt"></i></button></a>
        <select name="invoice" id="invoice" class="employee-dropdown">
            <option>Select Invoice</option>    
            <?php echo fill_invoice($link); ?>  
        </select>
        <div id="invoices_table">   
            <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">   
                        <thead>  
                            <tr>
                                <th>Invoice #</th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Purhcase</th>
                                <th>Total Amount</th>   
                                <th>Cashier</th>
                                <th>Date</th>
                            </tr>  
                        </thead>  
                        <?php
                            $sql = "SELECT * FROM sales where quantity != 0 ORDER BY sales_id asc";
                            $result = mysqli_query($link, $sql) or die(mysql_error());

                                for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                                        $productid=$num_rows["product_id"];
                                        $productname=$num_rows["purchase_name"];
                                        $description=$num_rows["product_description"];
                                        $numberorder=$num_rows["quantity"];
                                        $amount=$num_rows["total_amount"];
                                        $price=$num_rows["product_price"];
                                        $cashier=$num_rows["cashier"];
                                        $transactiondate=$num_rows["transaction_time"];
                                        $invoice=$num_rows["invoice_number"];                           
                         ?>
                                <tr>
                                    <?php if($invoice==0){?>
                                    <td>Pending</td> 
                                    <?php }else{?>
                                    <td><?php echo $invoice; }?></td>
                                    <td><?php echo $productname;?></td>
                                    <td><?php echo $description;?></td>
                                    <td>₱ <?php echo $price;?></td>
                                    <td><?php echo $numberorder;?></td>
                                    <td><strong style="color: #5cb85c;">₱ <?php echo $amount;?></strong></td>
                                    <td><?php echo $cashier;?></td>
                                    <td><?php echo $transactiondate;?></td>          
                                </tr>
                                
                    <?php } ?>  
        </div>  
        
    </div>
    <script>  
     $(document).ready(function(){  
          $('#invoice').change(function(){  
               var invoice = $(this).val();  
               $.ajax({  
                    url:"fetch_invoice.php",  
                    method:"POST",  
                    data:{invoice:invoice},  
                    success:function(data){  
                         $('#invoices_table').html(data);
                    }  
               });  
          });  
     });  
     </script>

     <script>  
     $(document).ready(function(){  
          $('#invoice').change(function(){  
               var transaction_id = $(this).val();  
               $.ajax({  
                    url:"fetch_invoice_total_amount.php",  
                    method:"POST",  
                    data:{transaction_id:transaction_id},  
                    success:function(data){  
                         $('#total_amount').html(data);
                    }  
               });  
          });  
     });  
     </script>
     <!-- <script>
    $(document).ready(function(){


     function load_data(query)
     {
      $.ajax({
       url:"fetch_invoice.php",
       method:"POST",
       data:{query:query},
       success:function(data)
       {
        $('#invoices_table').html(data);
       }
      });
     }
     $('#search').keyup(function(){
      var search = $(this).val();
       load_data(search);
     });
    });
    </script> -->
    <?php include 'footer_links.php' ?>
	</body>
</html>