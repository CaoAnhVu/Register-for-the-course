<?php
class HomeController {
    public function __construct() {
        // Không cần kết nối database vì chỉ hiển thị giao diện
    }

    public function index() {
        include 'views/home/index.php';
    }
}
?>