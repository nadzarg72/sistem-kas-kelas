<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kas Kita</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="auth-page">
        <video autoplay muted loop class="video-bg">
            <source src="assets/video/background.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="auth-glow-bg"></div>

        <div class="glass-card-login animate-entry delay-1">
            <h1 class="auth-brand">KAS <span style="color: var(--brand-orange);">KITA</span>.</h1>
            <p class="auth-desc">Silakan masuk untuk mengelola keuangan.</p>
            
            <form action="proses/login_proses.php" method="POST">
                <div class="input-modern">
                    <label>Username</label>
                    <input type="text" name="username" required autocomplete="off">
                </div>
                
                <div class="input-modern">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn-login-neon" style="background: var(--brand-orange);">
                    MASUK <i class="fas fa-arrow-right" style="margin-left:5px;"></i>
                </button>
            </form>

            <div class="auth-footer-link">
                <p>Belum punya akun? <a href="register.php" style="color: var(--brand-orange);">Daftar disini</a></p>
                <br>
                <a href="index.php" style="opacity: 0.6; font-size: 0.85rem;"><i class="fas fa-home"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

<script src="assets/js/scripts.js"></script>
</body>
</html>