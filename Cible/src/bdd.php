<?php   

$bdd = new PDO('mysql:host=db;dbname=ctf_db;charset=utf8','root','rootpassword');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>