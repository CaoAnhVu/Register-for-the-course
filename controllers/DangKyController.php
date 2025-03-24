<?php
class DangKyController {
    private $db;
    private $dangKy;
    private $sinhVien;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'models/DangKy.php';
        require_once 'models/SinhVien.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->dangKy = new DangKy($this->db);
        $this->sinhVien = new SinhVien($this->db);
    }

    // Hiển thị đăng ký của sinh viên
    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $maSV = $_SESSION['MaSV'];
        $this->sinhVien->MaSV = $maSV;
        $this->sinhVien->getById();
        
        $this->dangKy->MaSV = $maSV;
        $registeredCourses = $this->dangKy->getRegisteredCourses();
        $courses = $registeredCourses->fetchAll(PDO::FETCH_ASSOC);
        
        // Đếm tổng số tín chỉ
        $totalCredits = 0;
        foreach ($courses as $course) {
            $totalCredits += $course['SoTinChi'];
        }
        
        include 'views/dangky/index.php';
    }

    // Xóa một học phần khỏi đăng ký
    public function remove($hpId) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $maSV = $_SESSION['MaSV'];
        $this->dangKy->MaSV = $maSV;
        $registrations = $this->dangKy->getByMaSV();
        $registration = $registrations->fetch(PDO::FETCH_ASSOC);
        
        if ($registration) {
            $this->dangKy->MaDK = $registration['MaDK'];
            $this->dangKy->removeDetail($hpId);
        }
        
        header("Location: index.php?controller=DangKy&action=index");
    }

    // Xóa toàn bộ đăng ký
    public function deleteAll() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $maSV = $_SESSION['MaSV'];
        $this->dangKy->MaSV = $maSV;
        $registrations = $this->dangKy->getByMaSV();
        $registration = $registrations->fetch(PDO::FETCH_ASSOC);
        
        if ($registration) {
            $this->dangKy->MaDK = $registration['MaDK'];
            $this->dangKy->delete();
        }
        
        header("Location: index.php?controller=HocPhan&action=index");
    }

    // Lưu đăng ký và hiển thị thông tin xác nhận
    public function save() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $maSV = $_SESSION['MaSV'];
        $this->sinhVien->MaSV = $maSV;
        $this->sinhVien->getById();
        
        $this->dangKy->MaSV = $maSV;
        $registeredCourses = $this->dangKy->getRegisteredCourses();
        $courses = $registeredCourses->fetchAll(PDO::FETCH_ASSOC);
        
        // Đếm tổng số tín chỉ
        $totalCredits = 0;
        foreach ($courses as $course) {
            $totalCredits += $course['SoTinChi'];
        }
        
        include 'views/dangky/success.php';
    }

    // Hiển thị trang xác nhận đăng ký
    public function confirm() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit;
        }
        
        $maSV = $_SESSION['MaSV'];
        $this->sinhVien->MaSV = $maSV;
        $this->sinhVien->getById();
        
        $this->dangKy->MaSV = $maSV;
        $registeredCourses = $this->dangKy->getRegisteredCourses();
        $courses = $registeredCourses->fetchAll(PDO::FETCH_ASSOC);
        
        // Đếm tổng số tín chỉ
        $totalCredits = 0;
        foreach ($courses as $course) {
            $totalCredits += $course['SoTinChi'];
        }
        
        include 'views/dangky/confirm.php';
    }

    // Lưu xác nhận đăng ký
    public function saveConfirm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
            // Kiểm tra đăng nhập
            if (!isset($_SESSION['MaSV'])) {
                header("Location: index.php?controller=Auth&action=login");
                exit;
            }
            
            $maSV = $_SESSION['MaSV'];
            
            // Tạo đăng ký mới nếu chưa có (thực tế đã tạo khi thêm khóa học)
            $this->dangKy->MaSV = $maSV;
            $this->dangKy->NgayDK = date('Y-m-d');
            
            // Lưu vào session thông tin đăng ký đã xác nhận
            $_SESSION['DangKyConfirmed'] = true;
            $_SESSION['NgayDK'] = date('Y-m-d');
            
            // Chuyển hướng đến trang thông báo thành công
            header("Location: index.php?controller=DangKy&action=success");
            exit;
        }
    }

    // Hiển thị trang thành công
    public function success() {
        // Kiểm tra đã xác nhận chưa
        if (!isset($_SESSION['DangKyConfirmed']) || $_SESSION['DangKyConfirmed'] !== true) {
            header("Location: index.php?controller=DangKy&action=index");
            exit;
        }
        
        $maSV = $_SESSION['MaSV'];
        $this->sinhVien->MaSV = $maSV;
        $this->sinhVien->getById();
        
        $this->dangKy->MaSV = $maSV;
        $registeredCourses = $this->dangKy->getRegisteredCourses();
        $courses = $registeredCourses->fetchAll(PDO::FETCH_ASSOC);
        
        // Đếm tổng số tín chỉ
        $totalCredits = 0;
        foreach ($courses as $course) {
            $totalCredits += $course['SoTinChi'];
        }
        
        include 'views/dangky/success.php';
    }
}
?>