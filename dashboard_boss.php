<?php
session_start();
include 'koneksi_boss.php'; // Koneksi ke database

// Cek apakah ketua sudah login
if (!isset($_SESSION['id_boss'])) {
    header("Location: index.php");
    exit();
}

// Ambil data pelanggan dari database
$query_pelanggan = "SELECT * FROM pengguna";
$result_pelanggan = $conn->query($query_pelanggan);

// Ambil data admin dari database
$query_admin = "SELECT * FROM admin";
$result_admin = $conn->query($query_admin);

// Fungsi untuk mengunduh data dalam format CSV
if (isset($_GET['download'])) {
    $filename = "data_pelanggan_" . date('Ymd') . ".csv";
    $output = fopen("php://output", 'w');
    
    // Header CSV
    fputcsv($output, ['ID', 'Nama Lengkap', 'Email', 'Nomor Telepon', 'Alamat', 'Tanggal Lahir', 'Jenis Kelamin', 'Foto Profil', 'Status Aktif']);
    
    // Fetch data pelanggan dan tulis ke file CSV
    while ($row = $result_pelanggan->fetch_assoc()) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ketua - Data Pengguna dan Admin</title>
    <style>
        /* Style dasar yang sama */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-download {
            background-color: #007bff;
            text-decoration: none;
            padding: 8px 16px;
            color: white;
            border-radius: 5px;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Dashboard Ketua</h2>

        <div>
            <h3>Data Pelanggan</h3>
            <a href="?download=true" class="btn-download">Download Data Pelanggan</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Foto Profil</th>
                        <th>Status Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_pelanggan->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id_pengguna']; ?></td>
                            <td><?php echo $row['nama_lengkap']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['nomor_telepon']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['tanggal_lahir']; ?></td>
                            <td><?php echo $row['jenis_kelamin']; ?></td>
                            <td><img src="pelanggan/uploads<?php echo $row['foto_profil']; ?>" width="50" height="50" style="border-radius: 50%"></td>
                            <td><?php echo $row['status_aktif']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div>
            <h3>Data Admin</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Admin</th>
                        <th>Username</th>
                        <th>Level Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_admin->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id_admin']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['level_akses']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
