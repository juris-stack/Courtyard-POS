<?php  
 //filter.php  
 if(isset($_POST["employee_id"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "pos");  
      $output = '';
      $query = " 

           SELECT * FROM sales  
           WHERE employee_id = '".$_POST["employee_id"]."' and DATE(transaction_time) = CURDATE() and quantity != 0  
      ORDER BY sales_id desc";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
           <table class="table table-bordered table-sm" cellspacing="0" width="100%">  
            <tr>
              <th>Product</th>
              <th>Description</th>
              <th>Price</th>
              <th>Purhcase</th>
              <th>Total Amount</th>   
              <th>Cashier</th>
              <th>Date</th>
            </tr> 
      ';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
                $output .= '  
                     <tr>  
                          <td>'. $row["purchase_name"] .'</td>  
                          <td>'. $row["product_description"] .'</td>
                          <td>₱ '. $row["product_price"] .'</td>   
                          <td>'. $row["quantity"] .'</td>  
                          <td><strong style="color: #5cb85c;">₱ '. $row["total_amount"] .'</strong></td>
                          <td>'. $row["cashier"] .'</td>   
                          <td>'. $row["transaction_time"] .'</td>  
                     </tr>  
                ';  
           }  
      }  
      else  
      {  
           $output .= '  
                <tr>  
                     <td colspan="8">Nothing to show</td>  
                </tr>  
           ';  
      }  
      $output .= '</table>';  
      echo $output;  
 }  
 ?>