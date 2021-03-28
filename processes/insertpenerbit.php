<?php
include("../db/config.php");

$resp = array();

if (isset($_POST["nama"])) {
    
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $command = "INSERT INTO penerbit VALUES(null, '$nama')";
    $query = mysqli_query($conn, $command);

    if ($query) {
        $resp[] = "QS";
    }
    else{
        $resp[] = "QF";
    }
}

echo json_encode($resp);
?>