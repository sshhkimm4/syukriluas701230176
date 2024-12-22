<?php
session_start();
include 'koneksi_admin.php'; // Koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

// Ambil ID pengguna yang ingin diedit
if (isset($_GET['id'])) {
    $id_pengguna = $_GET['id'];

    // Ambil data pengguna dari database berdasarkan ID
    $query = "SELECT * FROM pengguna WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// Proses update data pengguna
if (isset($_POST['update'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $foto_profil = $_FILES['foto_profil']['name'];
    $target_dir = "uploads/";

    // Upload foto jika ada
    if ($foto_profil) {
        $target_file = $target_dir . basename($foto_profil);
        move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file);
    } else {
        $foto_profil = $user['foto_profil']; // jika tidak mengubah foto, gunakan foto lama
    }

    // Update data pengguna ke database
    $update_query = "UPDATE pengguna SET nama_lengkap = ?, nomor_telepon = ?, alamat = ?, tanggal_lahir = ?, jenis_kelamin = ?, foto_profil = ? WHERE id_pengguna = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $nama_lengkap, $nomor_telepon, $alamat, $tanggal_lahir, $jenis_kelamin, $foto_profil, $id_pengguna);
    $stmt->execute();

    // Redirect ke dashboard setelah update
    header("Location: dashboard_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pengguna</title>
    <style>
        /* CSS Styling */
        /* CSS Styling */
body {
    font-family: Arial, sans-serif;
    background: #283048;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #859398, #283048);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #859398, #283048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200vh;
}

.container {
    width: 50%;
    background: linear-gradient( 135deg, #81FBB8 10%, #28C76F 100%);
    padding: 50px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

h2 {
    text-align: center;
    color:rgb(255, 255, 255);
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.back-btn {
    text-decoration: none;
    color: #007bff;
    margin-top: 10px;
    display: block;
    text-align: center;
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Data Pengguna</h2>

        <form action="edit_pengguna.php?id=<?php echo $user['id_pengguna']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $user['nama_lengkap']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon:</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon" value="<?php echo $user['nomor_telepon']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo $user['alamat']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $user['tanggal_lahir']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if($user['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if($user['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="foto_profil">Foto Profil (Opsional):</label>
                <input type="file" id="foto_profil" name="foto_profil">
                <img src="uploads/<?php echo $user['foto_profil']; ?>" alt="Foto Profil" width="100" style="margin-top: 10px;">
            </div>

            <button type="submit" name="update">Update Data</button>
        </form>

        <a href="dashboard_admin.php" class="back-btn">Kembali ke Dashboard</a>
    </div>

</body>
</html>
