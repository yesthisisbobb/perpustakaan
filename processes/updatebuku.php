<?php
include("../db/config.php");

$response = array();
$bid = "";
$pid = -1;

// Debug
// $res[] = $_POST["bid"];
// $res[] = $_POST["pid"];
// $res[] = $_POST["judul"];
// $res[] = $_POST["tt"];
// $res[] = $_POST["dp"];
// $res[] = $_POST["penulis"];

// echo json_encode($res);

if (isset($_POST["bid"])) {
    $response[] = "MU";

    $bid = $_POST["bid"];
    if(isset($_POST["pid"])) $pid = $_POST["pid"];

    $command = "SELECT b.id as id, b.judul as judul, b.penulis as penulis, b.tanggal_terbit as tt";
    if($pid != -1) $command .= ", d.buku_pustaka as pustaka";
    $command .= " FROM buku b";
    if($pid != -1) $command .= " LEFT JOIN daftar_pustaka d ON b.id = d.buku_utama";
    $command .= " WHERE b.id = '$bid'";
    if ($pid != -1) $command .= " AND d.id = $pid";

    $query = mysqli_query($conn, $command);

    // Kalo ada
    if (mysqli_num_rows($query) > 0) {
        $response[] = "QA";

        $sameJudul = false;
        $samePenulis = false;
        $sameTT = false;
        $samePustaka = false;
        $judul = "";
        $penulis = "";
        $tt = "";
        $dp = "";

        $res = mysqli_fetch_assoc($query);
        if (isset($_POST["judul"])) {
            $judul = mysqli_real_escape_string($conn, $_POST["judul"]);
            if ($res["judul"] == $_POST["judul"]) {
                $sameJudul = true;
                $response[] = "MJ";
            }
        }
        if (isset($_POST["penulis"])) {
            $penulis = mysqli_real_escape_string($conn, $_POST["penulis"]);
            if ($res["penulis"] == $_POST["penulis"]) {
                $samePenulis = true;
                $response[] = "MP";
            }
        }
        if (isset($_POST["tt"])) {
            $tt = $_POST["tt"];
            if ($res["tt"] == $_POST["tt"]) {
                $sameTT = true;
                $response[] = "MTT";
            }
        }
        if (isset($_POST["dp"])) {
            $dp = mysqli_real_escape_string($conn, $_POST["dp"]);
            if (isset($res["pustaka"]) && $res["pustaka"] == $_POST["dp"]) {
                $samePustaka = true;
                $response[] = "MDP";
            }
        }

        // Konfigurasi
        $command = "";
        if (!$sameJudul || !$samePenulis || !$sameTT) {
            $command = "UPDATE buku SET";
            if (!$sameJudul) $command .= " judul = '$judul'";
            if (!$sameJudul && !$samePenulis) $command .= ",";
            if (!$samePenulis) $command .= " penulis = '$penulis'";
            if (!$sameJudul && !$samePenulis && !$sameTT) $command .= ",";
            if (!$sameTT) $command .= " tanggal_terbit = '$tt'";
            $command .= " WHERE id = '$bid'";  
        }

        $command2 = "";
        if ($bid != "" && $pid != -1) {
            if (!$samePustaka) $command2 = "UPDATE daftar_pustaka SET buku_pustaka = '$dp' WHERE id = $pid";
        }
         // Kalau buku awal-awal nggak punya pustaka
        else if($bid != "" && $pid == -1 && isset($_POST["dp"]) && $_POST["dp"] != ""){
            $command2 = "INSERT INTO daftar_pustaka(id, buku_utama, buku_pustaka) VALUES (0, '$bid', '$dp')";
        }

        // Eksekusi
        if ($command != "") {
            $response[] = "MC1";
            $query = mysqli_query($conn, $command);
            if ($query) {
                $response[] = "QCS1";
            }
            else{
                $response[] = "QCF1";
                $response[] = $command;
            }
        }
        if ($command2 != "") {
            $response[] = "MC2";
            $query = mysqli_query($conn, $command2);
            if ($query) {
                $response[] = "QCS2";
            } else {
                $response[] = "QCF2";
                $response[] = $command2;
            }
        }
    }
    else {
        $response[] = "QTA";
    }
}

echo json_encode($response);
?>