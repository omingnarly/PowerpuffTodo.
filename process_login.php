<?php
session_start();
include 'db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Cari user berdasarkan email
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['user_id']; // pakai nama kolom yang benar
        $_SESSION['email'] = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        echo "<script>
            alert('Password salah!');
            window.location.href='login.php';
            </script>";
//             echo "Input: $password<br>";
// echo "DB: " . $user['password'];
    }
} else {
    echo "<script>
        alert('Email tidak ditemukan!');
        window.location.href='login.php';
        </script>";
}

$stmt->close();
$conn->close();
?>
