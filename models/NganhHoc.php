<?php
class NganhHoc {
    private $conn;
    private $table_name = "NganhHoc";

    public $MaNganh;
    public $TenNganh;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách ngành học
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lấy ngành học theo ID
    public function getById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaNganh);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->MaNganh = $row['MaNganh'];
            $this->TenNganh = $row['TenNganh'];
            return true;
        }
        return false;
    }
}
?>