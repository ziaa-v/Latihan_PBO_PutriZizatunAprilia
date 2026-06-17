<?php

require_once "Tiket.php";

class TiketVelvet extends Tiket
{
    private $bantalSelimutPack;
    private $layananButler;

    public function __construct(
        $id_tiket,
        $nama_film,
        $jadwal_tayang,
        $jumlah_kursi,
        $hargaDasarTiket,
        $bantalSelimutPack,
        $layananButler
    ){
        parent::__construct(
            $id_tiket,
            $nama_film,
            $jadwal_tayang,
            $jumlah_kursi,
            $hargaDasarTiket
        );

        $this->bantalSelimutPack = $bantalSelimutPack;
        $this->layananButler = $layananButler;
    }

    public function hitungTotalHarga()
    {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) * 1.5;
    }

    public function tampilkanInfoFasilitas()
    {
        return "Bantal Selimut : ".$this->bantalSelimutPack.
            " | Butler : ".$this->layananButler;
    }
}