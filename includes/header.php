<?php
session_start();

// Check if user is logged in (for pages that require authentication)
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}

// Demo user data (in real application, get this from database)
$userData = [
    'id' => 1,
    'name' => 'مدير النظام',
    'email' => 'admin@dotask.com',
    'avatar' => 'https://via.placeholder.com/150',
    'role' => 'مدير',
    'notifications' => [
        ['id' => 1, 'text' => 'فشل في مهمة "تحديث البيانات"', 'time' => '10 دقائق', 'type' => 'error'],
        ['id' => 2, 'text' => 'استلام البيانات الجديدة بنجاح', 'time' => '30 دقيقة', 'type' => 'success'],
        ['id' => 3, 'text' => 'تم النسخ الاحتياطي بنجاح', 'time' => '2 ساعة', 'type' => 'info'],
    ]
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>doTask - نظام إدارة وأتمتة ذكي للمواقع</title>
    
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-tasks me-2"></i>doTask
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarTop">
                <form class="d-flex mx-auto" style="max-width: 400px;">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="البحث في النظام..." aria-label="Search">
                        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Notifications -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownNotifications" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge rounded-pill bg-danger"><?= count($userData['notifications']) ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="navbarDropdownNotifications" style="width: 300px;">
                            <div class="dropdown-header bg-primary text-white py-2">
                                الإشعارات (<?= count($userData['notifications']) ?>)
                            </div>
                            <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($userData['notifications'] as $notification): ?>
                                    <a class="dropdown-item py-2 border-bottom" href="#">
                                        <?php 
                                        $iconClass = 'text-info';
                                        $icon = 'info-circle';
                                        
                                        if ($notification['type'] == 'success') {
                                            $iconClass = 'text-success';
                                            $icon = 'check-circle';
                                        } else if ($notification['type'] == 'error') {
                                            $iconClass = 'text-danger';
                                            $icon = 'exclamation-circle';
                                        }
                                        ?>
                                        <i class="fas fa-<?= $icon ?> <?= $iconClass ?> me-2"></i>
                                        <span><?= $notification['text'] ?></span>
                                        <small class="text-muted d-block">منذ <?= $notification['time'] ?></small>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="dropdown-footer text-center py-2 border-top">
                                <a href="#" class="text-decoration-none">عرض كل الإشعارات</a>
                            </div>
                        </div>
                    </li>
                    
                    <!-- User Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $userData['avatar'] ?>" alt="User Avatar" class="rounded-circle me-1" style="width: 24px; height: 24px;">
                            <?= $userData['name'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>حسابي</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>الإعدادات</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="login.php?logout=1"><i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="d-flex">