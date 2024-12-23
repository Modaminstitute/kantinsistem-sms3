<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include('class.php');

// Membuat objek Database dan User
$database = new Database();
$tenant = new Tenant($database);

// Mengambil daftar tenant dari database
$sql = "SELECT * FROM tenant";
$stmt = $database->getConnection()->prepare($sql);
$stmt->execute();
$tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kantin</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Silakan pilih tenant untuk melihat menu makanan</p>
        </div>
    </header>

    <main class="container">
        <h2>Daftar Tenant Kantin</h2>
        <div class="tenant-list">
            <?php foreach ($tenants as $tenant) : ?>
            <div class="tenant-card">
                <img src="https://maps.app.goo.gl/eXfXS2puJyJ6XwPv5" alt="Tenant Image" class="tenant-img">
                <h3><?php echo htmlspecialchars($tenant['nama']); ?></h3>
                <a href="menu.php?tenant=<?php echo urlencode($tenant['nama']); ?>" class="btn">Lihat Menu</a>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <div class="container text-center">
        <a href="pemesanan.php" class="btn-primary">Lihat Daftar Pesanan Anda</a>
    </div>

    <div>
        <a href="logout.php">Logout</a>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Kantin Pradita. Semua Hak Dilindungi.</p>
    </footer>
</body>

</html>