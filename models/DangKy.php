<?php
class DangKy {
    private $conn;
    private $table_name = "DangKy";

    public $MaDK;
    public $NgayDK;
    public $MaSV;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kiểm tra xem sinh viên đã có đăng ký chưa
    public function hasRegistration() {
        $query = "SELECT MaDK FROM " . $this->table_name . " WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaSV);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->MaDK = $row['MaDK'];
            return true;
        }
        return false;
    }

    // Kiểm tra xem học phần đã đăng ký chưa
    public function isRegistered($maHP) {
        $query = "SELECT * FROM ChiTietDangKy 
                  WHERE MaDK = ? AND MaHP = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaDK);
        $stmt->bindParam(2, $maHP);
        $stmt->execute();
        
        return ($stmt->rowCount() > 0);
    }

    // Tạo đăng ký mới hoặc lấy đăng ký hiện có
    public function createOrGet() {
        // Kiểm tra xem sinh viên đã có đăng ký chưa
        if ($this->hasRegistration()) {
            return true; // Đã có đăng ký, MaDK đã được cập nhật
        }
        
        // Tạo đăng ký mới nếu chưa có
        $query = "INSERT INTO " . $this->table_name . " 
                 SET NgayDK=:NgayDK, MaSV=:MaSV";
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch và bind dữ liệu
        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        
        $stmt->bindParam(':NgayDK', $this->NgayDK);
        $stmt->bindParam(':MaSV', $this->MaSV);
        
        if($stmt->execute()) {
            $this->MaDK = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Thêm học phần vào đăng ký
    public function registerCourse($maHP) {
        // Đảm bảo có đăng ký cho sinh viên
        if (!$this->createOrGet()) {
            return false;
        }
        
        // Kiểm tra xem học phần đã đăng ký chưa
        if ($this->isRegistered($maHP)) {
            return false; // Đã đăng ký học phần này rồi
        }
        
        // Thêm chi tiết đăng ký
        return $this->addDetail($maHP);
    }

    // Lấy đăng ký theo MaSV
    public function getByMaSV() {
        $query = "SELECT dk.*, ctdk.MaHP, hp.TenHP, hp.SoTinChi 
                FROM " . $this->table_name . " dk
                JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
                JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
                WHERE dk.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaSV);
        $stmt->execute();
        return $stmt;
    }

    // Thêm chi tiết đăng ký
    public function addDetail($maHP) {
        $query = "INSERT INTO ChiTietDangKy SET MaDK=:MaDK, MaHP=:MaHP";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':MaDK', $this->MaDK);
        $stmt->bindParam(':MaHP', $maHP);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa chi tiết đăng ký
    public function removeDetail($maHP) {
        $query = "DELETE FROM ChiTietDangKy WHERE MaDK=:MaDK AND MaHP=:MaHP";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':MaDK', $this->MaDK);
        $stmt->bindParam(':MaHP', $maHP);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa đăng ký
    public function delete() {
        // Xóa chi tiết đăng ký trước
        $query = "DELETE FROM ChiTietDangKy WHERE MaDK = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaDK);
        $stmt->execute();
        
        // Sau đó xóa đăng ký
        $query = "DELETE FROM " . $this->table_name . " WHERE MaDK = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaDK);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Lấy học phần đã đăng ký của sinh viên
    public function getRegisteredCourses() {
        $query = "SELECT hp.MaHP, hp.TenHP, hp.SoTinChi 
                FROM ChiTietDangKy ctdk
                JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
                JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
                WHERE dk.MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaSV);
        $stmt->execute();
        return $stmt;
    }
}
?>