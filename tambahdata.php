
<?php
include '../../db_connection.php'; // File koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form

  $id = $_POST['id'];
  $user_id = $_POST['user_id'];
  $title = $_POST['title'];
  $status = $_POST['status'];
  $deadline = $_POST['deadline'];
  $created_at = $_POST['created_at'];

  // Query untuk menambahkan data ke database
  $query = "INSERT INTO todos (id, user_id, title, status, deadline, created_at) 
              VALUES ('$id', '$user_id', '$title', '$status', '$deadline', '$created_at')";

  if (mysqli_query($conn, $query)) {
    echo "<script>
                alert('Todo berhasil ditambahkan!');
                window.location.href='index.php';
              </script>";
  } else {
    echo "<script>
                alert('Gagal menambahkan Todo : " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
  }

  mysqli_close($conn);
}
?>