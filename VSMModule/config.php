<?php

/*
 * Koneksi database hanya dapat menggunakan mysqli
 *
*/

include '../admin/connect-db.php';

$database = [
    'hostname' => $databaseHost,
    'username' => $databaseUsername,
    'password' => $databasePassword,
    'database' => $databaseName,
    'port'     => $databasePort
];