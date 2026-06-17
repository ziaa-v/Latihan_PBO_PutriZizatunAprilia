<?php

require_once "Tiket.php";

class TiketIMAX extends Tiket
{
    private $kacamata3dId;
    private $efekGerakFitur;

    public function __construct(
        $id_tiket,
        $nama_film,
        $jadwal_tayang,
        $jumlah_kursi,
        $hargaDasarTiket,
        $kacamata3dId,
        $efekGerakFitur
    ){
        parent::__construct(
            $id_tiket,
            $nama_film,
            $jadwal_tayang,
            $jumlah_kursi,
            $hargaDasarTiket
        );

        $this->kacamata3dId = $kacamata3dId;
        $this->efekGerakFitur = $efekGerakFitur;
    }
}