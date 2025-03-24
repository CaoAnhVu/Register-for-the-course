<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="alert alert-success mt-4">
        <h2 class="alert-heading"><i class="fas fa-check-circle"></i> Thông Tin Học Phần Đã Lưu</h2>
        <p>Bạn đã đăng ký học phần thành công!</p>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Chi tiết đăng ký</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã số sinh viên:</strong> <?php echo $this->sinhVien->MaSV; ?></p>
                    <p><strong>Họ tên sinh viên:</strong> <?php echo $this->sinhVien->HoTen; ?></p>
                    <p><strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($this->sinhVien->NgaySinh)); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngành học:</strong> <?php echo $this->sinhVien->MaNganh; ?></p>
                    <p><strong>Ngày đăng ký:</strong> <?php echo date('d/m/Y', strtotime($_SESSION['NgayDK'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <h3>Kết quả sau khi đăng ký học phần:</h3>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>MaHP</th>
                    <th>TenHP</th>
                    <th>SoTinChi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $course['MaHP']; ?></td>
                        <td><?php echo $course['TenHP']; ?></td>
                        <td><?php echo $course['SoTinChi']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="3"><strong>Tổng số học phần: <?php echo count($courses); ?></strong></td>
                    <td><strong>Tổng số tín chỉ: <?php echo $totalCredits; ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="d-flex mt-4">
        <a href="index.php?controller=DangKy&action=index" class="btn btn-primary me-2">Về trang đăng ký</a>
        <a href="index.php" class="btn btn-secondary">Về trang chủ</a>
    </div>
</div>

<?php include 'views/shared/footer.php'; ?>