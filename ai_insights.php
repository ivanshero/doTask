<?php
// Include common header and sidebar
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Current date and time data from user input
$current_datetime = "2025-03-18 23:58:34";
$current_user = "ivanshero";

// Sample insights data
$recentInsights = [
    [
        'id' => 1,
        'title' => 'تحليل نمط زيارات الموقع',
        'date' => '2025-03-18',
        'summary' => 'تظهر البيانات زيادة بنسبة 23% في معدل الزيارات من الأجهزة المحمولة مقارنة بالشهر السابق.',
        'type' => 'traffic',
        'status' => 'positive'
    ],
    [
        'id' => 2,
        'title' => 'تنبيه أمان: محاولات تسجيل دخول مشبوهة',
        'date' => '2025-03-18',
        'summary' => 'تم اكتشاف 15 محاولة تسجيل دخول فاشلة من عناوين IP مختلفة خلال الساعة الماضية.',
        'type' => 'security',
        'status' => 'negative'
    ],
    [
        'id' => 3,
        'title' => 'تحليل أداء قاعدة البيانات',
        'date' => '2025-03-17',
        'summary' => 'تم تحديد 3 استعلامات تستغرق وقتًا طويلاً تؤثر على أداء النظام. يوصى بتحسين هذه الاستعلامات.',
        'type' => 'database',
        'status' => 'warning'
    ],
    [
        'id' => 4,
        'title' => 'تنبؤات حركة المرور المستقبلية',
        'date' => '2025-03-16',
        'summary' => 'يُتوقع زيادة في حركة المرور بنسبة 35% خلال عطلة نهاية الأسبوع القادمة بناءً على البيانات التاريخية.',
        'type' => 'prediction',
        'status' => 'info'
    ]
];

// Sample performance metrics
$performanceMetrics = [
    'page_load' => ['current' => 1.8, 'previous' => 2.5, 'unit' => 'ثانية', 'change' => 'down'],
    'server_response' => ['current' => 320, 'previous' => 390, 'unit' => 'مللي ثانية', 'change' => 'down'],
    'cpu_usage' => ['current' => 42, 'previous' => 37, 'unit' => '%', 'change' => 'up'],
    'memory_usage' => ['current' => 65, 'previous' => 58, 'unit' => '%', 'change' => 'up']
];

// Sample anomaly detection data
$anomalyData = [
    'labels' => ["01/03", "02/03", "03/03", "04/03", "05/03", "06/03", "07/03", "08/03", "09/03", "10/03", 
                "11/03", "12/03", "13/03", "14/03", "15/03", "16/03", "17/03", "18/03"],
    'values' => [15, 12, 18, 14, 15, 16, 17, 15, 14, 16, 17, 16, 15, 16, 38, 17, 16, 15],
    'threshold' => 25,
    'anomalyIndex' => 14
];
?>

