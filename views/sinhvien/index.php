<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fas fa-user-graduate me-2"></i>QUẢN LÝ SINH VIÊN</h3>
                <a href="index.php?controller=SinhVien&action=create" class="btn btn-light">
                    <i class="fas fa-plus-circle me-1"></i> Thêm Sinh Viên
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
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã SV</th>
                            <th>Họ Tên</th>
                            <th>Giới Tính</th>
                            <th>Ngày Sinh</th>
                            <th>Hình</th>
                            <th>Ngành</th>
                            <th class="text-center">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($sinhViens)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu sinh viên</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sinhViens as $sinhVien): ?>
                                <tr>
                                    <td><span class="badge bg-primary"><?php echo $sinhVien['MaSV']; ?></span></td>
                                    <td class="fw-bold"><?php echo $sinhVien['HoTen']; ?></td>
                                    <td>
                                        <?php if($sinhVien['GioiTinh'] == 'Nam'): ?>
                                            <span class="text-primary"><i class="fas fa-mars me-1"></i> Nam</span>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fas fa-venus me-1"></i> Nữ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($sinhVien['NgaySinh'])); ?></td>
                                    <td>
                                        <?php if (!empty($sinhVien['Hinh'])): ?>
                                            <img src="<?php echo $sinhVien['Hinh']; ?>" alt="<?php echo $sinhVien['HoTen']; ?>" class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px;">
                                                <i class="fas fa-user text-secondary" style="font-size: 1.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-info text-dark">
                                            <?php echo $sinhVien['MaNganh']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="index.php?controller=SinhVien&action=show&id=<?php echo $sinhVien['MaSV']; ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="index.php?controller=SinhVien&action=edit&id=<?php echo $sinhVien['MaSV']; ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo $sinhVien['MaSV']; ?>')" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Tổng số: <span class="fw-bold"><?php echo count($sinhViens); ?></span> sinh viên</small>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>Xác nhận xóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa sinh viên này không? Dữ liệu đã xóa không thể khôi phục.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Xóa</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Kích hoạt tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Đóng các alert sau 5 giây
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
    
    // Xác nhận xóa
    function confirmDelete(id) {
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('confirmDeleteBtn').href = 'index.php?controller=SinhVien&action=delete&id=' + id;
        modal.show();
    }
</script>

<?php include 'views/shared/footer.php'; ?>