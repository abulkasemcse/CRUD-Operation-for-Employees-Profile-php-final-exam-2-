<?php

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'testdb';

try {
    $DB_CON = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $DB_CON->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // echo "Connect Successfully. Host info: "
      //  . $DB_CON->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));
} catch (PDOException $e) {
    // echo $e->getMessage();
    die("ERROR: Could not connect. " . $e->getMessage());
}
