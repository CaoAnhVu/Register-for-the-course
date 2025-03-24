<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0"><i class="fas fa-user-circle me-2"></i>THÔNG TIN SINH VIÊN</h3>
                <div>
                    <a href="index.php?controller=SinhVien&action=edit&id=<?php echo $this->sinhVien->MaSV; ?>" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-edit me-1"></i> Chỉnh sửa
                    </a>
                    <a href="index.php?controller=SinhVien&action=index" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="row g-0">
                <div class="col-md-4 bg-light text-center p-4 border-end">
                    <?php if (!empty($this->sinhVien->Hinh)): ?>
                        <img src="<?php echo $this->sinhVien->Hinh; ?>" alt="<?php echo $this->sinhVien->HoTen; ?>" 
                             class="img-fluid rounded-circle shadow mb-3" style="max-width: 200px; height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle mx-auto mb-3" 
                             style="width: 200px; height: 200px;">
                            <i class="fas fa-user text-light" style="font-size: 5rem;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="fw-bold text-primary mb-1"><?php echo $this->sinhVien->HoTen; ?></h3>
                    <p class="text-muted mb-3">Mã sinh viên: <span class="badge bg-primary"><?php echo $this->sinhVien->MaSV; ?></span></p>
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="index.php?controller=SinhVien&action=edit&id=<?php echo $this->sinhVien->MaSV; ?>" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Chỉnh sửa thông tin
                        </a>
                        <?php if(isset($_SESSION['MaSV']) && $_SESSION['MaSV'] == $this->sinhVien->MaSV): ?>
                            <a href="index.php?controller=DangKy&action=index" class="btn btn-success">
                                <i class="fas fa-clipboard-list me-1"></i> Xem đăng ký học phần
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="p-4">
                        <h4 class="border-bottom pb-2 mb-4"><i class="fas fa-info-circle me-2"></i>Thông tin cá nhân</h4>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-muted small d-block">Họ tên</label>
                                    <span class="fs-5 fw-bold"><?php echo $this->sinhVien->HoTen; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-muted small d-block">Mã sinh viên</label>
                                    <span class="fs-5 fw-bold"><?php echo $this->sinhVien->MaSV; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-muted small d-block">Giới tính</label>
                                    <?php if($this->sinhVien->GioiTinh == 'Nam'): ?>
                                        <span class="badge bg-primary rounded-pill py-2 px-3"><i class="fas fa-mars me-1"></i> Nam</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill py-2 px-3"><i class="fas fa-venus me-1"></i> Nữ</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-muted small d-block">Ngày sinh</label>
                                    <span class="fs-5">
                                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                                        <?php echo date('d/m/Y', strtotime($this->sinhVien->NgaySinh)); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-uppercase text-muted small d-block">Ngành học</label>
                                    <span class="badge bg-info text-dark rounded-pill py-2 px-3 fs-6">
                                        <i class="fas fa-graduation-cap me-1"></i>
                                        <?php
                                        $nganh = '';
                                        switch($this->sinhVien->MaNganh) {
                                            case 'CNTT': $nganh = 'Công nghệ thông tin'; break;
                                            case 'QTKD': $nganh = 'Quản trị kinh doanh'; break;
                                            case 'KTPM': $nganh = 'Kỹ thuật phần mềm'; break;
                                            case 'KHMT': $nganh = 'Khoa học máy tính'; break;
                                            case 'HTTT': $nganh = 'Hệ thống thông tin'; break;
                                            case 'KTOT': $nganh = 'Kỹ thuật ô tô'; break;
                                            case 'KT': $nganh = 'Kinh tế'; break;
                                            case 'NNA': $nganh = 'Ngôn ngữ Anh'; break;
                                            case 'TCNH': $nganh = 'Tài chính ngân hàng'; break;
                                            case 'KTVT': $nganh = 'Kỹ thuật viễn thông'; break;
                                            default: $nganh = $this->sinhVien->MaNganh;
                                        }
                                        echo $this->sinhVien->MaNganh . ' - ' . $nganh;
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(isset($_SESSION['admin']) || (isset($_SESSION['MaSV']) && $_SESSION['MaSV'] == $this->sinhVien->MaSV)): ?>
                            <div class="alert alert-info d-flex align-items-center mt-4" role="alert">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading">Thông tin đăng ký học phần</h5>
                                    <p class="mb-0">Xem thông tin đăng ký học phần và tiến độ học tập của bạn.</p>
                                </div>
                                <div class="ms-auto">
                                    <a href="index.php?controller=DangKy&action=index" class="btn btn-info text-white">
                                        Xem đăng ký
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="far fa-clock me-1"></i> Cập nhật lần cuối: <?php echo date('d/m/Y H:i', strtotime($this->sinhVien->NgaySinh)); ?>
                </small>
                <div>
                    <a href="index.php?controller=SinhVien&action=index" class="btn btn-secondary btn-sm">
                        <i class="fas fa-list me-1"></i> Danh sách sinh viên
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiệu ứng hover cho các nút
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseover', function() {
                this.classList.add('shadow-sm');
            });
            button.addEventListener('mouseout', function() {
                this.classList.remove('shadow-sm');
            });
        });
    });
</script>

<?php include 'views/shared/footer.php'; ?>