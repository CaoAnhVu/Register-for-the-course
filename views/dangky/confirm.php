<?php include 'views/shared/header.php'; ?>

<div class="container">
    <h1 class="my-4">Đăng Kí học phần</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin Đăng kí</h5>
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
                    <p><strong>Ngày Đăng Kí:</strong> <?php echo date('d/m/Y'); ?></p>
                </div>
            </div>
            
            <table class="table table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>MaHP</th>
                        <th>Tên Học Phần</th>
                        <th>Số Tín Chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?php echo $course['MaHP']; ?></td>
                            <td><?php echo $course['TenHP']; ?></td>
                            <td><?php echo $course['SoTinChi']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Số lượng học phần: <?php echo count($courses); ?></strong></td>
                        <td><strong>Tổng số tín chỉ: <?php echo $totalCredits; ?></strong></td>
                    </tr>
                </tfoot>
            </table>
            
            <form action="index.php?controller=DangKy&action=saveConfirm" method="post" class="mt-4">
                <input type="hidden" name="confirm" value="1">
                <button type="submit" class="btn btn-success">Xác Nhận</button>
                <a href="index.php?controller=DangKy&action=index" class="btn btn-secondary">Trở về giỏ hàng</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/shared/footer.php'; ?>