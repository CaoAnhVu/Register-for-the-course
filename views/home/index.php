<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="jumbotron mt-4 bg-light p-5 rounded">
        <h1 class="display-4">HỆ THỐNG ĐĂNG KÝ HỌC PHẦN</h1>
        <p class="lead">Chào mừng đến với hệ thống đăng ký học phần Khoa CNTT!</p>
        <hr class="my-4">
        <p>Sử dụng hệ thống này để quản lý sinh viên và đăng ký học phần.</p>
        
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Quản lý Sinh Viên</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Quản lý thông tin sinh viên, thêm, sửa, xóa và xem chi tiết.</p>
                        <a href="index.php?controller=SinhVien&action=index" class="btn btn-primary">Quản lý Sinh Viên</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Đăng Ký Học Phần</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Xem danh sách và đăng ký các học phần có sẵn.</p>
                        <a href="index.php?controller=HocPhan&action=index" class="btn btn-success">Đăng Ký Học Phần</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Đăng Nhập</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Đăng nhập để đăng ký học phần và quản lý thông tin cá nhân.</p>
                        <?php if (isset($_SESSION['MaSV'])): ?>
                            <a href="index.php?controller=DangKy&action=index" class="btn btn-info">Xem đăng ký</a>
                        <?php else: ?>
                            <a href="index.php?controller=Auth&action=login" class="btn btn-info">Đăng Nhập</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/shared/footer.php'; ?>