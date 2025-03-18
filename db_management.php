<?php
// Include common header and sidebar
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// If form submitted, handle the database connection logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $server   = $_POST['server']   ?? 'localhost';
    $port     = $_POST['port']     ?? '3306';
    $dbType   = $_POST['dbType']   ?? 'mysql';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $useSSL   = isset($_POST['ssl']) ? true : false;
    
    // Attempt connection (sample code)
    try {
        $dsn = "$dbType:host=$server;port=$port;";
        $pdoTest = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // For SSL, depends on driver support
        ]);
        $connectionStatus = "اتصال ناجح بالقاعدة!";
        // Additional logic: retrieve database info, table stats, etc.
    } catch (PDOException $e) {
        $connectionStatus = "فشل الاتصال: " . $e->getMessage();
    }
}

// Sample data for tables list
$tablesData = [
    ['name' => 'users',       'rows' => 150, 'size_mb' => 1.2],
    ['name' => 'products',    'rows' => 320, 'size_mb' => 2.1],
    ['name' => 'orders',      'rows' => 90,  'size_mb' => 1.7],
    ['name' => 'logs',        'rows' => 800, 'size_mb' => 4.0]
];
?>
<div class="container-fluid py-4">
    <h3 class="mb-4">إدارة قواعد البيانات</h3>
    <!-- Connection Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">إعدادات الاتصال</div>
        <div class="card-body">
            <?php if (!empty($connectionStatus)): ?>
                <div class="alert alert-info"><?php echo $connectionStatus; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="server" class="form-label">اسم السيرفر</label>
                        <input type="text" class="form-control" id="server" name="server" required>
                    </div>
                    <div class="col-md-2">
                        <label for="port" class="form-label">المنفذ</label>
                        <input type="text" class="form-control" id="port" name="port" value="3306" required>
                    </div>
                    <div class="col-md-3">
                        <label for="dbType" class="form-label">نوع قاعدة البيانات</label>
                        <select class="form-select" id="dbType" name="dbType">
                            <option value="mysql" selected>MySQL</option>
                            <option value="pgsql">PostgreSQL</option>
                            <option value="sqlsrv">SQL Server</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label style="visibility:hidden;display:block;">SSL</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="ssl" name="ssl">
                            <label class="form-check-label" for="ssl">استخدام SSL</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="username" class="form-label">اسم المستخدم</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="col-md-4">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">فحص وتحليل قاعدة البيانات</button>
            </form>
        </div>
    </div>

    <!-- Tables Info and Charts -->
    <div class="row">
        <div class="col-md-7">
            <div class="card h-100 mb-4">
                <div class="card-header bg-secondary text-white">الجداول وتحليل الحجم</div>
                <div class="card-body">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>اسم الجدول</th>
                                <th>عدد السجلات</th>
                                <th>الحجم (MB)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tablesData as $table): ?>
                            <tr>
                                <td><?php echo $table['name']; ?></td>
                                <td><?php echo $table['rows']; ?></td>
                                <td><?php echo $table['size_mb']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">استخدام الجداول</div>
                <div class="card-body">
                    <canvas id="tablesUsageChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('tablesUsageChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['users', 'products', 'orders', 'logs'],
        datasets: [{
            data: [1.2, 2.1, 1.7, 4.0], 
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
<?php
require_once 'includes/footer.php';