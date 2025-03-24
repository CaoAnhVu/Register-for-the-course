<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fas fa-user-edit me-2"></i>CHỈNH SỬA THÔNG TIN SINH VIÊN</h3>
                <a href="index.php?controller=SinhVien&action=index" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            
            <form method="post" action="index.php?controller=SinhVien&action=update" enctype="multipart/form-data" id="editForm">
                <input type="hidden" name="MaSV" value="<?php echo $this->sinhVien->MaSV; ?>">
                
                <div class="row">
                    <!-- Cột thông tin cá nhân -->
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin cơ bản</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" id="MaSV" class="form-control bg-light" value="<?php echo $this->sinhVien->MaSV; ?>" disabled>
                                            <label for="MaSV">Mã sinh viên</label>
                                        </div>
                                        <small class="text-muted">Mã sinh viên không thể thay đổi</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" id="HoTen" name="HoTen" class="form-control" 
                                                value="<?php echo $this->sinhVien->HoTen; ?>" required>
                                            <label for="HoTen">Họ và tên</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <select id="GioiTinh" name="GioiTinh" class="form-select">
                                                <option value="Nam" <?php echo ($this->sinhVien->GioiTinh == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                                <option value="Nữ" <?php echo ($this->sinhVien->GioiTinh == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                            </select>
                                            <label for="GioiTinh">Giới tính</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="datetime-local" id="NgaySinh" name="NgaySinh" class="form-control" 
                                                value="<?php echo date('Y-m-d\TH:i', strtotime($this->sinhVien->NgaySinh)); ?>" required>
                                            <label for="NgaySinh">Ngày sinh</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select id="MaNganh" name="MaNganh" class="form-select" required>
                                            <?php foreach ($nganhs as $nganh): ?>
                                                <option value="<?php echo $nganh['MaNganh']; ?>" 
                                                        <?php echo ($nganh['MaNganh'] == $this->sinhVien->MaNganh) ? 'selected' : ''; ?>>
                                                    <?php echo $nganh['MaNganh'] . ' - ' . $nganh['TenNganh']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="MaNganh">Ngành học</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cột hình ảnh -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-image me-2"></i>Hình ảnh</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <?php if (!empty($this->sinhVien->Hinh)): ?>
                                        <div class="position-relative d-inline-block">
                                            <img src="<?php echo $this->sinhVien->Hinh; ?>" alt="<?php echo $this->sinhVien->HoTen; ?>" 
                                                class="img-thumbnail rounded-circle mb-3" style="width: 180px; height: 180px; object-fit: cover;">
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto" 
                                            style="width: 180px; height: 180px; border: 2px dashed #ccc;">
                                            <i class="fas fa-user text-muted" style="font-size: 4rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <input type="file" id="Hinh" name="Hinh" class="form-control" accept="image/*">
                                    <label class="input-group-text" for="Hinh"><i class="fas fa-upload"></i></label>
                                </div>
                                <small class="text-muted">Chọn ảnh có kích thước phù hợp (dưới 2MB)</small>
                                
                                <div class="form-check form-switch mt-3 text-start">
                                    <input class="form-check-input" type="checkbox" id="keepCurrentImage" name="keepCurrentImage" value="1" checked>
                                    <label class="form-check-label" for="keepCurrentImage">
                                        Giữ ảnh hiện tại nếu không chọn ảnh mới
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php?controller=SinhVien&action=show&id=<?php echo $this->sinhVien->MaSV; ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-eye me-1"></i> Xem thông tin
                </a>
                <div>
                    <button type="button" class="btn btn-outline-danger me-2" onclick="resetForm()">
                        <i class="fas fa-undo me-1"></i> Hủy thay đổi
                    </button>
                    <button type="submit" form="editForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Lưu thay đổi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiệu ứng cho input file
        const fileInput = document.getElementById('Hinh');
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Chưa chọn file';
            const nextSibling = this.nextElementSibling;
            nextSibling.innerHTML = fileName.length > 20 
                ? '<i class="fas fa-upload"></i> ' + fileName.substring(0, 17) + '...' 
                : '<i class="fas fa-upload"></i> ' + fileName;
            
            // Hiển thị preview ảnh
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.querySelector('.position-relative') || document.querySelector('.rounded-circle');
                    if (imgContainer) {
                        imgContainer.innerHTML = `<img src="${e.target.result}" class="img-thumbnail rounded-circle mb-3" style="width: 180px; height: 180px; object-fit: cover;">`;
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Xử lý validate form
        const form = document.getElementById('editForm');
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validate họ tên
            const hoTen = document.getElementById('HoTen');
            if (hoTen.value.trim() === '') {
                markInvalid(hoTen, 'Vui lòng nhập họ tên');
                isValid = false;
            } else {
                markValid(hoTen);
            }
            
            // Validate ngày sinh
            const ngaySinh = document.getElementById('NgaySinh');
            if (ngaySinh.value === '') {
                markInvalid(ngaySinh, 'Vui lòng chọn ngày sinh');
                isValid = false;
            } else {
                markValid(ngaySinh);
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    
    function markInvalid(element, message) {
        element.classList.add('is-invalid');
        
        // Tạo hoặc cập nhật thông báo lỗi
        let feedback = element.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            element.parentNode.appendChild(feedback);
        }
        feedback.textContent = message;
    }
    
    function markValid(element) {
        element.classList.remove('is-invalid');
        element.classList.add('is-valid');
    }
    
    function resetForm() {
        if (confirm('Bạn có chắc muốn hủy tất cả thay đổi?')) {
            document.getElementById('editForm').reset();
            // Reload lại trang để lấy giá trị ban đầu
            location.reload();
        }
    }
</script>

<?php include 'views/shared/footer.php'; ?>