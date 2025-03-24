<?php
class AuthController {
    private $db;
    private $sinhVien;
    private $auth;
    private $nganhHoc;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'models/SinhVien.php';
        require_once 'models/Auth.php';
        require_once 'models/NganhHoc.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhVien = new SinhVien($this->db);
        $this->auth = new Auth($this->db);
        $this->nganhHoc = new NganhHoc($this->db);
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
                exit();
            } else {
                // Đăng nhập thất bại
                $error = "Mã số sinh viên không tồn tại";
                include 'views/auth/login.php';
            }
        } else {
            include 'views/auth/login.php';
        }
    }

    // Hiển thị form đăng ký
    public function register() {
        $nganhs = $this->nganhHoc->getAll()->fetchAll(PDO::FETCH_ASSOC);
        include 'views/auth/register.php';
    }

    // Xử lý đăng ký
    public function saveRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = $_POST['MaSV'];
            $hoTen = $_POST['HoTen'];
            $gioiTinh = $_POST['GioiTinh'];
            $ngaySinh = $_POST['NgaySinh'];
            $maNganh = $_POST['MaNganh'];
            
            // Kiểm tra mã sinh viên đã tồn tại chưa
            if ($this->auth->checkUser($maSV)) {
                $error = "Mã số sinh viên đã tồn tại";
                $nganhs = $this->nganhHoc->getAll()->fetchAll(PDO::FETCH_ASSOC);
                include 'views/auth/register.php';
                return;
            }
            
            // Đăng ký người dùng mới
            if ($this->auth->register($maSV, $hoTen, $gioiTinh, $ngaySinh, $maNganh)) {
                // Đăng ký thành công, đăng nhập luôn
                $_SESSION['MaSV'] = $maSV;
                $_SESSION['HoTen'] = $hoTen;
                
                // Chuyển hướng đến trang chủ
                header("Location: index.php?controller=HocPhan&action=index");
                exit();
            } else {
                $error = "Đăng ký thất bại, vui lòng thử lại";
                $nganhs = $this->nganhHoc->getAll()->fetchAll(PDO::FETCH_ASSOC);
                include 'views/auth/register.php';
            }
        } else {
            header("Location: index.php?controller=Auth&action=register");
            exit();
        }
    }

    // Đăng xuất
    public function logout() {
        // Xóa thông tin đăng nhập khỏi session
        unset($_SESSION['MaSV']);
        unset($_SESSION['HoTen']);
        
        // Hủy session
        session_destroy();
        
        header("Location: index.php?controller=Auth&action=login");
        exit();
    }
}
?>