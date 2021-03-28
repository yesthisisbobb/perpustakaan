<?php

function getTotalBuku()
{
    include("../db/config.php");

    $command = "SELECT b.id as id, b.judul as judul, b.penulis as penulis, pe.nama as penerbit, b.tanggal_terbit as tt, b.status as status, dp.id as pid, dp.buku_pustaka as pustaka FROM buku b INNER JOIN penerbit pe ON b.penerbit = pe.id LEFT JOIN daftar_pustaka dp ON b.id = dp.buku_utama WHERE (b.status = 'a' OR b.status = 'u')";
    $query = mysqli_query($conn, $command);
    if ($query) {
        return mysqli_num_rows($query);
    }
    else{
        return null;
    }
}

?>