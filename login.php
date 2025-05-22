<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>login</title>
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


<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="process_login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <div class="register-link">
                            Belum punya akun? <a href="daftar.php">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script toggle password -->
    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            toggleIcon.classList.toggle("bi-eye");
            toggleIcon.classList.toggle("bi-eye-slash");
        });
    </script>

</body>

 </html> 