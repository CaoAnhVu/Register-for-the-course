<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fas fa-user-plus me-2"></i>THÊM SINH VIÊN MỚI</h3>
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
            
            <form method="post" action="index.php?controller=SinhVien&action=store" enctype="multipart/form-data" id="createForm">
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
                                            <input type="text" id="MaSV" name="MaSV" class="form-control" required>
                                            <label for="MaSV">Mã sinh viên</label>
                                        </div>
                                        <small class="text-muted">Nhập mã sinh viên (VD: SV001)</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="text" id="HoTen" name="HoTen" class="form-control" required>
                                            <label for="HoTen">Họ và tên</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <select id="GioiTinh" name="GioiTinh" class="form-select">
                                                <option value="Nam" selected>Nam</option>
                                                <option value="Nữ">Nữ</option>
                                            </select>
                                            <label for="GioiTinh">Giới tính</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating">
                                            <input type="datetime-local" id="NgaySinh" name="NgaySinh" class="form-control" 
                                                value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                                            <label for="NgaySinh">Ngày sinh</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select id="MaNganh" name="MaNganh" class="form-select" required>
                                            <option value="" disabled selected>-- Chọn ngành học --</option>
                                            <?php foreach ($nganhs as $nganh): ?>
                                                <option value="<?php echo $nganh['MaNganh']; ?>">
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
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto" 
                                         style="width: 180px; height: 180px; border: 2px dashed #ccc;" id="imagePreview">
                                        <i class="fas fa-user text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <input type="file" id="Hinh" name="Hinh" class="form-control" accept="image/*">
                                    <label class="input-group-text" for="Hinh"><i class="fas fa-upload"></i></label>
                                </div>
                                <small class="text-muted">Chọn ảnh có kích thước phù hợp (dưới 2MB)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <a href="index.php?controller=SinhVien&action=index" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Hủy
                </a>
                <div>
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                        <i class="fas fa-undo me-1"></i> Làm mới
                    </button>
                    <button type="submit" form="createForm" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Lưu lại
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
        const imagePreview = document.getElementById('imagePreview');
        
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
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="rounded-circle" style="width: 180px; height: 180px; object-fit: cover;">`;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Xử lý validate form
        const form = document.getElementById('createForm');
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validate mã sinh viên
            const maSV = document.getElementById('MaSV');
            if (maSV.value.trim() === '') {
                markInvalid(maSV, 'Vui lòng nhập mã sinh viên');
                isValid = false;
            } else {
                markValid(maSV);
            }
            
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
            
            // Validate ngành học
            const maNganh = document.getElementById('MaNganh');
            if (maNganh.value === '') {
                markInvalid(maNganh, 'Vui lòng chọn ngành học');
                isValid = false;
            } else {
                markValid(maNganh);
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
        document.getElementById('createForm').reset();
        document.getElementById('imagePreview').innerHTML = '<i class="fas fa-user text-muted" style="font-size: 4rem;"></i>';
        
        // Xóa các trạng thái validate
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });
        
        // Xóa các thông báo lỗi
        const feedbacks = document.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => {
            feedback.remove();
        });
    }
</script>

<?php include 'views/shared/footer.php'; ?>