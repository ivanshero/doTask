<?php
// Start session
session_start();

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Handle login form submission
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('includes/db_connect.php');
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validate login credentials (sample code, replace with your actual validation)
    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session
            $_SESSION['user_id'] = $user['user_id'];
            
            // Set remember-me cookie if requested
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expiry = time() + (30 * 24 * 60 * 60); // 30 days
                
                // Store token in database
                $stmt = $pdo->prepare("INSERT INTO user_tokens (user_id, token, expires_at) VALUES (?, ?, FROM_UNIXTIME(?))");
                $stmt->execute([$user['user_id'], $token, $expiry]);
                
                // Set cookie
                setcookie('remember_token', $token, $expiry, '/', '', true, true);
            }
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة";
        }
    } else {
        $error_message = "يرجى إدخال اسم المستخدم وكلمة المرور";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام الإدارة والأتمتة الذكي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
        }
        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-header .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }
        .form-floating {
            margin-bottom: 1rem;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            font-size: 1.1rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <div class="login-header">
                        <img src="img/logo.svg" alt="Smart System Logo" class="logo">
                        <h3>نظام الإدارة والأتمتة الذكي</h3>
                        <p class="text-muted">سجل الدخول للوصول إلى لوحة التحكم</p>
                    </div>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="username" name="username" placeholder="اسم المستخدم" required>
                            <label for="username">اسم المستخدم</label>
                        </div>
                        
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور" required>
                            <label for="password">كلمة المرور</label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">تذكرني</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-login">تسجيل الدخول</button>
                        
                        <div class="text-center mt-3">
                            <a href="#" class="text-decoration-none">نسيت كلمة المرور؟</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>