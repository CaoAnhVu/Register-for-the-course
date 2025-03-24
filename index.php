<?php
// Bắt đầu session để quản lý đăng nhập
session_start();

// Lấy controller và action từ URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Nạp controller tương ứng
$controllerName = $controller . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controllerName();
    
    // Gọi action tương ứng
    if (method_exists($controllerInstance, $action)) {
        if ($id !== null) {
            $controllerInstance->$action($id);
        } else {
            $controllerInstance->$action();
        }
    } else {
        // Action không tồn tại
        echo "Action '$action' không tồn tại trong controller '$controllerName'!";
    }
} else {
    // Controller không tồn tại
    echo "Controller '$controllerName' không tồn tại!";
}
?>