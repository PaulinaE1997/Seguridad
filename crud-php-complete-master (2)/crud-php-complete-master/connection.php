<?php
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:eliastorres2.database.windows.net,1433; Database = FinalSeg", "EliasTorres", "Contraseña00$");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Error connecting to SQL Server: " . $e->getMessage();
}

//CHECKING ERROR REPORTING 
error_reporting(E_ALL);
ini_set('display_errors', '1');

// SQL Server Extension Sample Code:
$connectionOptions = array(
    "UID" => "EliasTorres",
    "PWD" => "Contraseña00$",
    "Database" => "FinalSeg",
    "LoginTimeout" => 30,
    "Encrypt" => 1,
    "TrustServerCertificate" => 0
);

$serverName = "eliastorres2.database.windows.net,1433"; // Debería ser "eliastorres2.database.windows.net"
$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    echo "Error connecting to SQL Server: " . print_r(sqlsrv_errors(), true);
}
?>