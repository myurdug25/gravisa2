<?php
/**
 * Admin Giriş
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/security.php';

secureSessionStart();

if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrf()) {
        $error = 'Güvenlik doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.';
    } else {
        $user = trim($_POST['user'] ?? '');
        $pass = $_POST['pass'] ?? '';
        if ($user !== '' && $user === ADMIN_USER && $pass !== '' && $pass === ADMIN_PASS) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_time'] = time();
            header('Location: index.php');
            exit;
        }
        $error = 'Kullanıcı adı veya şifre hatalı.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Giriş | Gravisa</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'DM Sans', sans-serif; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(165deg, #dbe4f0 0%, #e8eef5 50%, #f0f4f9 100%); }
    .login-box { background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 8px 32px rgba(30,95,138,0.12); border: 1px solid rgba(30,95,138,0.1); width: 100%; max-width: 380px; }
    .login-box h1 { margin: 0 0 24px; font-size: 1.5rem; color: #1e5f8a; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; font-size: 0.9rem; }
    .form-group input { width: 100%; padding: 12px 14px; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; font-family: inherit; }
    .form-group input:focus { outline: none; border-color: #1e5f8a; box-shadow: 0 0 0 3px rgba(30,95,138,0.15); }
    .btn { width: 100%; padding: 14px; background: linear-gradient(135deg, #1e5f8a, #164a6e); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; font-family: inherit; }
    .btn:hover { opacity: 0.95; }
    .error { background: #fee; color: #c00; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; }
    .back { display: inline-block; margin-top: 20px; color: #1e5f8a; text-decoration: none; font-size: 0.9rem; }
    .back:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="login-box">
    <h1>Gravisa Admin</h1>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
      <?php echo csrfField(); ?>
      <div class="form-group">
        <label for="user">Kullanıcı Adı</label>
        <input type="text" id="user" name="user" required autofocus />
      </div>
      <div class="form-group">
        <label for="pass">Şifre</label>
        <input type="password" id="pass" name="pass" required />
      </div>
      <button type="submit" class="btn">Giriş Yap</button>
    </form>
    <a href="../" class="back">← Siteye Dön</a>
  </div>
</body>
</html>
