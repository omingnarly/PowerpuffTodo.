<?php
session_start();
include 'db_connection.php'; // Pastikan ini file koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Cek apakah email sudah ada
        $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo "<script>alert('Email sudah terdaftar! Silakan login.');</script>";
        } else {
            // Simpan user baru
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password);

            if ($stmt->execute()) {
                echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
                exit();
            } else {
                echo "<script>alert('Gagal mendaftar: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        }

        $check->close();
    } else {
        echo "<script>alert('Email dan password tidak boleh kosong!');</script>";
    }
}
?>



<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <title>daftar</title>
</head>
<style>
    body {
        background: linear-gradient(135deg, #f78fb3, #74b9ff, #55efc4);
        background-size: 600% 600%;
        animation: animateBG 12s ease infinite;
        font-family: 'Comic Sans MS', cursive, sans-serif;
    }

    @keyframes animateBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .row > * {
        margin-top: 120px;
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background: #fff0f6;
        border: 3px dashed #fd79a8;
        padding: 0;
      overflow: hidden;
    }

    .card-header {
        background-color: #f78fb3;
        color: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .btn-primary {
        background-color: #74b9ff;
        border: none;
        font-weight: bold;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #55efc4;
        color: #2d3436;
    }

    .register-link {
        margin-top: 15px;
        text-align: center;
        font-size: 14px;
        color: #2d3436;
    }

    .register-link a {
        color: #fd79a8;
        text-decoration: none;
        font-weight: bold;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>




    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <i class="fas fa-file-alt"></i>
                        <h4>Daftar</h4>
                    </div>
                    <div class="card-body">
                    <form action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form>
                        <div class="register-link">
                            Sudah punya akun? <a href="login.php">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

 </html> 