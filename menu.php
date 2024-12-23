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
$menuManager = new Menu($database);
$order = new Order($database);

// Mendapatkan nama tenant yang dipilih dari query parameter
$tenant = isset($_GET['tenant']) ? $_GET['tenant'] : '';

// Mengambil menu berdasarkan tenant dari database
$menus = $menuManager->getMenuByTenant($tenant);

// Memproses pemesanan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'])) {
    $menu_id = $_POST['menu_id'];
    $jumlah = $_POST['jumlah'];
    $user_id = $_SESSION['user_id']; // Asumsi user_id disimpan di session

    // Mendapatkan harga menu
    $menu = $menuManager->getMenuById($menu_id);
    $total_harga = $menu['harga'] * $jumlah;

    // Simpan pemesanan ke database
    $order->orderFood($user_id, $menu_id, $jumlah, $total_harga);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Tenant: <?php echo htmlspecialchars($tenant); ?></title>
    <link rel="stylesheet" href="menu.css"> <!-- Menghubungkan ke file CSS eksternal -->
</head>

<body>
    <header>
        <div class="container">
            <h1>Menu dari Tenant: <?php echo htmlspecialchars($tenant); ?></h1>
        </div>
    </header>

    <div class="container">
        <div class="menu-list">
            <?php if ($menus): ?>
            <?php foreach ($menus as $menu): ?>
            <div class="menu-item">
                <img src="images/<?php echo htmlspecialchars($menu['gambar']); ?>"
                    alt="<?php echo htmlspecialchars($menu['nama']); ?>" class="menu-image">
                <h3><?php echo htmlspecialchars($menu['nama']); ?></h3>
                <p>Menu lezat dari tenant <?php echo htmlspecialchars($tenant); ?></p>
                <p class="price">Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></p>

                <!-- Formulir Pemesanan -->
                <form method="POST" action="menu.php?tenant=<?php echo urlencode($tenant); ?>">
                    <input type="hidden" name="menu_id" value="<?php echo $menu['id']; ?>">
                    <label for="jumlah_<?php echo $menu['id']; ?>">Jumlah:</label>
                    <input type="number" id="jumlah_<?php echo $menu['id']; ?>" name="jumlah" value="1" min="1"
                        required>
                    <button type="submit">Pesan</button>
                </form>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>Menu tidak ditemukan untuk tenant ini.</p>
            <?php endif; ?>
        </div>
        <p><a href="dashboard.php" class="btn-nav">Kembali ke Dashboard</a></p>
    </div>

    <footer>
        <p>Copyright &copy; 2024 Kantin Pradita</p>
    </footer>
</body>

</html>