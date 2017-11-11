<?php
// Import DB connection constants
require_once('config.php');

// MySQL DATABASE CONNECTION
try {
    $conn = new PDO("mysql:host=" . DBSRV . ";dbname=" . DBNAME, DBUSER, DBPASS);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Connected successfully
}
	
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>