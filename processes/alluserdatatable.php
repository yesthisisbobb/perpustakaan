<?php
include("../db/config.php");
include("gettotaluser.php");

$output = array();

$selects = "SELECT u.id as id, u.email as email, u.nama as nama, u.role as role";
$froms = "FROM user u";
$wheres = "";

if (isset($_POST["search"]["value"])) {
    $sv = $_POST["search"]["value"];

    $wheres .= " WHERE (u.email LIKE '%$sv%'";
    $wheres .= " OR u.nama LIKE '%$sv%'";
    $wheres .= " OR u.role LIKE '%$sv%')";
}

if (isset($_POST["order"])) {
    $wheres .= " ORDER BY " . $_POST["order"][0]["column"] . " " . $_POST["order"][0]["dir"];
}

if ($_POST["length"] != -1) {
    $wheres .= " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
}

$query = mysqli_query($conn, "$selects $froms $wheres");
if ($query) {
    $filtered_rows = mysqli_num_rows($query);
    $data = array();

    while($res = mysqli_fetch_assoc($query)){
        $temp = array();

        $temp[] = $res["id"];
        $temp[] = $res["email"];
        $temp[] = $res["nama"];
        $temp[] = $res["role"];
        $temp[] = "<button class='akun-actions' act='reset' uid='" . $res["id"] . "'>Reset Password</button>";

        $data[] = $temp;
    }

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => getTotalUser(), //query total tanpa filter
        "data" => $data
    );
    echo json_encode($output);
}
?>