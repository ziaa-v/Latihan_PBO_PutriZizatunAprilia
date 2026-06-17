<?php

require_once "koneksi/database.php";

require_once "classes/Tiket.php";
require_once "classes/TiketRegular.php";
require_once "classes/TiketIMAX.php";
require_once "classes/TiketVelvet.php";

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

if($cari != '')
{
    $query = mysqli_query(
        $conn,
        "SELECT * FROM tabel_tiket
        WHERE nama_film LIKE '%$cari%'"
    );
}
else
{
    $query = mysqli_query(
        $conn,
        "SELECT * FROM tabel_tiket"
    );
}

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

        button{
            padding:12px 20px;
            border:none;
            border-radius:12px;
            background:#ff69b4;
            color:white;
            cursor:pointer;
            font-weight:bold;
        }

        button:hover{
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

        .card{
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.2);
            border-left: 8px solid #ff8dc7;
        }

        .regular{
            border-left-color: #ffb6d9;
        }

        .imax{
            border-left-color: #ff69b4;
        }

        .velvet{
            border-left-color: #d63384;
        }

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
    </style>
</head>

<body>

<div class="header">
    <h1>🎀 Pink Cinema Ticket 🎀</h1>
    <p>✨ Sistem Manajemen Tiket Bioskop Berbasis PHP OOP ✨</p>

    <form method="GET">
    <input
        type="text"
        name="cari"
        placeholder="🔍 Cari film..."
        value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>"
    >

    <button type="submit">Cari</button>

    <a href="index.php" class="reset-btn">
        🎀 Semua Film
    </a>
</form>

</div>

<?php
$total = mysqli_num_rows($query);
?>

<div class="card">
    <h3>🌸 Cinema Summary 🌸</h3>
    <p>🎬 Film ditemukan : <b><?php echo $total; ?></b></p>
    <p>🍿 Selamat menikmati tontonan favoritmu!</p>
</div>
<?php

mysqli_data_seek($query,0);

if(mysqli_num_rows($query) == 0)
{
    echo "
    <div class='card'>
        <h3>😢 Film tidak ditemukan</h3>
        <p>Coba cari dengan kata kunci lain yaa 🎀</p>
    </div>";
}

while($data = mysqli_fetch_assoc($query))
{
    if($data['jenis_studio'] == 'Regular')
    {
        $tiket = new TiketRegular(
            $data['id_tiket'],
            $data['nama_film'],
            $data['jadwal_tayang'],
            $data['jumlah_kursi'],
            $data['harga_dasar_tiket'],
            $data['tipe_audio'],
            $data['lokasi_baris']
        );

        $class = "regular";
    }

    elseif($data['jenis_studio'] == 'IMAX')
    {
        $tiket = new TiketIMAX(
            $data['id_tiket'],
            $data['nama_film'],
            $data['jadwal_tayang'],
            $data['jumlah_kursi'],
            $data['harga_dasar_tiket'],
            $data['kacamata_3d_id'],
            $data['efek_gerak_fitur']
        );

        $class = "imax";
    }

    else
    {
        $tiket = new TiketVelvet(
            $data['id_tiket'],
            $data['nama_film'],
            $data['jadwal_tayang'],
            $data['jumlah_kursi'],
            $data['harga_dasar_tiket'],
            $data['bantal_selimut_pack'],
            $data['layanan_butler']
        );

        $class = "velvet";
    }

?>

<div class="card <?php echo $class; ?>">

    <h3>🎬 <?php echo $data['nama_film']; ?></h3>

    <p><span class="label">🎟 Studio :</span> <?php echo $data['jenis_studio']; ?></p>

    <p><span class="label">🕒 Jadwal :</span> <?php echo $data['jadwal_tayang']; ?></p>

    <p><span class="label">💺 Jumlah Kursi :</span> <?php echo $data['jumlah_kursi']; ?></p>

    <p><span class="label">✨ Fasilitas :</span>
        <?php echo $tiket->tampilkanInfoFasilitas(); ?>
    </p>

    <p class="harga">
        💸 Total Harga :
        Rp <?php echo number_format($tiket->hitungTotalHarga(),0,',','.'); ?>
    </p>

</div>

<?php } ?>

</body>
</html>