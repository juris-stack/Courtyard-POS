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
                <li class="active">
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
                <li class="active">
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
        <span style="font-size: 22px;"><i class='fas fa-clipboard-list'></i> Inventories</span>
        <a href="product.php"><button class="btn btn-primary" style="float: right;"><i class="fas fa-arrow-left"></i> Return to table</button></a>
        <hr>
        <?php
            $editID = $_GET['id'];
            $res1 = "SELECT * FROM product WHERE `product_id` = '$editID'";
            $result1 = mysqli_query($link, $res1) or die(mysql_error());
                for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++) {
                    $name=$num_rows["product_name"];
                    $item=$num_rows["product_media"];
                    
        ?>
        <h4>Stock Inventory</h4>
        <table id="dtStock" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
            <thead>  
                <tr>
                    <th>Photo</th>
                    <th>Product Name</th>
                    <th>Prior Stock</th>
                    <th>Added Stock</th>
                    <th>New Stock</th>   
                    <th>Date Updated</th>
                </tr>  
            </thead>  
            <?php
                $res = "SELECT * FROM product_stock_inventory WHERE `product_name` = '$name'";
                $result = mysqli_query($link, $res) or die(mysql_error());

                for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                    $name=$num_rows["product_name"];
                    $stock=$num_rows["prior_stock"];
                    $addedstock=$num_rows["added_stock"];
                    $newstock=$num_rows["new_stock"];
                    $date=$num_rows["date_updated"];                            
            ?>

            <tr>
                <td><center><img style='height:25px; width:25px; border-radius: 100%;' src="<?=$item;?>"></center></td>
                <td><?= $name;?></td>
                <td><?= $stock;?></td>
                <td><?= $newstock;?></td>
                <td><?= $addedstock;?></td>
                <td><?= $date;?></td>      
            </tr>
                                                    
            <?php } ?>
        </table>
        <hr>
        <h4>Price Updates</h4>
        <table id="dtPrice" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">  
            <thead>  
                <tr>
                    <th>Photo</th>
                    <th>Product Name</th>
                    <th>Prior Price</th>
                    <th>New Price</th>   
                    <th>Date Updated</th>
                </tr>  
            </thead>  
            <?php
                $res = "SELECT * FROM product_price_updates WHERE `product_name` = '$name'";
                $result = mysqli_query($link, $res) or die(mysql_error());

                for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++) {
                    $name=$num_rows["product_name"];
                    $price=$num_rows["prior_price"];
                    $newprice=$num_rows["new_price"];
                    $pdate=$num_rows["date_updated"];                            
            ?>

            <tr>
                <td><center><img style='height:25px; width:25px; border-radius: 100%;' src="<?=$item;?>"></center></td>
                <td><?= $name;?></td>
                <td>₱ <?= $price;?></td>
                <td>₱ <?= $newprice;?></td>
                <td><?= $pdate;?></td>      
            </tr>
                                                    
            <?php } ?>
        <?php } ?>
        </table>
        
    </div>
    <?php include 'footer_links.php' ?>
	</body>
</html>