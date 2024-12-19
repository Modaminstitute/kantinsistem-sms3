<?php
session_start();
include('class.php');

// Membuat objek Database dan User untuk login
$database = new Database();
$user = new User($database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_data = $user->login($username, $password);

    if ($user_data) {
        // Simpan user_id dan username ke dalam session
        $_SESSION['user_id'] = $user_data['id']; // Menyimpan ID pengguna
        $_SESSION['username'] = $user_data['username'];
        header('Location: dashboard.php'); // Redirect ke dashboard
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kantin Pradita</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
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
                <button type="submit" class="btn">Login</button>
                <p class="register-link">Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
            </form>
        </div>
    </div>
</body>

</html>