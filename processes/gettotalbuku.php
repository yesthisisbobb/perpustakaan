<?php

function getTotalBuku()
{
    include("../db/config.php");

    $command = "SELECT id FROM buku";
    $query = mysqli_query($conn, $command);
    if ($query) {
        return mysqli_num_rows($query);
    }
    else{
        return null;
    }
}

?>