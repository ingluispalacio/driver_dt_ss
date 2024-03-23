<?php
$host = "bsv20xct4d5tlepcwjx4-mysql.services.clever-cloud.com";
$database = "bsv20xct4d5tlepcwjx4";
$user = "u8ir0nmjvjxaix2h";
$password = "QOXhbHEIhP4nuI1hVEno";

try {
    $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec("SET NAMES 'utf8'");
    $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);   
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>