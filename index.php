 <?php
// index.php - Dashboard
require_once 'config.php';
requireLogin();

$conn = getConnection();

// Get statistics
$total_pegawai = $conn->query("SELECT COUNT(*) as total FROM pegawai")->fetch_assoc()['total'];
$total_jabatan = $conn->query("SELECT COUNT(*) as total FROM jabatan")->fetch_assoc()['total'];
$total_presensi_hari_ini = $conn->query("SELECT COUNT(*) as total FROM presensi WHERE tanggal_presensi = CURDATE()")->fetch_assoc()['total'];
$total_slip_bulan_ini = $conn->query("SELECT COUNT(*) as total FROM slip_gaji WHERE MONTH(periode_awal_slip_gaji) = MONTH(CURDATE())")->fetch_assoc()['total'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Penggajian</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar h1 { font-size: 24px; }
        .navbar .user-info { display: flex; gap: 20px; align-items: center; }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar a:hover { background: rgba(255,255,255,0.3); }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .menu-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .menu-card:hover { transform: translateY(-5px); }
        .menu-card h3 { color: #333; margin-bottom: 10px; }
        .menu-card .count {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        .menu-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: transform 0.2s;
        }
        .menu-card a:hover { transform: scale(1.05); }
        .main-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .main-menu a {
            background: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .main-menu a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Sistem Penggajian</h1>
        <div class="user-info">
            <span><?php echo htmlspecialchars($_SESSION['email']); ?> (<?php echo ucfirst($_SESSION['role']); ?>)</span>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2 style="margin-bottom: 20px;">Dashboard</h2>
        
        <div class="menu-grid">
            <div class="menu-card">
                <h3>Total Pegawai</h3>
                <div class="count"><?php echo $total_pegawai; ?></div>
                <a href="pegawai.php">Lihat Data</a>
            </div>
            <div class="menu-card">
                <h3>Total Jabatan</h3>
                <div class="count"><?php echo $total_jabatan; ?></div>
                <a href="jabatan.php">Lihat Data</a>
            </div>
            <div class="menu-card">
                <h3>Presensi Hari Ini</h3>
                <div class="count"><?php echo $total_presensi_hari_ini; ?></div>
                <a href="presensi.php">Lihat Data</a>
            </div>
            <div class="menu-card">
                <h3>Slip Gaji Bulan Ini</h3>
                <div class="count"><?php echo $total_slip_bulan_ini; ?></div>
                <a href="slip_gaji.php">Lihat Data</a>
            </div>
        </div>

        <h2 style="margin: 30px 0 20px 0;">Menu Utama</h2>
        <div class="main-menu">
            <?php if (isAdmin()): ?>
            <a href="pegawai.php">📋 Data Pegawai</a>
            <a href="jabatan.php">💼 Data Jabatan</a>
            <a href="jadwal.php">🕐 Data Jadwal</a>
            <?php endif; ?>
            <a href="presensi.php">✅ Presensi</a>
            <a href="slip_gaji.php">💰 Slip Gaji</a>
            <?php if (isAdmin()): ?>
            <a href="users.php">👥 Manajemen User</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>