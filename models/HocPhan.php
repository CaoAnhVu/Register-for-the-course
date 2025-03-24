<?php
class HocPhan {
    private $conn;
    private $table_name = "HocPhan";

    public $MaHP;
    public $TenHP;
    public $SoTinChi;
    public $SoLuongDuKien;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách học phần
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy học phần theo ID
    public function getById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaHP);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->MaHP = $row['MaHP'];
            $this->TenHP = $row['TenHP'];
            $this->SoTinChi = $row['SoTinChi'];
            $this->SoLuongDuKien = $row['SoLuongDuKien'];
            return true;
        }
        return false;
    }
    
    // Thêm số lượng dự kiến và số lượng đã đăng ký
    public function getAllWithRegistration() {
        $query = "SELECT hp.*, 
                  IFNULL(
                    (SELECT COUNT(*) FROM ChiTietDangKy ctdk 
                     JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
                     WHERE ctdk.MaHP = hp.MaHP), 0
                  ) as SoLuongDaDangKy
                FROM " . $this->table_name . " hp";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Cập nhật số lượng dự kiến vào database
    public function updateSoLuongDuKien($maHP, $soLuong) {
        $query = "UPDATE " . $this->table_name . " SET SoLuongDuKien = ? WHERE MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $soLuong);
        $stmt->bindParam(2, $maHP);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Giảm số lượng dự kiến khi có đăng ký mới (không sử dụng)
    // Thay vào đó, chúng ta dùng SoLuongDaDangKy để tính toán số lượng còn lại
    // Vì SoLuongDuKien là tổng số lượng sinh viên có thể đăng ký học phần
    
    public function getSoLuongDuKien($maHP) {
        $query = "SELECT SoLuongDuKien FROM " . $this->table_name . " WHERE MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maHP);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($result) {
            return $result['SoLuongDuKien'];
        }
        // Giá trị mặc định
        return 40;  // Giả sử mỗi học phần có 40 chỗ mặc định
    }

    public function getSoLuongDaDangKy($maHP) {
        $query = "SELECT COUNT(*) as total 
                 FROM ChiTietDangKy ctdk 
                 JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
                 WHERE ctdk.MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maHP);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }
    
    // Kiểm tra còn chỗ trống không
    public function checkAvailability($maHP) {
        $soLuongDuKien = $this->getSoLuongDuKien($maHP);
        $soLuongDaDangKy = $this->getSoLuongDaDangKy($maHP);
        
        return ($soLuongDaDangKy < $soLuongDuKien);
    }
}
?>