<?php
session_start();
require_once 'class.php';
$database = new Database();
$order = new Order($database);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $order->deleteOrder($id); // Fungsi buat di class.php
    header("Location: pemesanan.php");
    exit();
} else {
    die("ID pesanan tidak valid.");
}
?>