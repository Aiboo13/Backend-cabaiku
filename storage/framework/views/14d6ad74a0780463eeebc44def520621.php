<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabaiku - Sistem Deteksi Penyakit Cabai</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;1,9..144,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/landing.css')); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo e(route('home', [], false)); ?>" class="logo">🌶️ Cabai<span>ku</span></a>
            <ul class="nav-links">
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#cara-kerja">Alur Penggunaan</a></li>
                <li><a href="#tentang">Tentang</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="<?php echo e(route('login', [], false)); ?>" class="btn btn-login js-auth-nav" data-target="<?php echo e(route('login', [], false)); ?>"><i class="fas fa-sign-in-alt" style="margin-right:6px;"></i>Masuk</a>
                <a href="<?php echo e(route('register', [], false)); ?>" class="btn btn-register js-auth-nav" data-target="<?php echo e(route('register', [], false)); ?>"><i class="fas fa-user-plus" style="margin-right:6px;"></i>Daftar</a>
            </div>
            <button class="menu-toggle" onclick="toggleMenu()"><i class="fas fa-bars"></i></button>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="#fitur">Fitur</a>
            <a href="#cara-kerja">Alur Penggunaan</a>
            <a href="#tentang">Tentang</a>
            <div class="nav-buttons">
                <a href="<?php echo e(route('login', [], false)); ?>" class="btn btn-login js-auth-nav" data-target="<?php echo e(route('login', [], false)); ?>">Masuk</a>
                <a href="<?php echo e(route('register', [], false)); ?>" class="btn btn-register js-auth-nav" data-target="<?php echo e(route('register', [], false)); ?>">Daftar</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Sistem Deteksi Penyakit Tanaman Cabai</h1>
            <p class="hero-subtitle">Aplikasi ini membantu petani maupun mahasiswa pertanian
                                    dalam mengenali kondisi kesehatan tanaman cabai melalui
                                    analisis gambar secara otomatis.</p>
            <div class="hero-buttons">
                <a href="<?php echo e(route('register', [], false)); ?>" class="btn btn-hero btn-hero-primary js-auth-nav" data-target="<?php echo e(route('register', [], false)); ?>"><i class="fas fa-rocket" style="margin-right:8px;"></i>Coba Sekarang</a>
                <a href="#fitur" class="btn btn-hero btn-hero-secondary"><i class="fas fa-info-circle" style="margin-right:8px;"></i>Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <section class="features" id="fitur">
        <h2 class="section-title">Fitur Unggulan</h2>
        <div class="features-grid">
            <div class="feature-card"><div class="feature-icon">🔬</div><h3>Deteksi AI Akurat</h3><p>Identifikasi penyakit cabai dengan akurasi tinggi menggunakan teknologi machine learning terdepan.</p></div>
            <div class="feature-card"><div class="feature-icon">📸</div><h3>Upload Foto Mudah</h3><p>Cukup ambil foto daun cabai yang terserang, dan AI akan menganalisis dalam hitungan detik.</p></div>
            <div class="feature-card"><div class="feature-icon">📊</div><h3>Riwayat Lengkap</h3><p>Pantau perkembangan kesehatan tanaman dan riwayat semua deteksi yang sudah dilakukan.</p></div>
            <div class="feature-card"><div class="feature-icon">🌱</div><h3>Panduan Perawatan</h3><p>Dapatkan rekomendasi penanganan penyakit yang tepat dari para ahli agronomi berpengalaman.</p></div>
            <div class="feature-card"><div class="feature-icon">🗺️</div><h3>Kelola Lahan</h3><p>Atur dan pantau data lahan cabai Anda dengan dashboard yang intuitif dan mudah digunakan.</p></div>
            <div class="feature-card"><div class="feature-icon">💡</div><h3>Tips & Artikel</h3><p>Baca artikel edukatif dan tips praktis untuk meningkatkan hasil panen Anda setiap hari.</p></div>
        </div>
    </section>

    <section class="how-it-works" id="cara-kerja">
        <div class="how-it-works-container">
            <h2 class="section-title">Alur Penggunaan</h2>
            <div class="steps-grid">
                <div class="step-card"><div class="step-number">1</div><h3>Buat Akun</h3><p>Daftar gratis dan buat akun Cabaiku Anda dalam waktu kurang dari 1 menit.</p></div>
                <div class="step-card"><div class="step-number">2</div><h3>Tambah Lahan</h3><p>Daftarkan informasi lahan cabai Anda untuk memulai monitoring dan deteksi.</p></div>
                <div class="step-card"><div class="step-number">3</div><h3>Foto & Deteksi</h3><p>Upload foto daun yang terserang, dan AI akan memberikan hasil analisis instan.</p></div>
                <div class="step-card"><div class="step-number">4</div><h3>Ikuti Rekomendasi</h3><p>Dapatkan panduan penanganan dan pantau perkembangan kesehatan tanaman Anda.</p></div>
            </div>
        </div>
    </section>

    <section class="cta" id="tentang">
        <div class="cta-content">
            <h2>Mari Pantau Kesehatan Tanaman Cabai Lebih Mudah</h2>
            <p>Aplikasi ini membantu pengguna mengenali kondisi tanaman cabai
            sejak dini melalui analisis gambar berbasis AI. Dengan pemantauan
            yang lebih sederhana, diharapkan perawatan tanaman menjadi lebih
            tepat dan hasil panen dapat terjaga dengan baik.</p>
            <a href="<?php echo e(route('register', [], false)); ?>" class="btn btn-hero btn-hero-primary js-auth-nav" data-target="<?php echo e(route('register', [], false)); ?>"><i class="fas fa-user-plus" style="margin-right:8px;"></i>Daftar Sekarang</a>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="#fitur">Fitur</a>
                <a href="#cara-kerja">Cara Kerja</a>
                <a href="#tentang">Tentang Kami</a>
            </div>
            <div class="footer-copy">© 2024 Cabaiku. Semua hak dilindungi. Teknologi untuk pertanian yang lebih baik.</div>
        </div>
    </footer>

    <script src="<?php echo e(asset('js/landing.js')); ?>"></script>
</body>
</html>
<?php /**PATH D:\kuliah\semester4\projek semster 4\Backend-cabaiku\Backend-Cabaiku\resources\views/landing.blade.php ENDPATH**/ ?>