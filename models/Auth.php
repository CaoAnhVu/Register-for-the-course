<?php
class Auth {
    private $conn;
    private $table_name = "SinhVien";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kiểm tra sinh viên tồn tại
    public function checkUser($maSV) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $maSV);
        $stmt->execute();
        
        return ($stmt->rowCount() > 0);
    }

    // Thêm sinh viên mới nếu chưa tồn tại
    public function register($maSV, $hoTen, $gioiTinh, $ngaySinh, $maNganh) {
        // Kiểm tra nếu sinh viên đã tồn tại
        if ($this->checkUser($maSV)) {
            return false;
        }
        
        $query = "INSERT INTO " . $this->table_name . " 
                 (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh) 
                 VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        // Bind params
        $stmt->bindParam(1, $maSV);
        $stmt->bindParam(2, $hoTen);
        $stmt->bindParam(3, $gioiTinh);
        $stmt->bindParam(4, $ngaySinh);
        $stmt->bindParam(5, $maNganh);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>