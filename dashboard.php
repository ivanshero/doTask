<?php
// Include common header and sidebar
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Sample data for dashboard widgets
$totalTasks = 28;
$completedTasks = 17;
$pendingTasks = 9;
$failedTasks = 2;

// Sample data for activity log
$activityLog = [
    ['time' => '2025-03-18 23:40', 'type' => 'task', 'message' => 'تم إكمال مهمة "تحديث قاعدة البيانات" بنجاح'],
    ['time' => '2025-03-18 23:30', 'type' => 'system', 'message' => 'تم تنفيذ النسخ الاحتياطي اليومي بنجاح'],
    ['time' => '2025-03-18 22:15', 'type' => 'user', 'message' => 'تسجيل دخول المستخدم admin'],
    ['time' => '2025-03-18 21:45', 'type' => 'task', 'message' => 'فشل تنفيذ مهمة "تحديث البيانات التلقائي"'],
    ['time' => '2025-03-18 20:30', 'type' => 'system', 'message' => 'تم تحديث النظام إلى الإصدار 1.2.0']
];
?>

<div class="container-fluid py-4">
    <h3 class="mb-4">لوحة التحكم</h3>
    
    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي المهام</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalTasks ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                المهام المكتملة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $completedTasks ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                المهام قيد الانتظار</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingTasks ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                المهام الفاشلة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $failedTasks ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">أداء المهام (آخر 30 يوم)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="tasksPerformanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">توزيع حالة المهام</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="tasksStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">سجل النشاط</h6>
        </div>
        <div class="card-body">
            <div class="activity-feed">
                <?php foreach ($activityLog as $activity): ?>
                <div class="feed-item">
                    <div class="date text-muted small"><?= $activity['time'] ?></div>
                    <div class="activity-content">
                        <?php if ($activity['type'] === 'task'): ?>
                            <i class="fas fa-tasks text-primary me-2"></i>
                        <?php elseif ($activity['type'] === 'system'): ?>
                            <i class="fas fa-cog text-secondary me-2"></i>
                        <?php elseif ($activity['type'] === 'user'): ?>
                            <i class="fas fa-user text-info me-2"></i>
                        <?php endif; ?>
                        <?= $activity['message'] ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Tasks Performance Chart
const perfCtx = document.getElementById('tasksPerformanceChart').getContext('2d');
new Chart(perfCtx, {
    type: 'line',
    data: {
        labels: ['18/02', '23/02', '28/02', '05/03', '10/03', '15/03', '18/03'],
        datasets: [
            {
                label: 'المهام المكتملة',
                data: [3, 5, 8, 12, 15, 16, 17],
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: 'المهام الجديدة',
                data: [5, 8, 12, 15, 20, 25, 28],
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// Tasks Status Pie Chart
const statusCtx = document.getElementById('tasksStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['مكتملة', 'قيد الانتظار', 'فاشلة'],
        datasets: [{
            data: [<?= $completedTasks ?>, <?= $pendingTasks ?>, <?= $failedTasks ?>],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

<!-- Custom styles for activity feed -->
<style>
.activity-feed {
    padding: 15px;
}
.feed-item {
    position: relative;
    padding-bottom: 15px;
    padding-left: 30px;
    border-left: 2px solid #e9ecef;
    margin-bottom: 15px;
}
.feed-item:last-child {
    border-color: transparent;
}
.feed-item::after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: -8px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: white;
    border: 2px solid #e9ecef;
}
.feed-item .activity-content {
    position: relative;
}
</style>

<?php
require_once 'includes/footer.php';
?>