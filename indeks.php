<?php

require_once "koneksi/database.php";

require_once "classes/Tiket.php";
require_once "classes/TiketRegular.php";
require_once "classes/TiketIMAX.php";
require_once "classes/TiketVelvet.php";

// Mengambil data cari dan mengamankannya dari SQL Injection
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

if($cari != '')
{
    $query = mysqli_query(
        $conn,
        "SELECT * FROM tabel_tiket WHERE nama_film LIKE '%$cari%'"
    );
}
else
{
    $query = mysqli_query(
        $conn,
        "SELECT * FROM tabel_tiket"
    );
}

// Siapkan wadah kosong untuk mengelompokkan tiket berdasarkan jenis studionya
$tiket_regular = [];
$tiket_imax = [];
$tiket_velvet = [];

// Kelompokkan data tiket dari database
while($data = mysqli_fetch_assoc($query)) {
    if($data['jenis_studio'] == 'Regular') {
        $tiket_regular[] = $data;
    } elseif($data['jenis_studio'] == 'IMAX') {
        $tiket_imax[] = $data;
    } else {
        $tiket_velvet[] = $data;
    }
}

$total = count($tiket_regular) + count($tiket_imax) + count($tiket_velvet);
?>

<!DOCTYPE html>
<html>
<head>
    <title>🎀 Pink Cinema Ticket 🎀</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --pink-primary: #ff69b4;
            --pink-hover: #ff1493;
            --pink-light: #ffe6f0;
            --pink-dark: #d63384;
            
            /* TRANSPARAN MURNI TANPA BACKGROUND PUTIH PADAT */
            --glass-bg: rgba(255, 255, 255, 0.2); 
            --glass-card: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-blur: blur(15px);
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* Menerapkan gambar pilihanmu sebagai background utama */
            background-image: url('https://i.pinimg.com/1200x/da/24/e9/da24e92ee56f8baba6bb2efca6749c38.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 40px 20px;
            color: #2c2c2c;
        }

        /* HEADER FULL TRANSPARAN */
        .header {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            padding: 40px 20px;
            border-radius: 30px;
            margin-bottom: 35px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.1);
            border: 1px solid var(--glass-border);
        }

        h1 {
            color: #d63384;
            font-size: 42px;
            font-weight: 700;
            margin: 10px 0 5px 0;
            text-shadow: 1px 1px 3px rgba(255,255,255,0.8);
        }

        .subtitle {
            color: #444;
            font-size: 16px;
            margin-bottom: 25px;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
        }

        /* Form Cari & Input */
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        input[type=text] {
            width: 320px;
            padding: 14px 20px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 15px;
            outline: none;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            color: #2c2c2c;
            font-weight: 600;
        }

        input[type=text]::placeholder {
            color: #666;
        }

        input[type=text]:focus {
            background: rgba(255, 255, 255, 0.7);
            border-color: var(--pink-primary);
            box-shadow: 0 0 10px rgba(255,105,180,0.2);
        }

        button[type=submit] {
            padding: 14px 25px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--pink-primary), #ff47a3);
            color: white;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255,105,180,0.25);
        }

        button[type=submit]:hover {
            background: linear-gradient(135deg, #ff47a3, var(--pink-hover));
            transform: translateY(-2px);
        }

        .reset-btn {
            display: inline-block;
            padding: 14px 25px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            color: var(--pink-dark);
            text-decoration: none;
            border-radius: 15px;
            font-weight: bold;
            border: 1px solid rgba(255, 255, 255, 0.4);
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .reset-btn:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        /* Summary Card */
        .summary-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 35px;
            text-align: center;
            border: 1px solid var(--glass-border);
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        }

        .summary-card h3 {
            margin: 0 0 5px 0;
            color: var(--pink-dark);
        }

        /* TATA LETAK 3 KOLOM VERTIKAL */
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            align-items: start;
            max-width: 1300px;
            margin: 0 auto;
        }

        .column-studio {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border-radius: 25px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--glass-border);
        }

        .column-banner {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
            opacity: 0.85;
        }

        .column-title {
            text-align: center;
            padding: 12px;
            border-radius: 15px;
            color: white;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 1px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .bg-regular { background: linear-gradient(135deg, rgba(255,182,217,0.85), rgba(255,163,204,0.85)); color: #b52263; }
        .bg-imax { background: linear-gradient(135deg, rgba(255,105,180,0.85), rgba(255,71,163,0.85)); color: white; }
        .bg-velvet { background: linear-gradient(135deg, rgba(214,51,132,0.85), rgba(181,26,105,0.85)); color: white; }

        /* KARTU TIKET BENING ELEGAN */
        .card {
            background: var(--glass-card);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 22px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-left: 8px solid #ff8dc7;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Efek Hover Mengambang */
        .card:hover {
            transform: translateY(-8px) scale(1.02);
            background: rgba(255, 255, 255, 0.45);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 12px 25px rgba(255,105,180,0.15);
        }

        .regular { border-left-color: rgba(255,182,217,1); }
        .imax { border-left-color: rgba(255,105,180,1); }
        .velvet { border-left-color: rgba(214,51,132,1); }

        .card h3 {
            color: #1a1a1a;
            margin-top: 0;
            font-size: 18px;
            font-weight: 700;
            border-bottom: 1px dashed rgba(255,105,180,0.3);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .label {
            font-weight: 600;
            color: #b51a69;
            display: inline-block;
            width: 120px;
        }

        .card p {
            margin: 8px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .harga {
            font-size: 22px;
            color: #ff1493;
            font-weight: 700;
            margin-top: 15px !important;
            padding-top: 10px;
            border-top: 1px dashed rgba(255,105,180,0.3);
            justify-content: space-between;
            text-shadow: 1px 1px 1px rgba(255,255,255,0.4);
        }

        /* Responsif HP */
        @media (max-width: 992px) {
            .dashboard-container { grid-template-columns: 1fr; }
            input[type=text] { width: 100%; }
        }
    </style>
</head>

<body>

<div class="header">
    <h1>🎀 Zia Cinema Ticket 🎀</h1>
    <div class="subtitle">✨ Sistem Manajemen Tiket Bioskop Berbasis PHP OOP ✨</div>

    <form action="" method="GET">
        <input
            type="text"
            name="cari"
            placeholder="🔍 Ketik judul film favoritmu..."
            value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>"
        >
        <button type="submit">Cari Film</button>
        <button type="button" class="reset-btn" onclick="window.location.href='?';">🍿 Semua Film</button>
    </form>
</div>

<div class="summary-card">
    <h3>🌸 Cinema Summary 🌸</h3>
    <p style="justify-content: center; display:flex; gap:5px;">🎬 Total Film ditemukan: <b><?php echo $total; ?></b> porsi kebahagiaan!</p>
</div>

<?php if($total == 0): ?>
    <div class="summary-card">
        <h3 style="color: #ff1493;">😢 Yahh, Film Tidak Ditemukan...</h3>
        <p style="text-align:center;">Coba cari dengan kata kunci ajaib lainnya yaa mams/guys 🎀</p>
    </div>
<?php else: ?>

    <div class="dashboard-container">

        <div class="column-studio">
            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&q=80&w=400" class="column-banner" alt="Regular Class">
            <div class="column-title bg-regular">🎟 REGULAR CLASS</div>
            
            <?php 
            if(empty($tiket_regular)) echo "<p style='text-align:center; color:#444; font-style:italic; padding:20px;'>Gak ada film di kelas ini 🌸</p>";
            foreach($tiket_regular as $data) {
                $tiket = new TiketRegular($data['id_tiket'], $data['nama_film'], $data['jadwal_tayang'], $data['jumlah_kursi'], $data['harga_dasar_tiket'], $data['tipe_audio'], $data['lokasi_baris']);
            ?>
                <div class="card regular">
                    <h3>🎬 <?php echo htmlspecialchars($data['nama_film']); ?></h3>
                    <p><span class="label">🕒 Jadwal:</span> <?php echo htmlspecialchars($data['jadwal_tayang']); ?></p>
                    <p><span class="label">💺 Sisa Kursi:</span> <?php echo htmlspecialchars($data['jumlah_kursi']); ?> Kursi</p>
                    <p><span class="label">✨ Fasilitas:</span> <?php echo $tiket->tampilkanInfoFasilitas(); ?></p>
                    <div class="harga"><span>Total:</span> <span>Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></span></div>
                </div>
            <?php } ?>
        </div>

        <div class="column-studio">
            <img src="https://images.unsplash.com/photo-1513151233558-d860c5398176?auto=format&fit=crop&q=80&w=400" class="column-banner" alt="IMAX Studio">
            <div class="column-title bg-imax">🎬 IMAX STUDIO</div>
            
            <?php 
            if(empty($tiket_imax)) echo "<p style='text-align:center; color:#444; font-style:italic; padding:20px;'>Gak ada film di kelas ini 🌸</p>";
            foreach($tiket_imax as $data) {
                $tiket = new TiketIMAX($data['id_tiket'], $data['nama_film'], $data['jadwal_tayang'], $data['jumlah_kursi'], $data['harga_dasar_tiket'], $data['kacamata_3d_id'], $data['efek_gerak_fitur']);
            ?>
                <div class="card imax">
                    <h3>🎬 <?php echo htmlspecialchars($data['nama_film']); ?></h3>
                    <p><span class="label">🕒 Jadwal:</span> <?php echo htmlspecialchars($data['jadwal_tayang']); ?></p>
                    <p><span class="label">💺 Sisa Kursi:</span> <?php echo htmlspecialchars($data['jumlah_kursi']); ?> Kursi</p>
                    <p><span class="label">✨ Fasilitas:</span> <?php echo $tiket->tampilkanInfoFasilitas(); ?></p>
                    <div class="harga"><span>Total:</span> <span>Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></span></div>
                </div>
            <?php } ?>
        </div>

        <div class="column-studio">
            <img src="https://images.unsplash.com/photo-1595769816263-9b910be24d5f?auto=format&fit=crop&q=80&w=400" class="column-banner" alt="Velvet Suite">
            <div class="column-title bg-velvet">🛋 VELVET SUITE</div>
            
            <?php 
            if(empty($tiket_velvet)) echo "<p style='text-align:center; color:#444; font-style:italic; padding:20px;'>Gak ada film di kelas ini 🌸</p>";
            foreach($tiket_velvet as $data) {
                $tiket = new TiketVelvet($data['id_tiket'], $data['nama_film'], $data['jadwal_tayang'], $data['jumlah_kursi'], $data['harga_dasar_tiket'], $data['bantal_selimut_pack'], $data['layanan_butler']);
            ?>
                <div class="card velvet">
                    <h3>🎬 <?php echo htmlspecialchars($data['nama_film']); ?></h3>
                    <p><span class="label">🕒 Jadwal:</span> <?php echo htmlspecialchars($data['jadwal_tayang']); ?></p>
                    <p><span class="label">💺 Sisa Kursi:</span> <?php echo htmlspecialchars($data['jumlah_kursi']); ?> Kursi</p>
                    <p><span class="label">✨ Fasilitas:</span> <?php echo $tiket->tampilkanInfoFasilitas(); ?></p>
                    <div class="harga"><span>Total:</span> <span>Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></span></div>
                </div>
            <?php } ?>
        </div>

    </div>

<?php endif; ?>

</body>
</html>