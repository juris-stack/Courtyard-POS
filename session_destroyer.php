<?php session_start();
    if(!isset($_SESSION['id'])) {
          header('location: logout.php');
          exit();
          } 
 ?>