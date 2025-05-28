<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user = $_POST['myUser'];
    $pass = $_POST['myPassword'];
    $tipe = $_POST['tipe_user'];

    if (!empty($user) && !empty($pass) && ($tipe == "0" || $tipe == "1")) {
        $host = "localhost";
        $port = 3308;
        $dbUsername = "root";
        $dbPass = "";
        $dbName = "Database_GASS";

        $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

        if ($conn->connect_error) {
            error_log("Connection failed: " . $conn->connect_error);
            die("Internal server error. Please try again later.");
        }

        $table = $tipe == "0" ? "Penyewa" : "Pemilik";
        $query = "SELECT * FROM $table WHERE Username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
            $storedPassword = $data['Password'];

            if (password_verify($pass, $storedPassword)) {
                session_regenerate_id(true);
                $_SESSION['user'] = $data;
                $_SESSION['Username'] = $data['Username'];

                // Redirect based on user type
                if ($tipe == "0") {
                    header("Location: ../homePembeli.php");
                } else {
                    header("Location: ../homePeminjam.php");
                }
                exit();
            } else {
                $errorMessage = "Password salah.";
            }
        } else {
            $errorMessage = "Akun tidak ditemukan.";
        }

        $stmt->close();
        $conn->close();

        header("Location: ../login.php?error=" . urlencode($errorMessage));
        exit();
    } else {
        $errorMessage = "Harap masukkan user, password, dan tipe.";
        header("Location: ../login.php?error=" . urlencode($errorMessage));
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
