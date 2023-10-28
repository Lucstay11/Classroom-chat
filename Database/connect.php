<?php
//SETUP HERE THE CONNECTION AT THE DATABASE
$HOST="";
$USER="";
$PASS="";
 try{
    $database = new PDO('mysql:host='.$HOST.';dbname=chat',$USER,$PASS, array(PDO::ATTR_PERSISTENT => true)); // Persistent connection
 }
 
 catch(Exception $e){
     die("Erreur: ".$e->getMessage()); // Uncomment this line in production to hide errors on the site
 }
?>
