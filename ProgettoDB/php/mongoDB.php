<?php
    require '/vendor/autoload.php';


    $conn = new MongoDB\Client("mongodb://localhost:27017/?readPreference=primary&appname=MongoDB%20Compass&directConnection=true&ssl=false");
    $db = $m->mydb;
    echo "Database mydb selected";
    $collection = $db->createCollection("mycol");
    echo "Collection created succsessfully";
?>