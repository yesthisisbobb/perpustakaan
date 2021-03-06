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

    $command = "SELECT b.id as id, b.judul as judul, b.penulis as penulis, b.penerbit as penerbit, b.tanggal_terbit as tt, b.status as status, d.id as pid, d.buku_pustaka as pustaka FROM buku b LEFT JOIN daftar_pustaka d ON b.id = d.buku_utama WHERE b.id = '$bid'";
    if (isset($_GET["pid"]) && $_GET["pid"] != "") $command .= " AND d.id = $pid";
    $query = mysqli_query($conn, $command);
    if ($query) {
        $res = mysqli_fetch_assoc($query);

        $judul = $res["judul"];
        $penulis = $res["penulis"];
        $penerbit = $res["penerbit"];
        $tt = $res["tt"];
        $dp = $res["pustaka"];

        $penulisArr = explode(", ", $penulis);

        $cpenerbit = "SELECT * FROM penerbit";
        $qpenerbit = mysqli_query($conn, $cpenerbit);
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
            <td for="penerbit">Penerbit</td>
            <td>
                <select name="penerbit">
                    <?php
                    while ($pen = mysqli_fetch_assoc($qpenerbit)) {
                        $id = $pen["id"];
                        $nama = $pen["nama"];
                        if ($id == $penerbit) {
                            echo "<option value='$id' selected='selected'>$nama</option>";
                        } else {
                            echo "<option value='$id'>$nama</option>";
                        }
                    }
                    ?>
                </select>
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

        let judul = $("#book-update input[name='judul']").val();
        let penerbit = $("#book-update select[name='penerbit']").val();
        let tt = $("#book-update input[name='tt']").val();
        let dp = $("#book-update input[name='dp']").val();
        console.log(tt);

        // TODO: ngubah nama variable kalo error
        let penulisArr = [];
        let penulisDb = "";
        $(".penulis").each(function(index) {
            penulisArr = [...penulisArr, $(this).val()];
        });
        if (penulisArr.length > 1) {
            for (let i = 0; i < penulisArr.length; i++) {
                const p = penulisArr[i];

                penulisDb += p;
                if (i < penulisArr.length - 1 && (penulisArr[penulisArr.length - 2] != "" || penulisArr[penulisArr.length - 2] != " ")) {
                    penulisDb += ", ";
                }
            }
        } else {
            penulisDb = penulisArr[0];
        }

        let qcs1Found = false;
        let qcs2Found = false;
        let qcf1Found = false;
        let qcf2Found = false;
        $.ajax({
            url: "../processes/updatebuku.php",
            method: "POST",
            data: {
                "pid": pid,
                "bid": bid,
                "judul": judul,
                "penerbit": penerbit,
                "tt": tt,
                "dp": dp,
                "penulis": penulisDb
            },
            success: function(data) {
                let asd = JSON.parse(data);
                asd.forEach(item => {
                    if (item == "QCS1") {
                        qcs1Found = true;
                    }
                    if (item == "QCS2") {
                        qcs2Found = true;
                    }
                    if (item == "QCF1") {
                        qcf1Found = true;
                    }
                    if (item == "QCF2") {
                        qcf2Found = true;
                    }
                });
            },
            complete: function() {
                if (qcs1Found) {
                    toastr.success("Buku berhasil diupdate!", "Berhasil");
                }
                if (qcs2Found) {
                    toastr.success("Daftar Pustaka berhasil diupdate!", "Berhasil");
                }
            }
        });
    });
</script>