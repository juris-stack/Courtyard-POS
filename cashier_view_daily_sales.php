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
                        <li class="active">
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
                <li>
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
        <span style="font-size: 22px;"><i class="fa fa-chart-bar"></i> Cashier Daily Sales Report</span>
        <?php
            $query = "SELECT SUM(total_amount) as result FROM sales where DATE(transaction_time) = CURDATE() and cashier = '$cashier'";
            $result = mysqli_query($link, $query) or die(mysql_error());
            $row = mysqli_fetch_array($result);
        ?>
        <?php if($row['result']==0){ ?>
            <label style='float: right; margin-top: 6px;'>Total Sales: <span style='color: #5cb85c;'>₱ 0.00</span></label>
        <?php }else{ ?>
            <label style='float: right; margin-top: 6px;'>Total Sales: <span style='color: #5cb85c;'>₱ <?php echo $row['result'];?></span></label>
         <?php } ?>
         <a href='fpdf/cashier_report.php' target="_blank"><button class="btn btn-success" style="float: right; margin-right: 2%;"><i class="fas fa-print"></i> Generate Report</button></a>
        <hr>        
        <div id="employee_sales_table">   
            <table id="dtTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">   
                        <thead>  
                            <tr>
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
                        date_default_timezone_set('Asia/Manila');
                        $date = date('y/m/d');
                            $sql = "SELECT * FROM sales where quantity != 0 and DATE(transaction_time) = CURDATE() and cashier ='$cashier' ORDER BY sales_id desc";
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
                         ?>

                                <tr>
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
          $('#employee').change(function(){  
               var employee_id = $(this).val();  
               $.ajax({  
                    url:"load_employee_sales.php",  
                    method:"POST",  
                    data:{employee_id:employee_id},  
                    success:function(data){  
                         $('#employee_sales_table').html(data);
                    }  
               });  
          });  
     });  
     </script>
     <script>  
     $(document).ready(function(){  
          $('#employee').change(function(){  
               var employee_id = $(this).val();  
               $.ajax({  
                    url:"fetch_total_sales.php",  
                    method:"POST",  
                    data:{employee_id:employee_id},  
                    success:function(data){  
                         $('#total_sales').html(data);
                    }  
               });  
          });  
     });  
     </script>
    <?php include 'footer_links.php' ?>
	</body>
</html>