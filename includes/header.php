<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get user information from database
require_once('db_connect.php');
$stmt = $pdo->prepare("SELECT username, full_name, role, avatar FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Get unread notifications count
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0");
$stmt->execute([$_SESSION['user_id']]);
$notifications = $stmt->fetch();
$notif_count = $notifications['count'] ?? 0;

// Get current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام الإدارة والأتمتة الذكي</title>
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Load theme preference -->
    <script>
        // Check for saved theme preference or OS preference
        const theme = localStorage.getItem('theme') || 
                     (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
        // Apply theme class to document
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        }
    </script>
</head>
<body>
<!-- Top navigation bar -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Sidebar toggle button (for mobile) -->
        <button class="btn btn-link text-white d-lg-none me-2" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Brand/logo -->
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <img src="img/logo.svg" alt="Logo" height="30" class="d-inline-block me-2">
            <span>نظام الإدارة والأتمتة الذكي</span>
        </a>

        <!-- Search form -->
        <form class="d-none d-md-flex ms-auto me-3" role="search">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="بحث سريع..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <!-- Right navbar items -->
        <ul class="navbar-nav align-items-center">
            <!-- Theme toggler -->
            <li class="nav-item me-3">
                <button id="themeToggle" class="btn btn-link nav-link text-white">
                    <i class="bi bi-sun-fill theme-icon-light"></i>
                    <i class="bi bi-moon-fill theme-icon-dark"></i>
                </button>
            </li>

            <!-- Fullscreen toggle -->
            <li class="nav-item me-3">
                <button id="fullscreenToggle" class="btn btn-link nav-link text-white">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>
            </li>

            <!-- Notifications dropdown -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    <?php if ($notif_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $notif_count; ?>
                    </span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                    <li>
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">الإشعارات</h6>
                            <?php if ($notif_count > 0): ?>
                            <a href="#" class="text-decoration-none small">تعيين الكل كمقروء</a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    
                    <?php
                    // Get recent notifications
                    $stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
                    $stmt->execute([$_SESSION['user_id']]);
                    $notifications = $stmt->fetchAll();
                    
                    if (count($notifications) > 0):
                        foreach ($notifications as $notification):
                            $icon_class = '';
                            switch ($notification['type']) {
                                case 'success': $icon_class = 'bi-check-circle text-success'; break;
                                case 'warning': $icon_class = 'bi-exclamation-triangle text-warning'; break;
                                case 'danger': $icon_class = 'bi-x-circle text-danger'; break;
                                default: $icon_class = 'bi-bell text-primary';
                            }
                    ?>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo $notification['link']; ?>">
                            <div class="notification-icon me-3">
                                <i class="bi <?php echo $icon_class; ?> fs-5"></i>
                            </div>
                            <div>
                                <p class="mb-1 fw-bold"><?php echo htmlspecialchars($notification['title']); ?></p>
                                <p class="mb-0 small text-muted"><?php echo htmlspecialchars($notification['message']); ?></p>
                                <small class="text-muted"><?php echo date('Y-m-d H:i', strtotime($notification['created_at'])); ?></small>
                            </div>
                        </a>
                    </li>
                    <?php 
                        endforeach;
                    else:
                    ?>
                    <li>
                        <div class="text-center p-3">
                            <i class="bi bi-bell-slash fs-4"></i>
                            <p>لا توجد إشعارات جديدة</p>
                        </div>
                    </li>
                    <?php endif; ?>
                    
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-