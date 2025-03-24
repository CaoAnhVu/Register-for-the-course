<?php include 'views/shared/header.php'; ?>

<div class="container">
    <h1 class="my-4">XÓA THÔNG TIN</h1>
    <p class="alert alert-danger">Are you sure you want to delete this?</p>
    
    <div class="card">
        <div class="card-header">
            <h5>Thông tin sinh viên</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>HoTen:</strong> <?php echo $this->sinhVien->HoTen; ?></p>
                    <p><strong>GioiTinh:</strong> <?php echo $this->sinhVien->GioiTinh; ?></p>
                    <p><strong>NgaySinh:</strong> <?php echo date('d/m/Y H:i:s A', strtotime($this->sinhVien->NgaySinh)); ?></p>
                    <p><strong>Hinh:</strong></p>
                    <?php if (!empty($this->sinhVien->Hinh)): ?>
                        <img src="<?php echo $this->sinhVien->Hinh; ?>" alt="<?php echo $this->sinhVien->HoTen; ?>" 
                             style="max-width: 200px;" class="img-thumbnail">
                    <?php endif; ?>
                    <p><strong>MaNganh:</strong> <?php echo $this->sinhVien->MaNganh; ?></p>
                </div>
            </div>
            
            <form method="post" action="index.php?controller=SinhVien&action=destroy" class="mt-3">
                <input type="hidden" name="MaSV" value="<?php echo $this->sinhVien->MaSV; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="index.php?controller=SinhVien&action=index" class="btn btn-secondary">Back to List</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/shared/footer.php'; ?>