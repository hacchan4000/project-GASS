<?php
session_start();

//cek poin
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user = $_POST['myUser'];
    $pass = $_POST['myPassword'];
    $tipe = $_POST['tipe'];

    if (!empty($user) && !empty($pass)) {
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

        // Reusable function for login validation
        function checkUser($conn, $query, $param, $type) {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $param);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $data = $result->fetch_assoc();
                $storedPassword = $data['Password'];

                if (password_verify($_POST['myPassword'], $storedPassword)) {
                    session_regenerate_id(true);

                    if ( $type == 1) {
                        $_SESSION['user'] = $data['user'];
                        $_SESSION['Username'] = $data['Username'];
                        header("Location: ../main-menu.php");
                    } else {
                        $_SESSION['user'] = $data['user'];
                        $_SESSION['Username'] = $data['Username'];
                        header("Location: ../profil.php");
                    }

                    // Set session variables based on user role
                   
                    $stmt->close();
                    exit();
                } else {
                    return "Password salah.";
                }
            }
            $stmt->close();
            return false; // User not found
        }

        // Check student login
        $errorMessage = checkUser($conn, "SELECT * FROM Penyewa WHERE Username = ?", $user, $tipe);
        $errorMessage = checkUser($conn, "SELECT * FROM Pemilik WHERE Username = ?", $user, $tipe);
        
        

        $conn->close();

        // If no user found
        if ($errorMessage) {
            header("Location: ../login.php?error=" . urlencode($errorMessage));
        } else {
            header("Location: ../login.php?error=" . urlencode("Akun tidak ditemukan."));
        }
        exit();
    } else {
        $errorMessage = "Harap masukkan user dan password.";
        header("Location: ../login.php?error=" . urlencode($errorMessage));
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
