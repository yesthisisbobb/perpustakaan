<?php
include("../db/config.php");

$bid = "";
$pid = -1;
$judul = "";
$penulis = "";
$tt = "";
$dp = "";

$penulisArr = array();

if (isset($_GET["bid"])) {
    $bid = $_GET["bid"];
    if (isset($_GET["pid"]) && $_GET["pid"] != "")  $pid = $_GET["pid"];

    $command = "SELECT b.id as id, b.judul as judul, b.penulis as penulis, b.tanggal_terbit as tt, b.status as status, d.id as pid, d.buku_pustaka as pustaka FROM buku b LEFT JOIN daftar_pustaka d ON b.id = d.buku_utama WHERE b.id = $bid";
    if (isset($_GET["pid"]) && $_GET["pid"] != "") $command .= " AND d.id = $pid";
    $query = mysqli_query($conn, $command);
    if ($query) {
        $res = mysqli_fetch_assoc($query);

        $judul = $res["judul"];
        $penulis = $res["penulis"];
        $tt = $res["tt"];
        $dp = $res["pustaka"];

        $penulisArr = explode(", ", $penulis);
    }
}
?>
<div class="book-controls" id="book-update">
    <table>
        <tr>
            <td><label for="judul">Judul</label></td>
            <td><input type="text" name="judul" value="<?= $judul ?>"></td>
        </tr>
        <tr>
            <td><label for="penulis">Penulis</label></td>
            <td>
                <?php
                if (sizeof($penulisArr) == 1) {
                    echo '<input type="text" name="penulis" class="penulis" value="' . $penulisArr[0] . '"><br>';
                } else {
                    foreach ($penulisArr as $piece) {
                        echo '<input type="text" name="penulis" class="penulis" value="' . $piece . '"><br>';
                    }
                }
                ?>
                <button id="add-penulis" class="button-disabled"><i class="fas fa-plus"></i></button><button id="rmv-penulis" class="button-disabled"><i class="fas fa-minus"></i></button>
            </td>
        </tr>
        <tr>
            <td><label for="tt">Tanggal Terbit</label></td>
            <td><input type="date" name="tt" value="<?= $tt ?>"></td>
        </tr>
        <tr>
            <td><label for="penulis">Daftar Pustaka</label></td>
            <td>
                <input type="text" name="dp" class="dp" value="<?= $dp ?>">
            </td>
        </tr>
    </table>
    <button id="update-buku" class="button-success" bid="<?= $bid ?>" pid="<?= $pid ?>">Perbarui buku</button>
</div>
<script>
    $("#update-buku").click(function() {
        let bid = $(this).attr("bid");
        let pid = $(this).attr("pid");

        $.ajax();
    });
</script>