<?php
class HocPhanController {
    private $db;
    private $hocPhan;
    private $dangKy;
    private $sinhVien;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'models/HocPhan.php';
        require_once 'models/DangKy.php';
        require_once 'models/SinhVien.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->hocPhan = new HocPhan($this->db);
        $this->dangKy = new DangKy($this->db);
        $this->sinhVien = new SinhVien($this->db);
    }

    // Hiển thị danh sách học phần
    public function index() {
        $result = $this->hocPhan->getAll();
        $hocPhans = [];
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $maHP = $row['MaHP'];
            $row['SoLuongDuKien'] = $this->hocPhan->getSoLuongDuKien($maHP);
            $row['SoLuongDaDangKy'] = $this->hocPhan->getSoLuongDaDangKy($maHP);
            $hocPhans[] = $row;
        }
        
        include 'views/hocphan/index.php';
    }

// Đăng ký học phần
public function register($hpId) {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['MaSV'])) {
        header("Location: index.php?controller=Auth&action=login");
        exit;
    }
    
    try {
        $maSV = $_SESSION['MaSV'];
        $this->dangKy->MaSV = $maSV;
        $this->dangKy->NgayDK = date('Y-m-d'); // Đặt ngày hiện tại
        
        // Sử dụng phương thức mới để đăng ký học phần
        if ($this->dangKy->registerCourse($hpId)) {
            $_SESSION['success_message'] = "Đăng ký học phần thành công!";
        } else {
            $_SESSION['error_message'] = "Học phần đã được đăng ký hoặc có lỗi xảy ra!";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Lỗi: " . $e->getMessage();
    }
    
    // Chuyển hướng đến trang đăng ký học phần
    header("Location: index.php?controller=DangKy&action=index");
    exit();
}

    // Hiển thị thông tin chi tiết học phần
    public function show($id) {
        $this->hocPhan->MaHP = $id;
        $this->hocPhan->getById();
        
        include 'views/hocphan/show.php';
    }

    // Cập nhật số lượng dự kiến học viên
    public function updateSoLuong() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maHP = $_POST['MaHP'];
            $soLuong = $_POST['SoLuongDuKien'];
            
            $this->hocPhan->MaHP = $maHP;
            if ($this->hocPhan->getById()) {
                $this->hocPhan->updateSoLuongDuKien($maHP, $soLuong);
                header("Location: index.php?controller=HocPhan&action=index");
            } else {
                echo "Học phần không tồn tại!";
            }
        }
    }
}
?>