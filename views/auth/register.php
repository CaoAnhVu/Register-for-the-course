<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h1 class="card-title">ĐĂNG KÝ TÀI KHOẢN</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="index.php?controller=Auth&action=saveRegister">
                        <div class="mb-3">
                            <label for="MaSV" class="form-label">Mã Sinh Viên</label>
                            <input type="text" class="form-control" id="MaSV" name="MaSV" required 
                                   value="<?php echo isset($_POST['MaSV']) ? $_POST['MaSV'] : ''; ?>">
                            <small class="form-text text-muted">
                                Nhập mã số sinh viên (vd: 0123456789).
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="HoTen" class="form-label">Họ Tên</label>
                            <input type="text" class="form-control" id="HoTen" name="HoTen" required
                                   value="<?php echo isset($_POST['HoTen']) ? $_POST['HoTen'] : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="GioiTinh" class="form-label">Giới Tính</label>
                            <select class="form-select" id="GioiTinh" name="GioiTinh" required>
                                <option value="Nam" <?php echo (isset($_POST['GioiTinh']) && $_POST['GioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                <option value="Nữ" <?php echo (isset($_POST['GioiTinh']) && $_POST['GioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="NgaySinh" class="form-label">Ngày Sinh</label>
                            <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required
                                   value="<?php echo isset($_POST['NgaySinh']) ? $_POST['NgaySinh'] : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="MaNganh" class="form-label">Ngành Học</label>
                            <select class="form-select" id="MaNganh" name="MaNganh" required>
                                <?php foreach ($nganhs as $nganh): ?>
                                    <option value="<?php echo $nganh['MaNganh']; ?>" 
                                        <?php echo (isset($_POST['MaNganh']) && $_POST['MaNganh'] == $nganh['MaNganh']) ? 'selected' : ''; ?>>
                                        <?php echo $nganh['TenNganh']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Đăng Ký</button>
                        </div>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <p>Đã có tài khoản? <a href="index.php?controller=Auth&action=login">Đăng nhập ngay</a></p>
                        <p><a href="index.php" class="btn btn-link">Quay về trang chủ</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/shared/footer.php'; ?>