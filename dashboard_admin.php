<?php
session_start();
include 'koneksi_admin.php'; // Koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

// Proses hapus data petani
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query_hapus = "DELETE FROM pengguna WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query_hapus);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard_admin.php");
    exit();
}

// Ambil data petani dari database
$query = "SELECT * FROM pengguna";
$result = $conn->query($query);

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Pengguna</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #283048;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #859398, #283048);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #859398, #283048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color: #333;
        }

        header {
            background-color:rgb(17, 162, 80);
            color: #fff;
            padding: 15px 0;
            text-align: center;
            font-size: 1.5rem;
        }

        nav {
            background: #007bff;
            padding: 10px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            margin: 30px auto;
            width: 90%;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color:rgb(67, 212, 41);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(90, 212, 3, 0.1);
        }

        th, td {
            text-align: center;
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
            transition: background 0.3s;
        }

        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .action-btn {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.9rem;
            margin: 2px;
        }

        .edit-btn {
            background-color: #28a745;
            color: #fff;
        }

        .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }

        .action-btn:hover {
            opacity: 0.9;
        }

        .logout-btn {
            background: #dc3545;
            color: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
            }

            td {
                text-align: left;
                position: relative;
                padding-left: 50%;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
            }

            th {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        Dashboard Admin - Data Pengguna
    </header>
    <nav>
        <div>Selamat Datang, <strong><?php echo $_SESSION['username']; ?></strong></div>
        <div>
            <a href="?logout=true" class="logout-btn">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h2>Daftar Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td data-label="ID"><?php echo $row['id_pengguna']; ?></td>
                        <td data-label="Nama"><?php echo $row['nama_lengkap']; ?></td>
                        <td data-label="No HP"><?php echo $row['nomor_telepon']; ?></td>
                        <td data-label="Alamat"><?php echo $row['alamat']; ?></td>
                        <td data-label="Tanggal Lahir"><?php echo $row['tanggal_lahir']; ?></td>
                        <td data-label="Jenis Kelamin"><?php echo $row['jenis_kelamin']; ?></td>
                        <td data-label="Foto">
                            <img src="uploads<?php echo $row['foto_profil']; ?>" alt="Foto Pengguna">
                        </td>
                        <td data-label="Aksi">
                            <a href="edit_pengguna.php?id=<?php echo $row['id_pengguna']; ?>" class="action-btn edit-btn">Edit</a>
                            <a href="?hapus=<?php echo $row['id_pengguna']; ?>" class="action-btn delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>


<?php
// Tutup koneksi database
mysqli_close($conn);
?>
