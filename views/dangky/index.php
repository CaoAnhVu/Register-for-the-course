<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fas fa-clipboard-list me-2"></i>ĐĂNG KÝ HỌC PHẦN</h3>
                <a href="index.php?controller=HocPhan&action=index" class="btn btn-light btn-sm">
                    <i class="fas fa-search me-1"></i> Tìm học phần
                </a>
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
            
            <?php if (empty($courses)): ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-book-open text-muted" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="text-muted">Bạn chưa đăng ký học phần nào</h4>
                    <p class="text-muted mb-4">Hãy bắt đầu đăng ký các học phần cho kỳ học này</p>
                    <a href="index.php?controller=HocPhan&action=index" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle me-2"></i>Đăng ký ngay
                    </a>
                </div>
            <?php else: ?>
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle fa-2x me-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading">Thông tin đăng ký</h5>
                                        <p class="mb-0">Sinh viên: <strong><?php echo $_SESSION['HoTen']; ?> (<?php echo $_SESSION['MaSV']; ?>)</strong></p>
                                        <p class="mb-0">Số học phần: <strong><?php echo count($courses); ?></strong></p>
                                        <p class="mb-0">Tổng số tín chỉ: <strong><?php echo $totalCredits; ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning mb-0 h-100">
                                <div class="d-flex h-100 align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading">Lưu ý quan trọng</h5>
                                        <p class="mb-0">Vui lòng kiểm tra kỹ thông tin trước khi xác nhận đăng ký.</p>
                                        <p class="mb-0">Bạn không thể sửa đổi sau khi đã xác nhận.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%">Mã HP</th>
                                <th width="55%">Tên Học Phần</th>
                                <th width="15%" class="text-center">Số Tín Chỉ</th>
                                <th width="20%" class="text-center">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><span class="badge bg-primary"><?php echo $course['MaHP']; ?></span></td>
                                    <td class="fw-bold"><?php echo $course['TenHP']; ?></td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-info text-dark">
                                            <?php echo $course['SoTinChi']; ?> TC
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" 
                                                onclick="confirmRemoveCourse('<?php echo $course['MaHP']; ?>', '<?php echo $course['TenHP']; ?>')">
                                            <i class="fas fa-trash-alt me-1"></i> Xóa
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0">Tổng kết đăng ký</h5>
                                <p class="text-muted mb-0">Tổng cộng <?php echo count($courses); ?> học phần, <?php echo $totalCredits; ?> tín chỉ</p>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <button type="button" class="btn btn-outline-danger me-2" 
                                        onclick="confirmDeleteAll()">
                                    <i class="fas fa-times-circle me-1"></i> Hủy tất cả
                                </button>
                                <a href="index.php?controller=DangKy&action=confirm" class="btn btn-success">
                                    <i class="fas fa-check-circle me-1"></i> Xác nhận đăng ký
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa học phần -->
<div class="modal fade" id="removeCourseModal" tabindex="-1" aria-labelledby="removeCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="removeCourseModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa học phần
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa học phần <span id="courseNameToRemove" class="fw-bold text-danger"></span>?</p>
                <p class="mb-0 text-muted">Bạn có thể đăng ký lại sau nếu còn chỗ.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" id="confirmRemoveBtn" class="btn btn-danger">Xác nhận xóa</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa tất cả -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAllModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa tất cả
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center">Bạn có chắc chắn muốn xóa <span class="fw-bold">tất cả</span> đăng ký học phần?</p>
                <p class="text-center mb-0 text-muted">Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="index.php?controller=DangKy&action=deleteAll" class="btn btn-danger">Xác nhận xóa tất cả</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Kích hoạt tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Đóng các alert sau 5 giây
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert.alert-success, .alert.alert-danger');
            alerts.forEach(function(alert) {
                var bsAlert = bootstrap.Alert.getInstance(alert);
                if (bsAlert) {
                    bsAlert.close();
                }
            });
        }, 5000);
    });
    
    // Xác nhận xóa học phần
    function confirmRemoveCourse(courseId, courseName) {
        document.getElementById('courseNameToRemove').textContent = courseName + ' (' + courseId + ')';
        document.getElementById('confirmRemoveBtn').href = 'index.php?controller=DangKy&action=remove&id=' + courseId;
        var modal = new bootstrap.Modal(document.getElementById('removeCourseModal'));
        modal.show();
    }
    
    // Xác nhận xóa tất cả
    function confirmDeleteAll() {
        var modal = new bootstrap.Modal(document.getElementById('deleteAllModal'));
        modal.show();
    }
</script>

<?php include 'views/shared/footer.php'; ?>