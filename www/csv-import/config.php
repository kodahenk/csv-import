<?php

/**
 * maximum size of the uploaded file
 */
define('MAX_FILE_SIZE', 2097152);

$DBuser = 'root';
$DBpass = $_ENV['MYSQL_ROOT_PASSWORD'];
$pdo = null;

try {
    $database = 'mysql:host=database:3306;dbname=import_db';
    $pdo = new PDO($database, $DBuser, $DBpass);
} catch (PDOException $e) {
    echo "Error: Unable to connect to MySQL. Error:\n $e";
}