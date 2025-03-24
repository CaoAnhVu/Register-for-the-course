<?php
class SinhVienController {
    private $db;
    private $sinhVien;
    private $nganhHoc;

    public function __construct() {
        require_once 'config/database.php';
        require_once 'models/SinhVien.php';
        require_once 'models/NganhHoc.php';
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhVien = new SinhVien($this->db);
        $this->nganhHoc = new NganhHoc($this->db);
    }

    // Hiển thị danh sách sinh viên
    public function index() {
        $result = $this->sinhVien->getAll();
        $sinhViens = $result->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/sinhvien/index.php';
    }

    // Hiển thị form thêm sinh viên
    public function create() {
        $nganhs = $this->nganhHoc->getAll()->fetchAll(PDO::FETCH_ASSOC);
        include 'views/sinhvien/create.php';
    }

    // Lưu sinh viên mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->sinhVien->MaSV = $_POST['MaSV'];
            $this->sinhVien->HoTen = $_POST['HoTen'];
            $this->sinhVien->GioiTinh = $_POST['GioiTinh'];
            $this->sinhVien->NgaySinh = $_POST['NgaySinh'];
            $this->sinhVien->MaNganh = $_POST['MaNganh'];
            
            // Xử lý upload hình
            if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] === 0) {
                $target_dir = "Content/images/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $target_file = $target_dir . basename($_FILES['Hinh']['name']);
                if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $target_file)) {
                    $this->sinhVien->Hinh = $target_file;
                }
            }
            
            if ($this->sinhVien->create()) {
                header("Location: index.php?controller=SinhVien&action=index");
            } else {
                echo "Thêm sinh viên thất bại";
            }
        }
    }

    // Hiển thị form chỉnh sửa
    public function edit($id) {
        $this->sinhVien->MaSV = $id;
        $this->sinhVien->getById();
        $nganhs = $this->nganhHoc->getAll()->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/sinhvien/edit.php';
    }

    // Cập nhật sinh viên
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->sinhVien->MaSV = $_POST['MaSV'];
            $this->sinhVien->HoTen = $_POST['HoTen'];
            $this->sinhVien->GioiTinh = $_POST['GioiTinh'];
            $this->sinhVien->NgaySinh = $_POST['NgaySinh'];
            $this->sinhVien->MaNganh = $_POST['MaNganh'];
            
            // Kiểm tra nếu có hình ảnh mới được upload
            if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] === 0) {
                $target_dir = "Content/images/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
                $target_file = $target_dir . basename($_FILES['Hinh']['name']);
                if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $target_file)) {
                    $this->sinhVien->Hinh = $target_file;
                }
            } else {
                // Giữ hình ảnh cũ
                $this->sinhVien->MaSV = $_POST['MaSV'];
                $this->sinhVien->getById();
            }
            
            if ($this->sinhVien->update()) {
                header("Location: index.php?controller=SinhVien&action=index");
            } else {
                echo "Cập nhật sinh viên thất bại";
            }
        }
    }

    // Hiển thị trang xác nhận xóa
    public function delete($id) {
        $this->sinhVien->MaSV = $id;
        $this->sinhVien->getById();
        
        include 'views/sinhvien/delete.php';
    }

    // Xóa sinh viên
    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->sinhVien->MaSV = $_POST['MaSV'];
            
            if ($this->sinhVien->delete()) {
                header("Location: index.php?controller=SinhVien&action=index");
            } else {
                echo "Xóa sinh viên thất bại";
            }
        }
    }

    // Hiển thị thông tin chi tiết
    public function show($id) {
        $this->sinhVien->MaSV = $id;
        $this->sinhVien->getById();
        
        include 'views/sinhvien/show.php';
    }
}
?>