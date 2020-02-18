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
                        <li class="active">
                            <a href="sales_report.php">View all Sales</a>
                        </li>
                        <li class="sales-report-list">
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
        <span style="font-size: 22px;"><i class="fa fa-chart-bar"></i> Sales Report</span>
        
        <?php
            $query = "SELECT SUM(total_amount) as result FROM sales";
            $result = mysqli_query($link, $query) or die(mysql_error());
            $row = mysqli_fetch_array($result);
        ?>
        <?php if($row['result']==0){ ?>
            <label style='float: right;'>Total Sales: <span style='color: #5cb85c;'>₱ 0.00</span></label>
        <?php }else{ ?>
            <label style='float: right;'>Total Sales: <span style='color: #5cb85c;'>₱ <?php echo $row['result'];?></span></label>
         <?php } ?>
        <hr>
        <h4 style="text-align: center;"><i class="fas fa-print"></i> Generate Reports</h4>
        <a href="fpdf/yesterday_sales.php" target="_blank">
        <div class="sales-report-squares">
            <div class="sales-report-squares-icon">
                <i class="fas fa-print"></i>
            </div>
            <div class="sales-report-squares-content">
                <?php
                    $query = "SELECT SUM(total_amount) as result FROM transactions where DATE(transaction_date) = CURDATE() - INTERVAL 1 DAY";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Yesterday Sales</h5></center>";
                ?>
                <?php
                    if($row['result']==0){
                    ?>
                    <span style='float: right'>₱ 0.00</span></label>
                    <?php
                    }else{
                    ?>
                    <span style='float: right'>₱ <?php echo $row['result']?></span>
                    <?php
                    }
                ?>
            </div>
        </div>
        </a>
        <a href="fpdf/daily_sales.php" target="_blank">
        <div class="sales-report-squares">
            <div class="sales-report-squares-icon">
                <i class="fas fa-print"></i> 
            </div>
            <div class="sales-report-squares-content">
                <?php
                    $query = "SELECT SUM(total_amount) as result FROM transactions where DATE(transaction_date) = CURDATE()";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Today Sales</h5></center>";
                ?>
                <?php
                    if($row['result']==0){
                    ?>
                    <span style='float: right'>₱ 0.00</span></label>
                    <?php
                    }else{
                    ?>
                    <span style='float: right'>₱ <?php echo $row['result']?></span>
                    <?php
                    }
                ?>
            </div>
        </div>
        </a>
        <a href="fpdf/weekly_sales.php" target="_blank">
        <div class="sales-report-squares">
            <div class="sales-report-squares-icon">
                <i class="fas fa-print"></i> 
            </div>
            <div class="sales-report-squares-content">
                <?php
                    date_default_timezone_set('Asia/Manila');
                    $query = "SELECT SUM(total_amount) as result FROM transactions WHERE DATE(transaction_date) > CURDATE() - INTERVAL 7 DAY";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Weekly Sales</h5></center>";
                ?>
                <?php
                    if($row['result']==0){
                    ?>
                    <span style='float: right'>₱ 0.00</span></label>
                    <?php
                    }else{
                    ?>
                    <span style='float: right'>₱ <?php echo $row['result']?></span>
                    <?php
                    }
                ?>
            </div>
        </div>
        </a>
        <a href="fpdf/monthly_sales.php" target="_blank">
        <div class="sales-report-squares">
            <div class="sales-report-squares-icon">
                <i class="fas fa-print"></i> 
            </div>
            <div class="sales-report-squares-content">
                <?php
                    date_default_timezone_set('Asia/Manila');
                    $date = date("Y/m/d");
                    $query = "SELECT SUM(total_amount) as result FROM transactions WHERE MONTH(transaction_date) = MONTH(CURDATE())";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Monthly Sales</h5></center>";
                ?>
                <?php
                    if($row['result']==0){
                    ?>
                    <span style='float: right'>₱ 0.00</span></label>
                    <?php
                    }else{
                    ?>
                    <span style='float: right'>₱ <?php echo $row['result']?></span>
                    <?php
                    }
                ?>
            </div>
        </div>
        </a>   
        <table id="dtTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
                        <thead>  
                            <tr>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Purhcase</th>
                                <th>Amount</th>   
                                <th>Cashier</th>
                                <th>Date</th>
                            </tr>  
                        </thead>  
                        <?php
                            $sql = "SELECT * FROM sales where quantity != 0 ORDER BY sales_id desc";
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
            </table>  
        
    </div>
    <?php include 'footer_links.php' ?>
	</body>
</html>