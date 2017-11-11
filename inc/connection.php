<?php
// Import DB connection constants
require_once('config.php');

// MySQL DATABASE CONNECTION
try {
    $conn = new PDO("mysql:host=" . DBSRV, DBUSER, DBPASS);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* Check database exists */
    // Prepare SQL query
    $query = $conn->prepare("CREATE DATABASE IF NOT EXISTS " . DBNAME);
    
    // Run query and check for true boolean return
    if ($query->execute()) {
        // if connection is successful, use specified database for future queries
        $conn->query("use " . DBNAME);
    } else {
        // Display error message and stop execution
        echo 'Error connecting to database<br>';
        exit;
    }
}
	
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>