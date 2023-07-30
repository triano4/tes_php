<?php

function load_page($url)
{
    switch ($url) {
        case 'login':
            require_once('login.php');
            break;
        case 'deposit':
            require_once('deposit.php');
            break;
        case 'withdraw':
            require_once('withdraw.php');
            break;
        case 'transfer':
            require_once('transfer.php');
            break;
        case 'ringkasan_saldo':
            require_once('ringkasan_saldo.php');
            break;
        case 'grafik':
            require_once('grafik.php');
            break;
        case 'histori_transaksi':
            require_once('histori_transaksi.php');
            break;
        case 'rekap_pengeluaran':
            require_once('rekap_pengeluaran.php');
            break;
        case 'proyeksi':
            require_once('proyeksi.php');
            break;
        case 'peringatan_saldo_minimum':
            require_once('peringatan_saldo_minimum.php');
            break;
        case 'kategori_pengeluaran':
            require_once('kategori_pengeluaran.php');
            break;
        case 'penyimpanan_otomatis':
            require_once('penyimpanan_otomatis.php');
            break;
        default:
            echo "Halaman tidak ditemukan.";
            break;
    }
}

if (isset($_GET['url'])) {
    $url = $_GET['url'];
} else {
    $url = 'login'; }

load_page($url);
?>