<?php
// ENABLE ERROR REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get form input
$username = $_POST['username'] ?? '';
$phone = $_POST['Phone'] ?? '';
$email = $_POST['Email'] ?? '';
$password = $_POST['password'] ?? '';
$tipe = $_POST['tipe'] ?? '0'; // default to 0

// Dummy placeholder values
$fullname = '';
$alamat = '';
$insta = '';
$fesbuk = '';
$twitter = '';

// Validate required fields
if (!empty($username) && !empty($phone) && !empty($email) && !empty($password)) {
    // DB connection
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "Database_GASS";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($tipe == "0") {
        // Penyewa
        $status = "1";
        $sql = "INSERT INTO Penyewa (Status, Username, Fullname, Email, Password, Telpon, Alamat, insta, fesbuk, twitter)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssssss", $status, $username, $fullname, $email, $hashedPassword, $phone, $alamat, $insta, $fesbuk, $twitter);
    } else {
        // Pemilik
        $sql = "INSERT INTO Pemilik (Username, Fullname, Email, Phone, Alamat, Password, Insta, Fesbuk, Twitter)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssssss", $username, $fullname, $email, $phone, $alamat, $hashedPassword, $insta, $fesbuk, $twitter);
    }

    if ($stmt->execute()) {
        echo "Registrasi berhasil!";
    } else {
        echo "Error saat menyimpan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Data belum lengkap!";
    die();
}
?>
