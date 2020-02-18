<!DOCTYPE html>
<html lang="en">
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
                <li class="active">
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
                <li class="active">
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
        <span style="font-size: 22px;"><i class="fas fa-tachometer-alt"></i> Dashboard</span>
        <hr>
        <?php if($access=='admin'){ ?>
         <a href="product.php"><div class="dashboard-squares">
            <div class="dashboard-squares-icon">
                <i class="fa fa-shopping-bag"></i> 
            </div>
            <div class="dashboard-squares-content">
                <?php
                    date_default_timezone_set('Asia/Manila');
                    $date = date('Y-m-d', time());
                    $query = "SELECT count(product_id) as result FROM product ";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Total products</h5></center>";
                        echo "<span style='float: right;'>".$row['result']."</span>";
                ?>
            </div>
        </div></a>
        <a href="cashier_daily_sales.php"><div class="dashboard-squares">
            <div class="dashboard-squares-icon">
                <i class="fa fa-chart-bar"></i>
            </div>
            <div class="dashboard-squares-content">
                <?php
                    $query = "SELECT count(sales_id) as result FROM sales where DATE(transaction_time) = CURDATE()";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Daily Sales Report</h5></center>";
                        echo "<span style='float: right;'>".$row['result']."</span>";
                ?>
            </div>
        </div></a>
        <div class="dashboard-squares">
            <div class="dashboard-squares-icon">
                <i class='fa fa-shopping-cart'></i> 
            </div>
            <div class="dashboard-squares-content">
                <?php
                    $query = "SELECT Sum(total_amount) as result FROM transactions";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);

                    ?>
                    <center><h5>Total Sales</h5></center>
                    <?php
                    if($row['result']==0){
                    ?>
                    <span style='float: right;'>₱ 0.00</span>
                    <?php
                    }else{
                    ?>
                    <span style='float: right;'>₱ <?php echo $row['result'];?></span>
                    <?php
                    }
                ?>
            </div>
        </div>
        <?php }else if($access=='employee'){ ?>
        <a href="product.php"><div class="dashboard-squares-employee">
            <div class="dashboard-squares-icon">
                <i class="fa fa-shopping-bag"></i> 
            </div>
            <div class="dashboard-squares-content">
                <?php
                    date_default_timezone_set('Asia/Manila');
                    $date = date('Y-m-d', time());
                    $query = "SELECT count(product_id) as result FROM product ";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Total products</h5></center>";
                        echo "<span style='float: right;'>".$row['result']."</span>";
                ?>
            </div>
        </div></a>
         <a href="cashier_view_daily_sales.php"><div class="dashboard-squares-employee">
            <div class="dashboard-squares-icon">
                <i class="fa fa-chart-bar"></i>
            </div>
            <div class="dashboard-squares-content">
                <?php
                    $query = "SELECT count(sales_id) as result FROM sales where DATE(transaction_time) = CURDATE() and cashier = '$cashier'";
                    $result = mysqli_query($link, $query) or die(mysql_error());
                    $row = mysqli_fetch_array($result);
                        echo "<center><h5>Daily Sales Report</h5></center>";
                        echo "<span style='float: right;'>".$row['result']."</span>";
                ?>
            </div>
        </div></a>
        <?php } ?>
        <div class="low-product-content">
            <span style="font-size: 22px;"><i class="fa fa-shopping-bag"></i> Low in Stock</span>
            <hr>

            <table class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
                <thead>  
                    <tr> 
                        <th style="text-align: center;">Photo</th>
                        <th>Product Name</th>    
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Barcode #</th>
                        <th>Description</th> 
                        <th style="text-align: center;">Action</th>  
                    </tr>  
                </thead>
                    <?php
                    $res = "SELECT * FROM product WHERE remaining_stock <= 3 ORDER BY product_name ASC";
                    $result = mysqli_query($link, $res) or die(mysql_error());

                        for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                            $productid=$num_rows["product_id"];
                            $name=$num_rows["product_name"];
                            $price=$num_rows["product_price"];
                            $stock=$num_rows["total_stock"];
                            $remainingstock=$num_rows["remaining_stock"];
                            $barcode=$num_rows["barcode_no"];
                            $description=$num_rows["product_description"];
                            $productmedia=$num_rows["product_media"];
                                    
                                      
                    ?>

                    <tr>
                        <td><center><img style='height:25px; width:25px; border-radius: 100%;' src="<?=$productmedia;?>"></center></td>
                        <td><input type='hidden' value='<?php echo $productid;?>'><?=$name;?></td>
                        <td>₱ <?=$price;?></td>
                        <td><?php
                            if($remainingstock=="0"){
                                echo"<span style='color: #d9534f;'><strong>Out of Stock</strong></span>";
                            }else{
                                echo"".$remainingstock." out of ".$stock."";     
                            }
                            ?>
                        </td> 
                        <td><?=$barcode;?></td>
                        <td><?=$description;?></td>               
                        <td>
                            <center>
                                <?php if($access=='admin'){ ?>
                                <a href='edit_product.php?id=<?php echo $productid;?>' ><button class='manage'><i class='fas fa-cog'></i></button></a>
                                <?php }else if($access=='employee'){ ?>
                                <a href='product_inventories.php?id=<?php echo $productid;?>' ><button class='unblock'><i class='fas fa-clipboard-list'></i></button></a>
                                <?php } ?>
                             </center>
                        </td>
                    </tr>
                                    
                    <?php } ?>
                    
                            
                </table>
            </div>

            
    </div>
    <?php include 'footer_links.php' ?>
	</body>
</html>