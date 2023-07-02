<?php
// used to connect to the database
$host = "localhost";
$db_name = "BooHeng";
$username = "BooHeng";
$password = "wKGmXRUHPH-[Z]Vd";
  
try {
    //PHP DATABASE OBJECT
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
?>