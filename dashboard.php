<?php 
include 'layouts/header.php'; 
include 'config/koneksi.php';

if(!isset($_SESSION['login'])){ header("Location: login.php"); exit; }

// --- Logic Data ---

// 1. Hitung Total Pemasukan
$q_masuk = mysqli_query($conn, "SELECT SUM(nominal) as total FROM transaksi WHERE jenis='Masuk'");
$masuk = mysqli_fetch_assoc($q_masuk)['total'];

// 2. Hitung Total Pengeluaran
$q_keluar = mysqli_query($conn, "SELECT SUM(nominal) as total FROM transaksi WHERE jenis='Keluar'");
$keluar = mysqli_fetch_assoc($q_keluar)['total'];

// 3. Hitung Saldo Akhir
$saldo = $masuk - $keluar;
?>

<div class="container" style="padding-top: 120px;">
    
    <div class="animate-entry delay-1" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <div>
            <h2 style="font-size:1.8rem; margin-bottom: 5px;">Dashboard</h2>
            <p style="color:var(--text-muted);">Selamat Datang, <span style="color:var(--brand-orange); font-weight:bold;"><?= $_SESSION['nama']; ?></span></p>
        </div>
        <div style="text-align:right;">
            <span style="color:var(--text-muted); font-size:0.9rem;">Saldo Kas</span><br>
            <span style="font-size:1.5rem; color:var(--accent-color); font-weight:bold;">
                Rp <span class="counter-anim" data-target="<?= $saldo; ?>">0</span>
            </span>
        </div>
    </div>

    <div class="stats-grid animate-entry delay-2">
        <div class="dash-card" style="border-left:4px solid var(--accent-color);">
            <h3 style="color:var(--text-muted); font-size:0.9rem;">Pemasukan Total</h3>
            <h2 style="font-size:1.5rem;">
                Rp <span class="counter-anim" data-target="<?= $masuk; ?>">0</span>
            </h2>
        </div>

        <div class="dash-card" style="border-left:4px solid var(--danger-color);">
            <h3 style="color:var(--text-muted); font-size:0.9rem;">Pengeluaran Total</h3>
            <h2 style="font-size:1.5rem;">
                Rp <span class="counter-anim" data-target="<?= $keluar; ?>">0</span>
            </h2>
        </div>

        <div class="dash-card" style="border-left:4px solid var(--brand-orange);">
            <h3 style="color:var(--text-muted); font-size:0.9rem;">Saldo Akhir</h3>
            <h2 style="font-size:1.5rem;">
                Rp <span class="counter-anim" data-target="<?= $saldo; ?>">0</span>
            </h2>
            <span style="font-size:0.75rem; color:var(--text-muted); margin-top:5px;">
                <i class="fas fa-wallet"></i> Total Kas Saat Ini
            </span>
        </div>
    </div>

    <div class="dashboard-main animate-entry delay-3">
        <div class="dash-card">
            <h3 style="margin-bottom:20px;">Statistik Kas</h3>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        
        <div class="dash-card" style="justify-content: flex-start;">
            <h3 style="margin-bottom:15px; color:var(--brand-orange);">Akses Cepat</h3>
            
            <?php if($_SESSION['role'] == 'admin'): ?>
                <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:20px;">Menu Bendahara:</p>
                <a href="tambah_data.php" class="btn-submit" style="text-align:center; display:block; text-decoration:none; margin:0; background: var(--brand-orange);">+ Input Transaksi</a>
                <div style="margin-top:20px; font-size:0.8rem; color:var(--text-muted);">
                    <i class="fas fa-info-circle"></i> Pastikan bukti transaksi disimpan dengan baik.
                </div>

            <?php else: ?>
                <div style="background: var(--input-bg); padding: 25px 20px; border-radius: 15px; text-align: center; border: 1px dashed var(--border-color);">
                    <div style="width: 60px; height: 60px; background: rgba(37, 99, 235, 0.1); color: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem;">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    
                    <h4 style="color: var(--text-color); margin-bottom: 5px;">Akses Siswa Aktif</h4>
                    <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.6;">
                        Pantau arus kas transparan. Mode admin dibatasi.
                    </p>
                    
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--border-color);">
                        <span style="font-size: 0.8rem; color: var(--brand-orange); font-weight: 600;">
                            <i class="fas fa-check-circle"></i> View Only Mode
                        </span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-wrapper animate-entry delay-4" style="max-height: 600px; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; position: sticky; top: 0; background: var(--card-bg); z-index: 10; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
            <h3>Riwayat Transaksi Lengkap</h3>
            <span style="font-size: 0.8rem; color: var(--text-muted);"><i class="fas fa-list"></i> Semua Data</span>
        </div>
        
        <table>
            <thead style="position: sticky; top: 45px; background: var(--card-bg); z-index: 5;">
                <tr>
                    <th>Tanggal</th>
                    <th>Pihak Terkait</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <?php if($_SESSION['role']=='admin'): ?><th>Aksi</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC");
                
                if(mysqli_num_rows($data) == 0){
                    echo "<tr><td colspan='5' style='text-align:center; padding:30px; color:var(--text-muted);'>Belum ada data transaksi.</td></tr>";
                }

                while($d = mysqli_fetch_array($data)){
                    $isMasuk = ($d['jenis'] == 'Masuk');
                    $warnaNominal = $isMasuk ? '#10b981' : '#ef4444'; 
                    $tanda = $isMasuk ? '+' : '-';
                ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($d['tanggal'])); ?></td>
                    <td><?= $d['pihak_terkait']; ?></td>
                    <td><span class="badge <?= $isMasuk ? 'badge-masuk' : 'badge-keluar'; ?>"><?= $d['jenis']; ?></span></td>
                    <td style="font-family:monospace; font-weight:bold; font-size:1rem; color: <?= $warnaNominal; ?>;">
                        <?= $tanda; ?> Rp <?= number_format($d['nominal']); ?>
                    </td>
                    <?php if($_SESSION['role']=='admin'): ?>
                    <td>
                        <a href="edit_data.php?id=<?= $d['id_transaksi']; ?>" style="color:var(--accent-color); text-decoration:none; margin-right:10px; font-weight:600;"><i class="fas fa-edit"></i></a>
                        <a href="proses/hapus_transaksi.php?id=<?= $d['id_transaksi']; ?>" onclick="return confirm('Hapus data ini permanen?')" style="color:var(--danger-color); text-decoration:none; font-weight:600;"><i class="fas fa-trash"></i></a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Config Chart JS
    const ctx = document.getElementById('myChart');
    const styles = getComputedStyle(document.body);
    
    const accentColor = styles.getPropertyValue('--accent-color').trim();
    const dangerColor = styles.getPropertyValue('--danger-color').trim();
    const textColor = styles.getPropertyValue('--text-muted').trim();
    const cardColor = styles.getPropertyValue('--card-bg').trim();
    const borderColor = styles.getPropertyValue('--border-color').trim();

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    label: 'Total Keuangan',
                    data: [<?= $masuk ?: 0 ?>, <?= $keluar ?: 0 ?>],
                    backgroundColor: [accentColor, dangerColor],
                    borderColor: [accentColor, dangerColor],
                    borderWidth: 0,
                    borderRadius: 8,
                    barThickness: 45,
                    hoverBackgroundColor: [accentColor, dangerColor],
                    hoverBorderWidth: 4,
                    hoverBorderColor: cardColor,
                    hoverBorderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart',
                    delay: (context) => {
                        return context.dataIndex * 400; 
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: cardColor,
                        titleColor: textColor,
                        bodyColor: accentColor,
                        borderColor: borderColor,
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { 
                            color: textColor,
                            font: { family: "'Poppins', sans-serif" },
                            callback: function(value) {
                                if(value >= 1000000) return (value/1000000) + 'Jt';
                                if(value >= 1000) return (value/1000) + 'K';
                                return value;
                            }
                        }
                    },
                    y: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: textColor, font: {size: 13, weight: '600', family: "'Poppins', sans-serif"} }
                    }
                }
            }
        });
    }

    // Animasi Angka (Counter)
    const counters = document.querySelectorAll('.counter-anim');
    
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        const duration = 2000; 
        const frameDuration = 1000 / 60;
        const totalFrames = Math.round(duration / frameDuration);
        
        let frame = 0;
        const easeOutQuad = t => t * (2 - t);
        
        const updateCounter = () => {
            frame++;
            const progress = easeOutQuad(frame / totalFrames);
            const currentCount = Math.round(target * progress);

            counter.innerText = new Intl.NumberFormat('id-ID').format(currentCount);

            if (frame < totalFrames) {
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = new Intl.NumberFormat('id-ID').format(target);
            }
        };

        updateCounter();
    });
</script>

<?php include 'layouts/footer.php'; ?>