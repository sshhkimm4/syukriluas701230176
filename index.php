<?php
include 'koneksi_petani.php'; // Menghubungkan ke file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data login dari form
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hashing password

    // Query untuk mengecek pengguna
    $sql = "SELECT * FROM pengguna WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika login berhasil, arahkan ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $error_message = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna</title>
    <style>
        /* CSS untuk tampilan login */
        body {
            font-family: Arial, sans-serif;
            background-color: #6eff00;
            background-image: linear-gradient(180deg, #6eff00 0%, #ffffff 50%, #ffffff 100%);
            margin: 0;
            padding: 0;
        }
        .welcome {
            text-align: center;
            margin: 50px 0;
        }
        .logo {
            display: block;
            margin: 0 auto;
            width: 150px; /* Ubah ukuran logo sesuai kebutuhan */
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            background: #fff;
            padding: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Tampilan Awal -->
    <div class="welcome">
        <img src="logo.png" alt="Logo Tata Tani" class="logo">
        <h1>Selamat Datang di Web Tata Tani</h1>
    </div>

    <!-- Form Login -->
    <div class="container">
        <h2>Login Pengguna</h2>
        <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
        <form action="index.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
        <p class="footer">Belum punya akun? <a href="registrasi.php">Daftar Sekarang</a></p>
    </div>
</body>
</html>
