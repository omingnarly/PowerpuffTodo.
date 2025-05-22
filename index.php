        <?php 
        session_start();
        include 'db_connection.php';



        // Proses form jika ada submit
        if (isset($_POST['submit'])) {
            $title = trim($_POST['title']);

            if (!empty($title)) {
                $stmt = $conn->prepare("INSERT INTO todos (title) VALUES (?)");
                $stmt->bind_param("s", $title);

                if ($stmt->execute()) {
                    echo "<p style='color:green;'>To-do berhasil ditambahkan!</p>";
                } else {
                    echo "<p style='color:red;'>Gagal menambahkan to-do: " . $stmt->error . "</p>";
                }

                $stmt->close();
            } else {
                echo "<p style='color:red;'>Judul to-do tidak boleh kosong.</p>";
            }
        }  


// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Cek jika ada parameter selesai dalam URL dan ubah status menjadi selesai
if (isset($_GET['selesai'])) {
    $selesai_id = $_GET['selesai'];
    $user_id = $_SESSION['user_id']; // Mendapatkan user_id dari session

    // Query untuk mengubah status menjadi selesai (status = 1)
    $stmt = $conn->prepare("UPDATE todos SET status = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $selesai_id, $user_id);

    if ($stmt->execute()) {
        // Redirect ke halaman utama setelah status diubah
        header('Location: index.php');
        exit();
    } else {
        echo "<p style='color:red;'>Gagal mengubah status: " . $stmt->error . "</p>";
    }

    $stmt->close();
}


// edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $edit_title = trim($_POST['edit_title']);
    $edit_deadline = $_POST['edit_deadline'];
    $user_id = $_SESSION['user_id'];

    if (!empty($edit_title)) {
        $stmt = $conn->prepare("UPDATE todos SET title = ?, deadline = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssii", $edit_title, $edit_deadline, $edit_id, $user_id);

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


        // Cek apakah ada parameter hapus dalam URL dan lakukan penghapusan
if (isset($_GET['hapus'])) {
    $hapus_id = $_GET['hapus'];
    $user_id = $_SESSION['user_id']; // Mendapatkan user_id dari session

    // Query untuk menghapus todo berdasarkan ID dan user_id
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $hapus_id, $user_id);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "<p style='color:red;'>Gagal menghapus todo: " . $stmt->error . "</p>";
    }

    $stmt->close();
}


        if (!isset($_SESSION['todos'])) {
            $_SESSION['todos'] = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tugas'], $_POST['deadline'])) {
            $tugas = trim($_POST['tugas']);
            $deadline = $_POST['deadline'];
            $user_id = $_SESSION['user_id']; // ambil dari session login
            $status = 0; // belum selesai

            if (!empty($tugas)) {
                $stmt = $conn->prepare("INSERT INTO todos (user_id, title, deadline, status) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("issi", $user_id, $tugas, $deadline, $status);

                if ($stmt->execute()) {
                    header('Location: index.php');
                    exit();
                } else {
                    echo "<p style='color:red;'>Gagal menambahkan tugas: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }
        }



        // if (isset($_GET['selesai'])) {
        //     $_SESSION['todos'][$_GET['selesai']]['selesai'] = true;
        //     header('Location: index.php');
        //     exit();
        // }


        // if (isset($_GET['hapus'])) {
        //     array_splice($_SESSION['todos'], $_GET['hapus'], 1);
        //     header('Location: index.php');
        //     exit();
        // }


        // if (isset($_POST['edit_index'])) {
        //     $_SESSION['todos'][$_POST['edit_index']]['tugas'] = $_POST['edit_tugas'];
        //     $_SESSION['todos'][$_POST['edit_index']]['deadline'] = $_POST['edit_deadline'];
        //     header('Location: index.php');
        //     exit();
        // }

        $today = date('Y-m-d');
        $searchKeyword = strtolower($_GET['search'] ?? '');
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>ToDo List</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="">
            <style>
        :root {
        --blossom: #f78fb3;     /* pink */
        --bubbles: #74b9ff;     /* baby blue */
        --buttercup: #55efc4;   /* mint green */
        --dark-text: #2d3436;
        --light-bg: #fff0f6;
        }

        body {
        background: linear-gradient(135deg, var(--bubbles), var(--blossom), var(--buttercup));
        background-size: 600% 600%;
        animation: bgAnimation 15s ease infinite;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: var(--dark-text);
        }

        @keyframes bgAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
        }

        .container {
        background-color: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        h2#judul-todolist {
        color: var(--dark-text);
        font-weight: bold;
        text-shadow: 1px 1px white;
        }

        .card {
        border: 2px dashed var(--dark-text);
        border-radius: 15px;
        }

        .card.bg-success {
        background-color: var(--buttercup) !important;
        color: #2d3436 !important;
        }

        .card.bg-danger.bg-opacity-25 {
        background-color: #ffeaa7 !important;
        border-color: #d63031;
        }

        .custom-btn {
        background-color: var(--blossom) !important;
        color: white !important;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        transition: transform 0.2s;
        }

        .custom-btn:hover {
        transform: scale(1.05);
        background-color: var(--bubbles) !important;
        }

        .btn-outline-success, .btn-outline-warning, .btn-outline-danger {
        border-radius: 50px;
        font-weight: bold;
        }

        .modal-content {
        background-color: var(--light-bg);
        }

        .fade-in {
        animation: fadeIn 1s ease-in-out;
        }

        </style>


        </head>
        <body>
            
        <div class="container mt-5">

        <!-- ✅ Tempatkan alert-nya di sini -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_SESSION['success']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>



            <div class="text-end">
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
            <h2 class="text-center mb-4" id="judul-todolist">
            <i class="bi bi-journal-text"></i> ToDo List
            </h2>


            <!-- Form Pencarian -->
            <form method="GET" class="mb-3 row g-2">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control" placeholder="Cari todo..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                <button type="submit" class="btn custom-btn w-100">Cari</button>
                </div>
            </form>

            <!-- Form Tambah -->
            <form method="POST" class="row g-2 mb-4">
                <div class="col-md-8">
                    <input type="text" name="tugas" class="form-control" placeholder="Apa yang ingin kamu kerjakan?" required>
                </div>
                <div class="col-md-2">
                    <input type="date" name="deadline" class="form-control" required>
                </div>
                <div class="col-md-2">
                <button type="submit" class="btn custom-btn w-100">Tambah</button>
                

                </div>
            </form>

        <?php

 // Query untuk menampilkan todos
$query = $conn->prepare("SELECT * FROM todos WHERE user_id = ? ORDER BY created_at DESC");
$query->bind_param("i", $_SESSION['user_id']);
$query->execute();
$result = $query->get_result();

$index = 0;
while ($todo = $result->fetch_assoc()):
    if ($searchKeyword && strpos(strtolower($todo['title']), $searchKeyword) === false) continue;
    $isLate = !$todo['status'] && $todo['deadline'] < $today;
    $cardClass = $todo['status'] ? 'bg-success text-white' : ($isLate ? 'bg-danger bg-opacity-25' : 'bg-white');
?>
    <!-- Card Todo -->
    <div class="card mb-2 <?= $cardClass ?>">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <strong <?= $todo['status'] ? 'style="text-decoration: line-through;"' : '' ?>><?= htmlspecialchars($todo['title']) ?></strong><br>
                <small class="text-muted">Deadline: <?= $todo['deadline'] ?></small>
                <?php if ($isLate): ?>
                    <span class="badge bg-danger ms-2">Terlambat</span>
                <?php endif; ?>
            </div>
            <div>
                <!-- Tombol Edit dan Modal -->
<button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $todo['id'] ?>">
    ✏️
</button>

<!-- Modal Edit Todo -->
<div class="modal fade" id="editModal<?= $todo['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="edit_id" value="<?= $todo['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title<?= $todo['id'] ?>" class="form-label">Tugas</label>
                        <input type="text" name="edit_title" id="edit_title<?= $todo['id'] ?>" class="form-control" value="<?= htmlspecialchars($todo['title']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deadline<?= $todo['id'] ?>" class="form-label">Deadline</label>
                        <input type="date" name="edit_deadline" id="edit_deadline<?= $todo['id'] ?>" class="form-control" value="<?= $todo['deadline'] ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- Mark as Done Button -->
                <?php if (!$todo['status']): ?>
                    <a href="?selesai=<?= $todo['id'] ?>" class="btn btn-sm btn-outline-success">✅</a>
                <?php else: ?>
                    <span class="badge bg-success">Selesai</span>
                <?php endif; ?>
                <!-- Hapus Todo -->
                <a href="?hapus=<?= $todo['id'] ?>" class="btn btn-sm btn-outline-danger">❌</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        </body>

        </html>