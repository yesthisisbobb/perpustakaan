<?php
include("../db/config.php");

$command = "SELECT * FROM buku";
$query = mysqli_query($conn, $command);
if ($query) {
    $arrRes = [];
    while($result = mysqli_fetch_assoc($query)){
        array_push($arrRes, $result);
    }

    echo json_encode($arrRes);
}
?>