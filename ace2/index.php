<?php
require 'autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

try{
    $connector= new WindowsPrintConnector("XP-58C");
    $printer = new Printer($connector);
    $printer->text("Hello Ace CAsabuena\n");
    $printer->cut();
    

    $printer->close();
}catch (Exception $e){
    echo "Couldn't print to this printer:" . $e->getMessage() . "\n";
}
echo '<script>window.close</script>';







?>