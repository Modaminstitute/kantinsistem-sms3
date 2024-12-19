<?php
session_start();
require_once 'class.php';
$database = new Database();
$user = new User($database);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user->deleteOrder($id); // Fungsi buat di class.php
    header("Location: pemesanan.php");
    exit();
} else {
    die("ID pesanan tidak valid.");
}
?>