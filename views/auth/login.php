<?php include 'views/shared/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header">
                    <h1 class="card-title">ĐĂNG NHẬP</h1>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="index.php?controller=Auth&action=authenticate">
                        <div class="mb-3">
                            <label for="MaSV" class="form-label">MaSV</label>
                            <input type="text" class="form-control" id="MaSV" name="MaSV" required>
                            <small class="form-text text-muted">
                                Sử dụng mã sinh viên để đăng nhập (ví dụ: 0123456789 hoặc 9876543210).
                            </small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <p>Chưa có tài khoản? <a href="index.php?controller=Auth&action=register">Đăng ký ngay</a></p>
                        <p><a href="index.php" class="btn btn-link">Quay về trang chủ</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/shared/footer.php'; ?>