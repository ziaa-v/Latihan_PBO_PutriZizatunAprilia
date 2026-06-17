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
    <title>Pink Cinema Ticket</title>

    <style>
        .reset-btn{
            display:inline-block;
            padding:12px 20px;
            background:#ffc0cb;
            color:#d63384;
            text-decoration:none;
            border-radius:12px;
            font-weight:bold;
            margin-left:10px;
            border: none;
            cursor: pointer;
        }

        .reset-btn:hover{
            background:#ffb6c1;
        }

        form{
            margin-top:20px;
        }

        input[type=text]{
            width:300px;
            padding:12px;
            border:none;
            border-radius:12px;
            outline:none;
            font-size:14px;
        }

        button[type=submit]{
            padding:12px 20px;
            border:none;
            border-radius:12px;
            background:#ff69b4;
            color:white;
            cursor:pointer;
            font-weight:bold;
        }

        button[type=submit]:hover{
            background:#ff1493;
        }

        body{
            font-family: 'Poppins', sans-serif;
            background: #ffe6f0;
            margin: 0;
            padding: 30px;
        }

        h1{
            text-align: center;
            color: #ff4f9a;
            font-size: 40px;
            margin-bottom: 30px;
        }

        /* --- STYLING BARU UNTUK 3 KOLOM VERTIKAL --- */
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            align-items: start;
        }

        .column-studio {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            padding: 15px;
            box-shadow: inset 0 0 10px rgba(255,105,180,0.1);
        }

        .column-title {
            text-align: center;
            padding: 10px;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .bg-regular { background: #ffb6d9; color: #d63384; }
        .bg-imax { background: #ff69b4; color: white; }
        .bg-velvet { background: #d63384; color: white; }
        /* ------------------------------------------- */

        .card{
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.2);
            border-left: 8px solid #ff8dc7;
        }

        .regular{ border-left-color: #ffb6d9; }
        .imax{ border-left-color: #ff69b4; }
        .velvet{ border-left-color: #d63384; }

        h3{
            color: #ff4f9a;
            margin-top: 0;
        }

        .label{
            font-weight: bold;
            color: #d63384;
        }

        .harga{
            font-size: 20px;
            color: #ff1493;
            font-weight: bold;
        }

        .header{
            background: white;
            padding: 20px;
            border-radius: 25px;
            margin-bottom: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(255,105,180,0.2);
        }

        /* Responsif untuk HP agar tidak terlalu sempit */
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="header">
    <h1>🎀 Pink Cinema Ticket 🎀</h1>
    <p>✨ Sistem Manajemen Tiket Bioskop Berbasis PHP OOP ✨</p>

    <form action="" method="GET">
        <input
            type="text"
            name="cari"
            placeholder="🔍 Cari film..."
            value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>"
        >

        <button type="submit">Cari</button>

        <button type="button"
                class="reset-btn"
                onclick="window.location.href='?';">
            🎀 Semua Film
        </button>
    </form>
</div>

<div class="card">
    <h3>🌸 Cinema Summary 🌸</h3>
    <p>🎬 Total Film ditemukan : <b><?php echo $total; ?></b></p>
    <p>🍿 Selamat menikmati tontonan favoritmu!</p>
</div>

<?php if($total == 0): ?>
    <div class='card'>
        <h3>😢 Film tidak ditemukan</h3>
        <p>Coba cari dengan kata kunci lain yaa 🎀</p>
    </div>
<?php else: ?>

    <div class="dashboard-container">

        <div class="column-studio">
            <div class="column-title bg-regular">🎟 REGULAR CLASS</div>
            <?php 
            if(empty($tiket_regular)) echo "<p style='text-align:center; color:#999;'>Tidak ada film</p>";
            foreach($tiket_regular as $data) {
                $tiket = new TiketRegular($data['id_tiket'], $data['nama_film'], $data['jadwal_tayang'], $data['jumlah_kursi'], $data['harga_dasar_tiket'], $data['tipe_audio'], $data['lokasi_baris']);
            ?>
                <div class="card regular">
                    <h3>🎬 <?php echo htmlspecialchars($data['nama_film']); ?></h3>
                    <p><span class="label">🕒 Jadwal :</span> <?php echo htmlspecialchars($data['jadwal_tayang']); ?></p>
                    <p><span class="label">💺 Kursi :</span> <?php echo htmlspecialchars($data['jumlah_kursi']); ?></p>
                    <p><span class="label">✨ Fasilitas :</span> <?php echo $tiket->tampilkanInfoFasilitas(); ?></p>
                    <p class="harga">Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></p>
                </div>
            <?php } ?>
        </div>

        <div class="column-studio">
            <div class="column-title bg-imax">🎬 IMAX STUDIO</div>
            <?php 
            if(empty($tiket_imax)) echo "<p style='text-align:center; color:#999;'>Tidak ada film</p>";
            foreach($tiket_imax as $data) {
                $tiket = new TiketIMAX($data['id_tiket'], $data['nama_film'], $data['jadwal_tayang'], $data['jumlah_kursi'], $data['harga_dasar_tiket'], $data['kacamata_3d_id'], $data['efek_gerak_fitur']);
            ?>
                <div class="card imax">
                    <h3>🎬 <?php echo htmlspecialchars($data['nama_film']); ?></h3>
                    <p><span class="label">🕒 Jadwal :</span> <?php echo htmlspecialchars($data['jadwal_tayang']); ?></p>
                    <p><span class="label">💺 Kursi :</span> <?php echo htmlspecialchars($data['jumlah_kursi']); ?></p>
                    <p><span class="label">✨ Fasilitas :</span> <?php echo $tiket->tampilkanInfoFasilitas(); ?></p>
                    <p class="harga">Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></p>
                </div>
            <?php } ?>
        </div>

        <div class="column-studio">
            <div class="column-title bg-velvet">🛋 VELVET SUITE</div>
            <?php 
            if(empty($tiket_velvet)) echo "<p style='text-align:center; color:#999;'>Tidak ada film</p>";
            foreach($tiket_velvet as $data) {
                $tiket = new TiketVelvet($data['id_tiket'], $data['nama_film'], $data['jadwal_tayang'], $data['jumlah_kursi'], $data['harga_dasar_tiket'], $data['bantal_selimut_pack'], $data['layanan_butler']);
            ?>
                <div class="card velvet">
                    <h3>🎬 <?php echo htmlspecialchars($data['nama_film']); ?></h3>
                    <p><span class="label">🕒 Jadwal :</span> <?php echo htmlspecialchars($data['jadwal_tayang']); ?></p>
                    <p><span class="label">💺 Kursi :</span> <?php echo htmlspecialchars($data['jumlah_kursi']); ?></p>
                    <p><span class="label">✨ Fasilitas :</span> <?php echo $tiket->tampilkanInfoFasilitas(); ?></p>
                    <p class="harga">Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></p>
                </div>
            <?php } ?>
        </div>

    </div> <?php endif; ?>

</body>
</html>