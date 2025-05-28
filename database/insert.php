<?php
// ENABLE ERROR REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = $_POST['username'];
$phone    = $_POST['Phone'];
$email    = $_POST['Email'];
$pass     = $_POST['password'];
$tipe     = $_POST['tipe']; // 0 = Penyewa, 1 = Pemilik
$fullname = $_POST['fullname'];
$alamat   = $_POST['alamat'];
$insta    = $_POST['insta'];
$fesbuk   = $_POST['fesbuk'];
$twitter  = $_POST['twitter'];

// Dummy placeholder values
$fullname = '';
$alamat = '';
$insta = '';
$fesbuk = '';
$twitter = '';

// Validate required fields
if (!empty($username) && !empty($phone) && !empty($email) && !empty($pass)) {
    // Database connection
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "Database_GASS";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password securely
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Generate unique ID with prefix
    $prefix = ($tipe == 0) ? '0' : '1';
    $uniqueId = $prefix . uniqid(); // e.g. 0<random>, 1<random>

    if ($tipe == 0) {
        // INSERT INTO Penyewa
        $stmt = $conn->prepare("INSERT INTO Penyewa 
            (Id, Status, Username, Fullname, Email, Password, Telpon, Alamat, insta, fesbuk, twitter) 
            VALUES (?, '0', ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssssss", $uniqueId, $username, $fullname, $email, $hashedPass, $phone, $alamat, $insta, $fesbuk, $twitter);

    } else {
        // INSERT INTO Pemilik
        $stmt = $conn->prepare("INSERT INTO Pemilik 
            (Id, Username, Fullname, Email, Phone, Alamat, Password, Insta, Fesbuk, Twitter) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssssss", $uniqueId, $username, $fullname, $email, $phone, $alamat, $hashedPass, $insta, $fesbuk, $twitter);
    }

    // Execute and confirm
    if ($stmt->execute()) {
        header("Location: ../login.php");
    } else {
        echo "Gagal menyimpan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Data belum lengkap";
    die();
}
?>