<div class="container-fluid py-4">
    <h3 class="mb-4">الذكاء الاصطناعي والتحليلات</h3>
    
    <!-- AI Assistant Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">المساعد الذكي</h5>
            <div>
                <span class="badge bg-light text-primary">متصل</span>
                <i class="fas fa-robot ms-2"></i>
            </div>
        </div>
        <div class="card-body">
            <div class="ai-chat-container" style="height: 300px; overflow-y: auto; background-color: #f8f9fa; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1rem;">
                <div class="message system-message mb-3">
                    <div class="message-content bg-light p-3 rounded">
                        <strong>المساعد الذكي:</strong> مرحبًا <?= $current_user ?>! كيف يمكنني مساعدتك اليوم؟
                    </div>
                    <small class="text-muted"><?= $current_datetime ?></small>
                </div>
                <div class="message user-message mb-3 text-end">
                    <div class="message-content bg-primary text-white p-3 rounded">
                        <strong>أنت:</strong> هل يمكنك تحليل أداء الموقع خلال الأسبوع الماضي؟
                    </div>
                    <small class="text-muted"><?= $current_datetime ?></small>
                </div>
                <div class="message system-message mb-3">
                    <div class="message-content bg-light p-3 rounded">
                        <strong>المساعد الذكي:</strong> بالتأكيد! بناءً على تحليلي للبيانات، لاحظت تحسنًا بنسبة 18% في وقت استجابة الصفحات مقارنة بالأسبوع الماضي. ومع ذلك، هناك ارتفاع في استخدام وحدة المعالجة المركزية بنسبة 5% قد يتطلب منك التحقق من عمليات الخادم. سأقوم بإنشاء تقرير مفصل إذا كنت ترغب في ذلك.
                    </div>
                    <small class="text-muted"><?= $current_datetime ?></small>
                </div>
            </div>
            <form class="d-flex">
                <input type="text" class="form-control me-2" placeholder="اكتب سؤالك هنا...">
                <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i> إرسال</button>
            </form>
        </div>
    </div>
    
    <!-- Performance Metrics Section -->
    <div class="row mb-4">
        <?php foreach ($performanceMetrics as $key => $metric): ?>
        <div class="col-md-3">
            <div class="card shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php 
                            $title = '';
                            $icon = '';
                            switch($key) {
                                case 'page_load': 
                                    $title = 'وقت تحميل الصفحة';
                                    $icon = 'fa-clock';
                                    break;
                                case 'server_response':
                                    $title = 'وقت استجابة الخادم';
                                    $icon = 'fa-server';
                                    break;
                                case 'cpu_usage':
                                    $title = 'استخدام المعالج';
                                    $icon = 'fa-microchip';
                                    break;
                                case 'memory_usage':
                                    $title = 'استخدام الذاكرة';
                                    $icon = 'fa-memory';
                                    break;
                            }
                            ?>
                            <h6 class="text-muted mb-1"><?= $title ?></h6>
                            <h3 class="mb-0"><?= $metric['current'] ?> <small class="text-muted"><?= $metric['unit'] ?></small></h3>
                        </div>
                        <div class="p-3 rounded-circle bg-light">
                            <i class="fas <?= $icon ?> fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <?php 
                        $changeClass = $metric['change'] === 'down' ? 'text-success' : 'text-danger';
                        $changeIcon = $metric['change'] === 'down' ? 'fa-arrow-down' : 'fa-arrow-up';
                        
                        // Calculate percentage change
                        $diff = abs($metric['current'] - $metric['previous']);
                        $percentChange = round(($diff / $metric['previous']) * 100);
                        
                        // Flip the sense for load time and response time (lower is better)
                        if (($key === 'page_load' || $key === 'server_response') && $metric['change'] === 'down') {
                            $changeClass = 'text-success';
                        } else if (($key === 'page_load' || $key === 'server_response') && $metric['change'] === 'up') {
                            $changeClass = 'text-danger';
                        }
                        ?>
                        <small class="<?= $changeClass ?>">
                            <i class="fas <?= $changeIcon ?>"></i> <?= $percentChange ?>% منذ آخر قياس
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Data Insights Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">كشف الشذوذ في البيانات</h6>
                    <div>
                        <select class="form-select form-select-sm" style="width: auto; display: inline-block;">
                            <option>الزيارات اليومية</option>
                            <option>معدل التحويل</option>
                            <option>حجم البيانات</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="anomalyDetectionChart"></canvas>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>تم اكتشاف شذوذ!</strong> زيادة مفاجئة في البيانات بتاريخ 15/03. قد يشير هذا إلى نشاط غير طبيعي يتطلب التحقيق.
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">توقعات الذكاء الاصطناعي</h6>
                </div>
                <div class="card-body">
                    <div class="ai-prediction mb-4">
                        <h6>الزيارات المتوقعة (7 أيام قادمة)</h6>
                        <h3 class="display-5 mb-2">15,280</h3>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: 65%"></div>
                        </div>
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> زيادة متوقعة بنسبة 12%
                        </small>
                    </div>
                    <div class="ai-prediction mb-4">
                        <h6>حجم البيانات المتوقع</h6>
                        <h3 class="display-5 mb-2">2.4GB</h3>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" style="width: 48%"></div>
                        </div>
                        <small class="text-warning">
                            <i class="fas fa-arrow-up"></i> زيادة متوقعة بنسبة 8%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Insights -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">آخر التحليلات الذكية</h6>
            <button class="btn btn-sm btn-outline-primary">عرض الكل</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>العنوان</th>
                            <th>التاريخ</th>
                            <th>النوع</th>
                            <th>الملخص</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentInsights as $insight): ?>
                        <tr>
                            <td><strong><?= $insight['title'] ?></strong></td>
                            <td><?= $insight['date'] ?></td>
                            <td>
                                <?php 
                                $badgeClass = '';
                                $iconClass = '';
                                
                                switch($insight['type']) {
                                    case 'traffic': 
                                        $badgeClass = 'bg-info';
                                        $iconClass = 'fa-chart-line';
                                        break;
                                    case 'security':
                                        $badgeClass = 'bg-danger';
                                        $iconClass = 'fa-shield-alt';
                