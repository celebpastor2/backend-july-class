<?php
require "config.php";
$hostname = MYSQL_HOST;
$dbname = MYSQL_DATABASE;
$username = MYSQL_ADMIN;
$password = MYSQL_PASSWORD;
$connect_string = "mysql:host=$hostname;dbname=$dbname";
//$con_string = "sqlite:database/database.sqlite";
try{
    $con = new PDO($connect_string, $username, $password);
    //properties 
    //methods
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database Connection Succeed";
} catch(PDOException $e ){
    echo "Connection Failed " . $e->getMessage();
}
