<?php
$dbhost = "localhost";
$dbname = "xyz";
$dbuser = "maria";
$dbpassword = "dbmaria";
try{
$db = new PDO("mysql:host=".$dbhost.";dbname=".$dbname, $dbuser, $dbpassword);
} catch (PDOException $e){
echo "Błąd połączenia z bazą danych";
}

?>