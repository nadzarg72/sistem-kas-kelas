document.addEventListener("DOMContentLoaded", function () {
    
    // ===========================================
    // 1. DARK MODE TOGGLE LOGIC
    // ===========================================
    const toggleBtn = document.getElementById('theme-toggle');
    const body = document.body;
    
    // Cek Local Storage saat load
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark' : 'light');
        });
    }

    // ===========================================
    // 2. NAVBAR SCROLL EFFECT
    // ===========================================
    const navbar = document.querySelector('.navbar');
    
    // Cek apakah kita ada di halaman dashboard (cek elemen khusus dashboard)
    const isDashboard = document.querySelector('.dash-card') !== null;

    if (isDashboard) {
        // Kalau di Dashboard, navbar selalu solid
        if(navbar) navbar.classList.add('scrolled');
    } else {
        // Kalau di Home/Login, navbar transparan dulu baru solid pas scroll
        window.addEventListener('scroll', function () {
            if (navbar) {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
        });
    }

    // ===========================================
    // 3. ANIMATION OBSERVER (FADE IN ON SCROLL)
    // ===========================================
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                if (entry.target.classList.contains('slide-left')) entry.target.classList.add('slide-reset');
                if (entry.target.classList.contains('slide-right')) entry.target.classList.add('slide-reset');
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.hidden, .slide-left, .slide-right').forEach((el) => observer.observe(el));
});

