<?php
include("../db/config.php");
$res = array();

if (isset($_POST["judul"]) && isset($_POST["penulis"]) && isset($_POST["tt"])) {
    $judul = $_POST["judul"];
    $penulis = $_POST["penulis"];
    $tt = $_POST["tt"];

    $id = date("Y") . date("m") . date("d");
    $command = "SELECT * FROM buku WHERE id LIKE '$id%'";
    $query = mysqli_query($conn, $command);

    $id .= str_pad((mysqli_num_rows($query) + 1) . "", 4, "0", STR_PAD_LEFT);

    $command = "INSERT INTO buku VALUES('$id', '$judul', '$penulis', STR_TO_DATE('$tt', '%Y-%m-%d'), 'a')";
    $query = mysqli_query($conn, $command);
    if ($query) {
        $res[] = "IS1";

        // Insert Daftar Pustaka
        if (isset($_POST["dp"])) {
            $dp = $_POST["dp"];

            $pieces = explode(", ", $_POST["dp"]);
            foreach ($pieces as $p) {
                if ($p != "") {
                    $command = "INSERT INTO daftar_pustaka VALUES(0, '$id', '$p')";
                    $queryDP = mysqli_query($conn, $command);
                    if ($queryDP) {
                        $res[] = "IS2";
                    } else {
                        $res[] = "IG3";
                    }
                }
                else{
                    $res[] = "IG2";
                }
            }
        }
    }
    else{
        $res[] = "IG1";
    }
}
else{
    $res[] = "DKL";
}

echo json_encode($res);

?>