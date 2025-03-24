<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "DKHPSINHVIEN";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Tạo database nếu chưa tồn tại
            $this->conn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->conn->exec("USE `" . $this->db_name . "`");
            
            // Tạo các bảng trong database
            $this->createTables();
            
            return $this->conn;
        } catch(PDOException $exception) {
            echo "Lỗi kết nối: " . $exception->getMessage();
            return null;
        }
    }

    private function createTables() {
        try {
            // Tạo bảng NganhHoc
            $this->conn->exec("CREATE TABLE IF NOT EXISTS NganhHoc (
                MaNganh char(4) PRIMARY KEY,
                TenNganh nvarchar(30)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Tạo bảng SinhVien
            $this->conn->exec("CREATE TABLE IF NOT EXISTS SinhVien (
                MaSV char(10) PRIMARY KEY,
                HoTen nvarchar(50) NOT NULL,
                GioiTinh char(5),
                NgaySinh date,
                Hinh varchar(50),
                MaNganh char(4) REFERENCES NganhHoc(MaNganh)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Tạo bảng HocPhan
            $this->conn->exec("CREATE TABLE IF NOT EXISTS HocPhan (
                MaHP char(6) PRIMARY KEY,
                TenHP nvarchar(30) NOT NULL,
                SoTinChi int
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Tạo bảng DangKy
            $this->conn->exec("CREATE TABLE IF NOT EXISTS DangKy (
                MaDK int AUTO_INCREMENT PRIMARY KEY,
                NgayDK date,
                MaSV char(10),
                FOREIGN KEY (MaSV) REFERENCES SinhVien(MaSV)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // Tạo bảng ChiTietDangKy
            $this->conn->exec("CREATE TABLE IF NOT EXISTS ChiTietDangKy (
                MaDK int REFERENCES DangKy(MaDK),
                MaHP char(6) REFERENCES HocPhan(MaHP),
                PRIMARY KEY(MaDK, MaHP)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Thêm dữ liệu mẫu
            $this->insertSampleData();
        } catch(PDOException $exception) {
            echo "Lỗi tạo bảng: " . $exception->getMessage();
        }
    }

    private function insertSampleData() {
        try {
            // Kiểm tra xem đã có dữ liệu chưa
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM NganhHoc");
            $stmt->execute();
            if ($stmt->fetchColumn() == 0) {
                // Thêm dữ liệu mẫu NganhHoc
                $this->conn->exec("INSERT INTO NganhHoc (MaNganh, TenNganh) VALUES 
                ('CNTT', 'Công nghệ thông tin'),
                ('QTKD', 'Quản trị kinh doanh'),
                ('KTPM', 'Kỹ thuật phần mềm'),
                ('KHMT', 'Khoa học máy tính'),
                ('HTTT', 'Hệ thống thông tin'),
                ('KTOT', 'Kỹ thuật ô tô'),
                ('KT', 'Kinh tế'),
                ('NNA', 'Ngôn ngữ Anh'),
                ('TCNH', 'Tài chính ngân hàng'),
                ('KTVT', 'Kỹ thuật viễn thông')");
                
                // Thêm dữ liệu mẫu SinhVien
                $this->conn->exec("INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES 
                    ('0123456789', 'Nguyễn Văn A', 'Nam', '2000-12-02', '/Content/images/sv1.jpg', 'CNTT'),
                    ('9876543210', 'Nguyễn Thị B', 'Nữ', '2000-03-07', '/Content/images/sv2.jpg', 'QTKD')");
                
                // Thêm dữ liệu mẫu HocPhan
                $this->conn->exec("INSERT INTO HocPhan (MaHP, TenHP, SoTinChi) VALUES 
                    ('CNTT01', 'Lập trình C', 3),
                    ('CNTT02', 'Cơ sở dữ liệu', 2),
                    ('CNTT03', 'Xác suất thống kê 1', 3),
                    ('CNTT04', 'Phát triển phần mềm mã nguồn mở', 3),
                    ('CNTT05', 'Lập trình hướng đối tượng', 3),
                    ('QTKD01', 'Kinh tế vĩ mô', 3)");
            }
        } catch(PDOException $exception) {
            echo "Lỗi thêm dữ liệu mẫu: " . $exception->getMessage();
        }
    }
}
?>