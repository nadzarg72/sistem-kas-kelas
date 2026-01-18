<?php include 'layouts/header.php'; ?>

<section class="hero" id="home">
    <video autoplay muted loop class="video-bg">
        <source src="assets/video/background.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>
    
    <div class="hero-content">
        <div class="hero-text hidden">
            <h1>Transparansi <br> <span style="color: var(--brand-orange);">Uang Kas</span> Kita</h1>
            <p>Sistem pencatatan keuangan kelas digital yang transparan dan akuntabel. Bergabunglah untuk pengelolaan dana yang lebih baik.</p>
            
            <div class="btn-group">
                <a href="<?= isset($_SESSION['login']) ? 'dashboard.php' : 'login.php'; ?>" class="btn-orange">Mulai Sekarang</a>
                <a href="#fitur" class="btn-outline">Pelajari Fitur</a>
            </div>
        </div>

        <div class="hero-card slide-right">
            <h3>Kenapa Memilih Kami</h3>
            <div class="stats-grid-hero">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                    <div class="stat-info">
                        <h4>100%</h4>
                        <span>Transparan</span>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-globe"></i></div>
                    <div class="stat-info">
                        <h4>24/7</h4>
                        <span>Akses online</span>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-database"></i></div>
                    <div class="stat-info">
                        <h4>Safe</h4>
                        <span>Data Aman</span>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <h4>Active</h4>
                        <span>Siswa Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container" id="fitur">
    <h2 class="section-title text-center hidden" style="margin-bottom:40px; font-size:2rem;">Fitur Utama</h2>
    <div class="features-grid">
        <div class="feature-card hidden">
            <i class="fas fa-search" style="font-size:2rem; color:var(--brand-orange); margin-bottom:15px;"></i>
            <h3>Jujur & Terbuka</h3>
            <p>Data keuangan dapat diakses oleh seluruh siswa secara real-time.</p>
        </div>
        <div class="feature-card hidden">
            <i class="fas fa-bolt" style="font-size:2rem; color:var(--brand-orange); margin-bottom:15px;"></i>
            <h3>Akses Cepat</h3>
            <p>Login dan pantau saldo kas kelas kapan saja melalui perangkat apapun.</p>
        </div>
        <div class="feature-card hidden">
            <i class="fas fa-chart-bar" style="font-size:2rem; color:var(--brand-orange); margin-bottom:15px;"></i>
            <h3>Visualisasi Data</h3>
            <p>Penyajian data menggunakan grafik interaktif untuk kemudahan analisis.</p>
        </div>
    </div>
</section>

<section id="about" class="container">
    <h2 class="text-center hidden" style="margin-bottom:80px; font-size:2rem;">Tim Pengembang</h2>
    
    <div class="member-row">
        <div class="member-text slide-left">
            <h2>Saputra</h2>
            <h4 style="color: var(--brand-orange);">PROJECT LEADER</h4>
            <p>Bertanggung jawab atas manajemen proyek dan alur sistem.</p>
        </div>
        <div class="member-img slide-right"><img src="assets/img/member1.png" alt="Member 1"></div>
    </div>

    <div class="member-row">
        <div class="member-text slide-right">
            <h2>Nadza</h2>
            <h4 style="color: var(--brand-orange);">DATABASE ENGINEER</h4>
            <p>Merancang dan mengelola struktur basis data MySQL.</p>
        </div>
        <div class="member-img slide-left"><img src="assets/img/member2.png" alt="Member 2"></div>
    </div>

    <div class="member-row">
        <div class="member-text slide-left">
            <h2>Rafli</h2>
            <h4 style="color: var(--brand-orange);">FRONTEND DEV</h4>
            <p>Mengembangkan antarmuka pengguna yang responsif.</p>
        </div>
        <div class="member-img slide-right"><img src="assets/img/member3.png" alt="Member 3"></div>
    </div>

    <div class="member-row">
        <div class="member-text slide-right">
            <h2>Teya</h2>
            <h4 style="color: var(--brand-orange);">QUALITY CONTROL</h4>
            <p>Melakukan pengujian sistem untuk memastikan fungsionalitas.</p>
        </div>
        <div class="member-img slide-left"><img src="assets/img/member4.png" alt="Member 4"></div>
    </div>
</section>

<?php include 'layouts/footer.php'; ?>