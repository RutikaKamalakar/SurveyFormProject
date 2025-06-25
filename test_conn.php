<?php
$serverName = "RUTIKA\\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "SurveyDB",
    "Uid" => "sa",
    "PWD" => "12345",
    "Encrypt" => false,
    "TrustServerCertificate" => true
);
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "✅ SQL Server Connection Successful!";
} else {
    die(print_r(sqlsrv_errors(), true));
}
?>
