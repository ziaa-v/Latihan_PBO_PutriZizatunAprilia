<?php

require_once "Tiket.php";

class TiketRegular extends Tiket
{
    private $tipeAudio;
    private $lokasiBaris;

    public function __construct(
        $id_tiket,
        $nama_film,
        $jadwal_tayang,
        $jumlah_kursi,
        $hargaDasarTiket,
        $tipeAudio,
        $lokasiBaris
    ){
        parent::__construct(
            $id_tiket,
            $nama_film,
            $jadwal_tayang,
            $jumlah_kursi,
            $hargaDasarTiket
        );

        $this->tipeAudio = $tipeAudio;
        $this->lokasiBaris = $lokasiBaris;
    }