 <?php  
 //load_data.php  
 $connect = mysqli_connect("localhost", "root", "", "pos");  
 $output = '';  
 if(isset($_POST["employee_id"]))  
 {  
      if($_POST["employee_id"] != '')  
      {
           $sql = "SELECT SUM(total_amount) as result FROM sales where DATE(transaction_time) = CURDATE() and employee_id = '".$_POST["employee_id"]."' ";  
      }   
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {    
          if($row["result"]==0){
            $output .= '<label>Total Sales</label>'; 
          }else{   
           $output .= '<label>Total Sales <span style="color: #5cb85c;">₱ '.$row["result"].'</span></label>'; 
          } 
      }  
      echo $output;  
 }  
 ?>