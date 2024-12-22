<?php
include 'koneksi_petani.php'; // Menghubungkan ke file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status_aktif = 1; // Default aktif

    // Upload Foto Profil
    $foto_profil = $_FILES['foto_profil']['name'];
    $target_dir = "uploads";  // Folder untuk menyimpan foto
    $target_file = $target_dir . basename($foto_profil);

    // Pindahkan file foto ke folder uploads
    if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
        // Foto berhasil di-upload
    } else {
        echo "Gagal meng-upload foto.";
    }

    // Simpan data ke database
    $password = md5($_POST['password']); // Hashing password dengan MD5
    $sql = "INSERT INTO pengguna (nama_lengkap, email, nomor_telepon, alamat, tanggal_lahir, jenis_kelamin, foto_profil, status_aktif, password) 
            VALUES ('$nama_lengkap', '$email', '$nomor_telepon', '$alamat', '$tanggal_lahir', '$jenis_kelamin', '$foto_profil', '$status_aktif', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Pengguna</title>
    <style>
        /* CSS untuk tampilan form registrasi */
        body {
            font-family: 'Arial', sans-serif;
            background: #4776E6;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #8E54E9, #4776E6);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #8E54E9, #4776E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="file"], select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            color: #28a745;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Registrasi Pengguna</h2>
        <form action="registrasi.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="nomor_telepon" placeholder="Nomor Telepon" required>
            <input type="text" name="alamat" placeholder="Alamat" required>
            <input type="date" name="tanggal_lahir" required>
            <select name="jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <input type="file" name="foto_profil" accept="image/*" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Daftar">
        </form>
        <div class="footer">
            <p>Sudah punya akun? <a href="index.php">Login Sekarang</a></p>
        </div>
    </div>
</body>
</html>
