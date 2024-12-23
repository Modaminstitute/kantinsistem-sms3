<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'class.php';

// Membuat objek database dan user
$database = new Database();
$user = new User($database);
$order = new Order($database);

// Mengambil daftar pesanan user
$user_id = $_SESSION['user_id'];
$pemesanan = $order->getOrdersByUserId($user_id);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemesanan</title>
    <link rel="stylesheet" href="pemesanan.css"> <!-- Menghubungkan ke file CSS eksternal -->
</head>

<body>
    <header>
        <h1>Daftar Pemesanan Anda</h1>
    </header>

    <div class="container">
        <?php
            if ($pemesanan) {
                echo "<table>";
                echo "<tr>
                        <th>ID</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>";

                foreach ($pemesanan as $order) {
                    echo "<tr>
                            <td>{$order['id']}</td>
                            <td>{$order['menu_nama']}</td>
                            <td>{$order['jumlah']}</td>
                            <td>Rp " . number_format($order['total_harga'], 0, ',', '.') . "</td>
                            <td>{$order['status']}</td>
                            <td>{$order['tanggal_pemesanan']}</td>
                            <td class='action-links'>
    <a href='edit_pesanan.php?id={$order['id']}' class='button edit-button'>Edit</a>
    <a href='hapus_pesanan.php?id={$order['id']}' class='button delete-button' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\")'>Hapus</a>
</td>

                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='no-order'>Tidak ada pesanan.</p>";
            }
        ?>
        <p class="actions">
            <a href="dashboard.php" class="button">Kembali ke Dashboard</a>
        </p>
    </div>

    <footer>
        <p>Copyright &copy; 2024 Kantin Pradita</p>
    </footer>
</body>

</html>