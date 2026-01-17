<?php 
session_start();
include 'config/koneksi.php';

// 1. Cek Login
if(!isset($_SESSION['login'])){ header("Location: login.php"); exit; }

// 2. Cek Validitas ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID Transaksi tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id'");

// 3. Cek Apakah Data Ada
if(mysqli_num_rows($query) == 0) {
    echo "<script>alert('Data transaksi tidak ada di database!'); window.location='dashboard.php';</script>";
    exit;
}

$d = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #0f172a; overflow-x: hidden; color: #fff; }
        .video-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px); z-index: -1; }
        .container { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .glass-card { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 0; width: 100%; max-width: 850px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); overflow: hidden; display: flex; flex-direction: column; animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .card-header { padding: 30px 40px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.02); }
        .card-header h2 { font-size: 1.5rem; font-weight: 600; color: #fff; }
        .card-header p { color: #94a3b8; font-size: 0.85rem; margin-top: 5px; }
        .header-icon { width: 45px; height: 45px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); }
        .card-body { padding: 40px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
        .input-wrapper { margin-bottom: 20px; position: relative; }
        .input-label { display: block; font-size: 0.75rem; font-weight: 600; color: #cbd5e1; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
        .custom-input, .custom-select, .custom-textarea { width: 100%; padding: 14px 16px; background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; color: #fff; font-size: 0.95rem; transition: all 0.3s ease; outline: none; }
        .custom-input:focus, .custom-textarea:focus { border-color: #2563eb; background: rgba(0, 0, 0, 0.4); box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        .radio-group { display: flex; gap: 15px; background: rgba(0,0,0,0.2); padding: 5px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05); }
        .radio-label { flex: 1; text-align: center; padding: 10px; cursor: pointer; border-radius: 8px; transition: 0.3s; font-weight: 500; font-size: 0.9rem; color: #94a3b8; }
        .radio-input { display: none; }
        .radio-input:checked + .radio-label { color: #fff; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .radio-input[value="Masuk"]:checked + .radio-label { background: #16a34a; }
        .radio-input[value="Keluar"]:checked + .radio-label { background: #dc2626; }
        .btn-group { display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; }
        .btn-save { padding: 12px 30px; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); }
        .btn-back { padding: 12px 25px; background: transparent; color: #94a3b8; border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; text-decoration: none; font-weight: 500; transition: 0.3s; display: flex; align-items: center; gap: 8px; }
        .btn-back:hover { border-color: #fff; color: #fff; background: rgba(255,255,255,0.05); }
        .float-back { position: absolute; top: 30px; left: 30px; color: #cbd5e1; text-decoration: none; font-weight: 500; display: flex; align-items: center; gap: 10px; padding: 10px 20px; background: rgba(0,0,0,0.3); border-radius: 30px; border: 1px solid rgba(255,255,255,0.1); transition: 0.3s; z-index: 10; }
        .float-back:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: #fff; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <video autoplay muted loop class="video-bg">
        <source src="assets/video/background.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>

    <a href="dashboard.php" class="float-back">
        <i class="fas fa-times"></i> Batal Edit
    </a>

    <div class="container">
        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2>Edit Data Transaksi</h2>
                    <p>Perubahan data akan langsung disimpan ke database.</p>
                </div>
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
            </div>

            <div class="card-body">
                <form action="proses/edit_transaksi.php" method="POST">
                    <input type="hidden" name="id" value="<?= $d['id_transaksi']; ?>">

                    <div class="form-grid">
                        <div>
                            <div class="input-wrapper">
                                <label class="input-label">Jenis Transaksi</label>
                                <div class="radio-group">
                                    <input type="radio" id="masuk" name="jenis" value="Masuk" class="radio-input" <?= ($d['jenis']=='Masuk')?'checked':''; ?>>
                                    <label for="masuk" class="radio-label"><i class="fas fa-arrow-down"></i> Pemasukan</label>
                                    
                                    <input type="radio" id="keluar" name="jenis" value="Keluar" class="radio-input" <?= ($d['jenis']=='Keluar')?'checked':''; ?>>
                                    <label for="keluar" class="radio-label"><i class="fas fa-arrow-up"></i> Pengeluaran</label>
                                </div>
                            </div>

                            <div class="input-wrapper">
                                <label class="input-label">Tanggal</label>
                                <input type="date" name="tanggal" class="custom-input" value="<?= $d['tanggal']; ?>" required style="color-scheme: dark;">
                            </div>

                            <div class="input-wrapper">
                                <label class="input-label">Nominal (Rp)</label>
                                <input type="number" name="nominal" class="custom-input" value="<?= $d['nominal']; ?>" style="font-size: 1.1rem; font-weight: bold; color: #60a5fa;" required>
                            </div>
                        </div>

                        <div>
                            <div class="input-wrapper">
                                <label class="input-label">Pihak Terkait</label>
                                <input type="text" name="pihak_terkait" class="custom-input" value="<?= $d['pihak_terkait']; ?>" required>
                            </div>

                            <div class="input-wrapper">
                                <label class="input-label">Keterangan / Catatan</label>
                                <textarea name="keterangan" rows="5" class="custom-textarea"><?= $d['keterangan']; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group">
                        <a href="dashboard.php" class="btn-back">Batal</a>
                        <button type="submit" class="btn-save">
                            Update Data <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>