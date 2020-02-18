<?php

session_start();
$hostname="localhost";
$user="root";
$password="";
$database="thesis_pos";

$a=$b=$c=$d=$e=$f=$g=$h=$in=$j=$k=$l=$m=$n=$o=$p=$q=$r='';

/* Change to the correct path if you copy this example! */
require 'autoload.php';
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\GdEscposImage;

$link=mysqli_connect($hostname,$user,$password) or die ("Error Connection");
mysqli_select_db($link, $database) or die ("Error creating database");

$result=mysqli_query($link, "SELECT * from product where product_id limit 10");
for($i=0; $i<$num_rows=mysqli_fetch_array($result);$i++){
$a=$num_rows["product_name"];
$b=$num_rows["quantity"];
$c=$num_rows["price"];
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
    $connector = new WindowsPrintConnector("XP-58C");

    $logo = EscposImage::load("resources/4.png");
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
    $printer -> text("$a $b $c \n");
    $printer -> setTextSize(1, 1);
    $printer -> text("\n\n\n");
    $printer -> setTextSize(1, 1);
    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}

?>