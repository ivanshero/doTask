<?php
/**
 * Settings Page
 * Current Date and Time (UTC): 2025-03-19 00:00:09
 * Current User: ivanshero
 */

// Include common header and sidebar
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Handle form submissions
$settingsSaved = false;
$settingsError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real application, you would save these settings to the database
    // This is just a simulation
    $settingsSaved = true;
}

// Sample user data
$userData = [
    'name' => $userData['name'],
    'email' => $userData['email'],
    'role' => $userData['role'],
    'created_at' => '2025-01-15',
    'last_login' => '2025-03-19 00:00:09',
];

// Sample settings data
$settingsData = [
    'theme' => 'light',
    'language' => 'ar',
    'timezone' => 'Asia/Riyadh',
    'notifications_enabled' => true,
    'email_notifications' => true,
    'browser_notifications' => false,
    'sms_notifications' => false,
    'auto_backup' => true,
    'backup_frequency' => 'daily',
    'log_retention' => '30',
    'two_factor_auth' => false
];

// Available themes
$availableThemes = [
    'light' => 'الوضع الفاتح',
    'dark' => 'الوضع الداكن',
    'blue' => 'الأزرق',
    'green' => 'الأخضر',
    'purple' => 'الأرجواني'
];

// Available languages
$availableLanguages = [
    'ar' => 'العربية',
    'en' => 'الإنجليزية',
    'fr' => 'الفرنسية',
    'es' => 'الإسبانية'
];

// Available timezones (sample)
$availableTimezones = [
    'Asia/Riyadh' => 'الرياض (GMT+3)',
    'Asia/Dubai' => 'دبي (GMT+4)',
    'Asia/Baghdad' => 'بغداد (GMT+3)',
    'Africa/Cairo' => 'القاهرة (GMT+2)',
    'Europe/London' => 'لندن (GMT+0)',
    'America/New_York' => 'نيويورك (GMT-5)',
    'UTC' => 'التوقيت العالمي (UTC)'
];
?>

<div class="container-fluid py-4">
    <h3 class="mb-4">الإعدادات</h3>

    <?php if ($settingsSaved): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> تم حفظ الإعدادات بنجاح.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($settingsError): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> حدث خطأ أثناء حفظ الإعدادات. يرجى المحاولة مرة أخرى.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>