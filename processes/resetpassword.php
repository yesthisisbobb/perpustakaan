<?php
include("../db/config.php");

$resp = array();

if (isset($_POST["uid"])) {
    $uid = $_POST["uid"];

    $query = mysqli_query($conn, "UPDATE user SET password='' WHERE id = $uid");
    if ($query) {
        $resp[] = "QS";
    }
    else{
        $resp[] = "QF";
    }
}
echo json_encode($resp);
?>