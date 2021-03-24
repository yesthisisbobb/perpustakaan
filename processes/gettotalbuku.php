<?php

function getTotalBuku()
{
    include("../db/config.php");

    $command = "SELECT b.id as id, b.judul as judul, b.penulis as penulis, b.tanggal_terbit as tt, b.status as status, dp.buku_pustaka as pustaka FROM buku b LEFT JOIN daftar_pustaka dp ON b.id = dp.buku_utama";
    $query = mysqli_query($conn, $command);
    if ($query) {
        return mysqli_num_rows($query);
    }
    else{
        return null;
    }
}

?>