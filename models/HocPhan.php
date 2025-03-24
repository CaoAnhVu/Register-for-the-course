<?php
class HocPhan {
    private $conn;
    private $table_name = "HocPhan";

    public $MaHP;
    public $TenHP;
    public $SoTinChi;
    public $SoLuongDuKien;  // Thêm trường số lượng dự kiến

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
                  ) as DaDangKy,
                  99 as SoLuongDuKien
                FROM " . $this->table_name . " hp";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateSoLuongDuKien($maHP, $soLuong) {
        // Thực tế, chúng ta cần thêm field SoLuongDuKien vào bảng HocPhan
        // Tuy nhiên, bài tập này đã định nghĩa sẵn cấu trúc bảng
        // Nên chúng ta sẽ giả lập bằng cách lưu vào session
        if (!isset($_SESSION['SoLuongDuKien'])) {
            $_SESSION['SoLuongDuKien'] = [];
        }
        
        $_SESSION['SoLuongDuKien'][$maHP] = $soLuong;
        return true;
    }

    public function getSoLuongDuKien($maHP) {
        if (isset($_SESSION['SoLuongDuKien']) && isset($_SESSION['SoLuongDuKien'][$maHP])) {
            return $_SESSION['SoLuongDuKien'][$maHP];
        }
        
        // Giá trị mặc định
        return 99;  // Giả sử mỗi học phần có 99 chỗ
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
}
?>