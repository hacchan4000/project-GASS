<?php
// Code to handle user sign-up and insert data into multiple tables

$username = $_POST['username'];
$Phone = $_POST['Phone'];
$email = $_POST['Email'];
$pass = $_POST['password'];
$tipe = $_POST['tipe'];

// Ensure no field is empty
if (!empty($username) && !empty($Phone) && !empty($email) && !empty($pass)) {
    // Database connection parameters
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "Database_GASS";

    // Establish connection to the database
    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) { // Check for connection error
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Hash the password for security
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        if ($tipe == 0) {
            $query = 'SELECT * FROM Penyewa';
            $masukan = '';
        }

        // Queries
       
        $conn->close();
    }
} else {
    echo "Data belum lengkap";
    die();
}
?>
