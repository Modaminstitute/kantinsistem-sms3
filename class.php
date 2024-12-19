<?php

// Class Database untuk koneksi ke database
class Database {
    private $host = 'localhost';
    private $username = 'root';  // Ganti dengan username database Anda
    private $password = '';      // Ganti dengan password database Anda
    private $dbname = 'kantin_pradita_v4';
    private $db;

    // Fungsi untuk membuat koneksi ke database
    public function getConnection() {
        if (!$this->db) {
            try {
                $this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Koneksi database gagal: " . $e->getMessage());
            }
        }
        return $this->db;
    }
}

// Class User untuk registrasi dan login
class User {
    private $db;

    // Konstruktor menerima objek Database untuk koneksi
    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }
    
    public function getOrderById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, m.nama AS menu_nama, m.harga
                FROM pemesanan p
                JOIN menus m ON p.menu_id = m.id
                WHERE p.id = :id
            ");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    
    public function updateOrder($id, $jumlah, $total_harga) {
        try {
            $stmt = $this->db->prepare("
                UPDATE pemesanan 
                SET jumlah = :jumlah, total_harga = :total_harga 
                WHERE id = :id
            ");
            $stmt->bindParam(':jumlah', $jumlah);
            $stmt->bindParam(':total_harga', $total_harga);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Gagal mengupdate pesanan: " . $e->getMessage());
        }
    }
    
    public function deleteOrder($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM pemesanan WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Gagal menghapus pesanan: " . $e->getMessage());
        }
    }
    
    public function getOrdersByUserId($user_id) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.id, m.nama AS menu_nama, p.jumlah, p.total_harga, p.status, p.tanggal_pemesanan
                FROM pemesanan p
                JOIN menus m ON p.menu_id = m.id
                WHERE p.user_id = :user_id
                ORDER BY p.tanggal_pemesanan DESC
            ");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Gagal mendapatkan daftar pesanan: " . $e->getMessage());
        }
    }
    
    // Fungsi untuk registrasi user
    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // Fungsi untuk login user
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Login sukses
        }
        return false; // Login gagal
    }

    // Fungsi untuk memesan makanan
    public function orderFood($user_id, $menu_id, $jumlah, $total_harga) {
        // Insert data pemesanan ke database
        $sql = "INSERT INTO pemesanan (user_id, menu_id, jumlah, total_harga) 
                VALUES (:user_id, :menu_id, :jumlah, :total_harga)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':menu_id', $menu_id);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':total_harga', $total_harga);
        $stmt->execute();
    }

    // Fungsi untuk mendapatkan menu berdasarkan ID
    public function getMenuById($menu_id) {
        $sql = "SELECT * FROM menus WHERE id = :menu_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':menu_id', $menu_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mengambil tenant berdasarkan ID
    public function getTenantById($id) {
        $sql = "SELECT * FROM tenant WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

// Fungsi untuk mengambil menu berdasarkan tenant
    public function getMenuByTenant($tenant) {
        $sql = "SELECT menus.id, menus.nama, menus.harga, menus.gambar 
                FROM menus 
                JOIN tenant ON menus.tenant_id = tenant.id 
                WHERE tenant.nama = :tenant";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':tenant', $tenant);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  
}
?>
