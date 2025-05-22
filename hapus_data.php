<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../../db_connection.php'; // Pastikan file koneksi benar

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$id || !$user_id || !is_numeric($id)) {
        die("ID atau user_id tidak valid.");
    }

    echo "ID yang akan dihapus: $id<br>";
    echo "User ID sesi: $user_id<br>";

    // Query untuk menghapus todo berdasarkan id dan user_id
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Todo berhasil dihapus.";
        // Redirect setelah 2 detik agar user bisa melihat pesan
        header("refresh:2;url=index.php");
        exit();
    } else {
        die("Query error: " . $stmt->error);
    }
}
?>


// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     $id = $_GET['id'];  // ID todo yang mau dihapus
//     $user_id = $_SESSION['user_id'];  // Hanya boleh hapus todo milik sendiri

//     // Lindungi dari SQL Injection dengan prepared statement
//     $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
//     $stmt->bind_param("ii", $id, $user_id);
    
//     if ($stmt->execute()) {
//         header("Location: index.php");
//         exit();
//     } else {
//         die("Query error: " . $stmt->error);
//     }
// }

