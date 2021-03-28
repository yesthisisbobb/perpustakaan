<?php

function getTotalUser()
{
    include("../db/config.php");

    $command = "SELECT * FROM user";
    $query = mysqli_query($conn, $command);
    if ($query) {
        return mysqli_num_rows($query);
    }
    else{
        return null;
    }
}
?>