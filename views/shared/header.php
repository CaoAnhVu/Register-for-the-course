<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUTECH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            
        }
        .navbar {
            margin-bottom: 20px;
            background-color: #3d3e40 !important;
        }
        .nav-item.active .nav-link {
            font-weight: bold;
            color: #fff !important;
        }
        .user-name {
            color: #fff;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">HUTECH</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item <?php echo isset($_GET['controller']) && $_GET['controller'] == 'SinhVien' ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php?controller=SinhVien&action=index">Sinh Viên</a>
                    </li>
                    <li class="nav-item <?php echo isset($_GET['controller']) && $_GET['controller'] == 'HocPhan' ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php?controller=HocPhan&action=index">Học Phần</a>
                    </li>
                    <?php if(isset($_SESSION['MaSV'])): ?>
                    <li class="nav-item <?php echo isset($_GET['controller']) && $_GET['controller'] == 'DangKy' ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php?controller=DangKy&action=index">Đăng Kí Học Phần</a>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <div class="d-flex justify-content-end align-items-center">
                    <?php if(isset($_SESSION['MaSV'])): ?>
                        <span class="user-name">
                            <i class="fas fa-user"></i>
                            Xin chào, <?php echo $_SESSION['HoTen']; ?> (<?php echo $_SESSION['MaSV']; ?>)
                        </span>
                        <a href="index.php?controller=Auth&action=logout" class="btn btn-outline-light">Đăng Xuất</a>
                    <?php else: ?>
                        <a href="index.php?controller=Auth&action=login" class="btn btn-outline-light me-2">Đăng Nhập</a>
                        <a href="index.php?controller=Auth&action=register" class="btn btn-primary">Đăng Ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>