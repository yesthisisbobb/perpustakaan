<?php
include("../db/config.php");

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
        echo "IS";
    }
    else{
        echo $command;
        echo "IG";
    }
}
else{
    echo "DKL";
}
    
?>