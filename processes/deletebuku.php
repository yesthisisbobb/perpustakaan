<?php
include("../db/config.php");

$resp = array();

if (isset($_POST["bid"])) {
    $bid = $_POST["bid"];

    $command = "SELECT id FROM buku WHERE id ='$bid'";
    $query = mysqli_query($conn, $command);

    if (mysqli_num_rows($query) > 0 && mysqli_num_rows($query) < 2) {
        $command = "UPDATE buku SET status='d' WHERE id = '$bid'";
        $query = mysqli_query($conn, $command);
        if ($query) {
            $resp[] = "QS";
        } else {
            $resp[] = "QF2";
        }
    }
    else{
        $resp[] = "QF1";
    }
}
else{
    $resp[] = "DNF";
}

echo json_encode($resp);
?>