<?php
// Ambil data dari form
$username = $_POST['username'];
$phone = $_POST['Phone'];
$email = $_POST['Email'];
$password = $_POST['password'];
$tipe = $_POST['tipe'];

// Optional: Tambahan dummy data untuk Fullname, Alamat, Sosmed
$fullname = ""; // bisa diganti dengan data tambahan dari form
$alamat = "";
$insta = "";
$fesbuk = "";
$twitter = "";

// Cek apakah data wajib diisi sudah lengkap
if (!empty($username) && !empty($phone) && !empty($email) && !empty($password)) {
    // Koneksi ke database
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "Database_GASS";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($tipe == "0") {
        // Insert ke tabel Penyewa
        $status = "1"; // Misalnya 1 untuk aktif atau default
        $sql = "INSERT INTO Penyewa (Status, Username, Fullname, Email, Password, Telpon, Alamat, insta, fesbuk, twitter)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $status, $username, $fullname, $email, $hashedPassword, $phone, $alamat, $insta, $fesbuk, $twitter);

    } else {
        // Insert ke tabel Pemilik
        $sql = "INSERT INTO Pemilik (Username, Fullname, Email, Phone, Alamat, Password, Insta, Fesbuk, Twitter)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $username, $fullname, $email, $phone, $alamat, $hashedPassword, $insta, $fesbuk, $twitter);
    }

    if ($stmt->execute()) {
        echo "Registrasi berhasil!";
        // redirect atau tampilkan pesan sukses
        header("Location: ../sukses.php");
    } else {
        echo "Gagal memasukkan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Data belum lengkap!";
    die();
}
?>
