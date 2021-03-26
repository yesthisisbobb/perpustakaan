<?php
include("../db/config.php");
include("gettotalbuku.php");

$output = array();

$selects = "SELECT b.id as id, b.judul as judul, b.penulis as penulis, b.tanggal_terbit as tt, b.status as status, dp.id as pid, dp.buku_pustaka as pustaka";
$froms = "FROM buku b LEFT JOIN daftar_pustaka dp ON b.id = dp.buku_utama";
$wheres = "";

if (isset($_POST["search"]["value"])) {
    $sv = $_POST["search"]["value"];

    if($wheres == "") $wheres .= "WHERE";
    $wheres .= " (b.judul LIKE '%$sv%'";
    $wheres .= " OR b.penulis LIKE '%$sv%'";
    $wheres .= " OR dp.buku_pustaka LIKE '%$sv%')";
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
        $temp[] = $res["judul"];
        $temp[] = $res["penulis"];
        $temp[] = $res["tt"];
        $temp[] = $res["status"];
        $temp[] = $res["pustaka"];
        $temp[] = "<button class='buku-actions' act='edit' bid='" . $res["id"] . "' pid='" . $res["pid"] . "'>Edit</button>";
        $temp[] = "<button class='buku-actions' act='del' bid='" . $res["id"] . "' pid='" . $res["pid"] . "'>Delete</button>";

        $data[] = $temp;
    }

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => getTotalBuku(),
        "data" => $data
    );
    echo json_encode($output);
}
?>