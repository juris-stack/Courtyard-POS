<!DOCTYPE html>
<html>
<head>
   <style type="text/css">
       .head{
        text-align: center;
        font-size: 14px;
        font-family:'Cooper Black';
       }
   </style>
</head>

</html><?php

header('Location:../index.php');
session_start();
$hostname="localhost";
$user="root";
$password="";
$database="thesis_pos";

$a=$b=$c=$d=$e=$f=$g=$h=$in=$j=$k=$l=$m=$n=$o=$p=$q=$r=$rr='';

/* Change to the correct path if you copy this example! */
require 'autoload.php';
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\GdEscposImage;

$link=mysqli_connect($hostname,$user,$password) or die ("Error Connection");
mysqli_select_db($link, $database) or die ("Error creating database");
$result=mysqli_query($link, "SELECT MAX(quenumber) as 'new' FROM que where taposna=0;");
for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++){
$a=$num_rows["new"];
}
//===============================================================
//mysqli_query($link, "UPDATE que SET taposna=1 where quenumber=$a;");
//===============================================================
$result1=mysqli_query($link, "SELECT * FROM que1 where quenumber like '%$a%' AND taposna=0");
         //mysqli_query($link, "UPDATE que1 SET taposna=1 where quenumber like '%$a%';");
for($i=0; $i<$num_rows=mysqli_fetch_array($result1);$i++){
$b=$num_rows["quenumber"];
$d=$num_rows["name"];
$e=$num_rows["accountnum"];
$f=$num_rows["amount"];
$g=$num_rows["name2"];
$h=$num_rows["accountnum2"];
$in=$num_rows["amount2"];
$j=$num_rows["name3"];
$k=$num_rows["accountnum3"];
$l=$num_rows["amount3"];
$m=$num_rows["name4"];
$n=$num_rows["accountnum4"];
$o=$num_rows["amount4"];
$p=$num_rows["taposna"];
$q=$num_rows["contact"];
$r=$num_rows["dtime"];
}

date_default_timezone_set("Asia/Hong_Kong");

// Prints something like: Monday 8th of August 2005 03:12:46 PM
$rr=date('l,F j,Y h:i a');


/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
try {
    // Enter the share name for your USB printer here
    //$connector = null;

    $connector = new WindowsPrintConnector("posprint");

    $logo = EscposImage::load("resources/3.png");
    $printer = new Printer($connector);
    
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    /* Print top logo */
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> bitImageColumnFormat($logo);
    /* Print a "Hello world" receipt" */
    $printer -> setTextSize(1, 1);
    $printer -> setTextSize(1, 1);
    $printer -> text("$rr\n");
    $printer -> text("--------------------------------");
    $printer -> text("Your Priority Number is\n");
    $printer -> setTextSize(4, 4);
    $printer -> text($b);
    $printer -> setTextSize(1, 1);
    $printer -> text("\nPlease approach the teller when your number is called\n");
    $printer -> setTextSize(1, 1);
    $printer -> text("--------------------------------\nInquire queues:\nText BLCIQ to 09553559459 or \nvisit www.blci.000webhostapp.com\n");
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

?>