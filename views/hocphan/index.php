<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fas fa-book me-2"></i>DANH SÁCH HỌC PHẦN</h3>
            </div>
        </div>
        <div class="card-body">
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã Học Phần</th>
                            <th>Tên Học Phần</th>
                            <th>Số Tín Chỉ</th>
                            <th>Số lượng cho phép</th>
                            <th>Đã đăng ký</th>
                            <th>Số lượng dự kiến(Còn lại)</th>
                            <th class="text-center">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hocPhans as $hocPhan): ?>
                            <?php 
                            $conLai = $hocPhan['SoLuongDuKien'] - $hocPhan['SoLuongDaDangKy']; 
                            
                            // Kiểm tra xem sinh viên đã đăng ký học phần này chưa
                            $daDangKy = false;
                            if (isset($_SESSION['MaSV'])) {
                                // KHÔNG sử dụng model trực tiếp tại view
                                $daDangKy = isset($hocPhan['DaDangKy']) ? $hocPhan['DaDangKy'] : false;
                            }
                            ?>
                            <tr>
                                <td><span class="badge bg-primary"><?php echo $hocPhan['MaHP']; ?></span></td>
                                <td class="fw-bold"><?php echo $hocPhan['TenHP']; ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-info text-dark">
                                        <?php echo $hocPhan['SoTinChi']; ?> TC
                                    </span>
                                </td>
                                <td class="text-center"><?php echo $hocPhan['SoLuongDuKien']; ?></td>
                                <td class="text-center"><?php echo $hocPhan['SoLuongDaDangKy']; ?></td>
                                <td class="text-center">
                                    <?php if ($conLai > 10): ?>
                                        <span class="badge bg-success"><?php echo $conLai; ?></span>
                                    <?php elseif ($conLai > 0): ?>
                                        <span class="badge bg-warning text-dark"><?php echo $conLai; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hết chỗ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($_SESSION['MaSV'])): ?>
                                        <?php if ($daDangKy): ?>
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-check me-1"></i> Đã đăng ký
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" 
                                                    onclick="showAlreadyRegisteredMessage('<?php echo $hocPhan['TenHP']; ?>')">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        <?php elseif ($conLai <= 0): ?>
                                            <button type="button" class="btn btn-danger btn-sm" disabled>
                                                <i class="fas fa-ban me-1"></i> Hết chỗ
                                            </button>
                                        <?php else: ?>
                                            <a href="index.php?controller=HocPhan&action=register&id=<?php echo $hocPhan['MaHP']; ?>" 
                                               class="btn btn-success btn-sm">
                                                <i class="fas fa-plus-circle me-1"></i> Đăng ký
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="index.php?controller=Auth&action=login" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập để đăng ký
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Tổng số: <span class="fw-bold"><?php echo count($hocPhans); ?></span> học phần</small>
                <?php if(isset($_SESSION['MaSV'])): ?>
                    <a href="index.php?controller=DangKy&action=index" class="btn btn-primary btn-sm">
                        <i class="fas fa-clipboard-list me-1"></i> Xem danh sách đã đăng ký
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thông báo đã đăng ký -->
<div class="modal fade" id="alreadyRegisteredModal" tabindex="-1" aria-labelledby="alreadyRegisteredModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="alreadyRegisteredModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Thông báo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-clipboard-check text-success" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center fs-5">Bạn đã đăng ký học phần <span id="courseNamePlaceholder" class="fw-bold text-primary"></span> trước đó!</p>
                <p class="text-center">Nếu muốn hủy đăng ký, vui lòng sử dụng chức năng quản lý đăng ký học phần.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a href="index.php?controller=DangKy&action=index" class="btn btn-primary">
                    <i class="fas fa-clipboard-list me-1"></i> Xem đăng ký của tôi
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Kích hoạt tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Đóng các alert sau 5 giây
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = bootstrap.Alert.getInstance(alert);
                if (bsAlert) {
                    bsAlert.close();
                }
            });
        }, 5000);
    });
    
    // Hiển thị thông báo đã đăng ký
    function showAlreadyRegisteredMessage(courseName) {
        document.getElementById('courseNamePlaceholder').textContent = courseName;
        var modal = new bootstrap.Modal(document.getElementById('alreadyRegisteredModal'));
        modal.show();
    }
</script>

<?php include 'views/shared/footer.php'; ?>