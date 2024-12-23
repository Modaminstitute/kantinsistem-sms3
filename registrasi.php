<?php
include('class.php');

// Membuat objek Database dan User untuk registrasi
$database = new Database();
$user = new User($database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->register($username, $password)) {
        echo "<p>Registrasi berhasil! <a href='index.php'>Login di sini</a></p>";
    } else {
        echo "<p>Registrasi gagal. Silakan coba lagi.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="registrasi.css">
</head>

<body>
    <div class="register-container">
        <div class="register-box">
            <h1>Registrasi</h1>
            <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password"
                        required>
                </div>
                <button type="submit" class="btn">Registrasi</button>
                <p class="login-link">Sudah punya akun? <a href="index.php">Login di sini</a></p>
            </form>
        </div>
    </div>
</body>

</html>