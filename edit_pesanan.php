<?php
session_start();
require_once 'class.php';
$database = new Database();
$orderManager = new Order($database);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $order = $orderManager->getOrderById($id);
    if (!$order) {
        die("Pesanan tidak ditemukan!");
    }
} else {
    die("ID pesanan tidak valid.");
}

if (isset($_POST['update'])) {
    $jumlah = $_POST['jumlah'];
    $total_harga = $jumlah * $order['harga'];
    $orderManager->updateOrder($id, $jumlah, $total_harga);
    header("Location: pemesanan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>
    <link rel="stylesheet" href="edit_pesanan.css">
</head>

<body>
    <div class="container">
        <h1>Edit Pesanan</h1>
        <form method="POST" class="edit-form">
            <div class="form-group">
                <label>Menu:</label>
                <input type="text" value="<?php echo htmlspecialchars($order['menu_nama']); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Jumlah:</label>
                <input type="number" name="jumlah" value="<?php echo $order['jumlah']; ?>" min="1" required>
            </div>
            <button type="submit" name="update">Update Pesanan</button>
        </form>
        <a href="pemesanan.php" class="back-link">Kembali ke Daftar Pesanan</a>
    </div>
</body>

</html>