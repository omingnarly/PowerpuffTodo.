<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $edit_title = trim($_POST['edit_title']);
    $edit_deadline = $_POST['edit_deadline'];
    $user_id = $_SESSION['user_id'];

    if (!empty($edit_title)) {
        $stmt = $conn->prepare("UPDATE todos SET title = ?, deadline = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $edit_title, $edit_deadline, $edit_id, $user_id);

        
if ($updateBerhasil) {
    $_SESSION['success'] = "ToDo berhasil diedit!";
} else {
    $_SESSION['success'] = "Edit gagal!"; // bisa diganti jadi 'error' kalau mau dibedain
}

header("Location: index.php");
exit;


        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color:red;'>Gagal mengedit: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color:red;'>Judul tidak boleh kosong.</p>";
    }
}
?>