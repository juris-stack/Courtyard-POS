 <?php  
 //load_data.php  
 $connect = mysqli_connect("localhost", "root", "", "pos");  
 $output = '';  
 if(isset($_POST["transaction_id"]))  
 {  

      $sql = "SELECT SUM(total_amount) as result FROM sales where invoice_number = '".$_POST["transaction_id"]."' ";     
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {    
          if($row["result"]==0){
            $output .= '<label>Total Amount</label>'; 
          }else{   
           $output .= '<label>Total Amount: <span style="color: #5cb85c;">₱ '.$row["result"].'</span></label>'; 
          } 
      }

      echo $output;

 }  
 ?>