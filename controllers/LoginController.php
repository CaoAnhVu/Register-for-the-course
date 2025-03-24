<?php
class LoginController {
    private $db;
    private $sinhVien;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'models/SinhVien.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhVien = new SinhVien($this->db);
    }

    // Hiển thị form đăng nhập
    public function login() {
        include 'views/auth/login.php';
    }

    // Xử lý đăng nhập
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['MaSV'];
            
            $this->sinhVien->MaSV = $maSV;
            if ($this->sinhVien->getById()) {
                // Lưu thông tin đăng nhập vào session
                $_SESSION['MaSV'] = $maSV;
                $_SESSION['HoTen'] = $this->sinhVien->HoTen;
                
                header("Location: index.php?controller=HocPhan&action=index");
            } else {
                // Đăng nhập thất bại
                $error = "Mã số sinh viên không tồn tại";
                include 'views/auth/login.php';
            }
        }
    }

    // Đăng xuất
    public function logout() {
        // Xóa thông tin đăng nhập khỏi session
        unset($_SESSION['MaSV']);
        unset($_SESSION['HoTen']);
        
        header("Location: index.php?controller=Auth&action=login");
    }
}
?>