$connectionString = "Driver={ODBC Driver 18 for SQL Server};Server=tcp:eliastorres2.database.windows.net,1433;Database=FinalSeg;Uid=EliasTorres;Pwd=Contraseña00$;Encrypt=yes;TrustServerCertificate=no;Connection Timeout=30;";
$odbcConnection = odbc_connect($connectionString, 'EliasTorres', 'Contraseña00$');

if (!$odbcConnection) {
    die('Error de conexión: ' . odbc_errormsg());
} else {
    echo 'Conexión establecida correctamente.';
}