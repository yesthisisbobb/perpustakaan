<?php
include("../db/config.php");

$cpenerbit = "SELECT * FROM penerbit";
$qpenerbit = mysqli_query($conn, $cpenerbit);

?>
<div class="book-controls" id="book-insert">
    <table>
        <tr>
            <td><label for="judul">Judul</label></td>
            <td><input type="text" name="judul"></td>
        </tr>
        <tr>
            <td><label for="penulis">Penulis</label></td>
            <td>
                <input type="text" name="penulis" class="penulis">
                <br><button id="add-penulis" class="button-disabled"><i class="fas fa-plus"></i></button><button id="rmv-penulis" class="button-disabled"><i class="fas fa-minus"></i></button>
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
                        echo "<option value='$id'>$nama</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="tt">Tanggal Terbit</label></td>
            <td><input type="date" name="tt"></td>
        </tr>
        <tr>
            <td><label for="penulis">Daftar Pustaka</label></td>
            <td>
                <input type="text" name="dp" class="dp">
                <br><button id="add-dp" class="button-disabled"><i class="fas fa-plus"></i></button><button id="rmv-dp" class="button-disabled"><i class="fas fa-minus"></i></button>
            </td>
        </tr>
    </table>
    <button id="add-buku" class="button-success">Tambah buku</button>
</div>
<script>
    $("#add-buku").click(function() {
        let judul = $("#book-insert input[name='judul']").val();
        let tt = $("#book-insert input[name='tt']").val();
        let penerbit = $("#book-insert select[name='penerbit']").val();

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

        let dpArr = [];
        let dpDb = "";
        $(".dp").each(function(index) {
            dpArr = [...dpArr, $(this).val()];
        });
        if (dpArr.length > 1) {
            for (let i = 0; i < dpArr.length; i++) {
                const p = dpArr[i];
                dpDb += p;
                if (i < dpArr.length - 1 && (penulisArr[penulisArr.length - 2] != "" || penulisArr[penulisArr.length - 2] != " ")) {
                    dpDb += ", ";
                }
            }
        } else {
            dpDb = dpArr[0];
        }

        console.log($("#book-insert input[name='judul']").val(), penulisDb, $("#book-insert input[name='tt']").val(), dpDb);
        let action = "";
        $.ajax({
            url: "../processes/insertbuku.php",
            method: "POST",
            dataType: "json",
            data: {
                "judul": judul,
                "penulis": penulisDb,
                "penerbit": penerbit,
                "tt": tt,
                "dp": dpDb
            },
            success: function(pdata) {
                console.log(pdata + " - " + typeof(pdata));

                let is1Found = false; // Insert ke tabel buku
                let is2Found = false; // Insert ke tabel daftar_pustaka

                for (let i = 0; i < pdata.length; i++) {
                    const code = pdata[i];
                    if (code === "IS1") {
                        is1Found = true;
                    }
                    if (code === "IS2") {
                        is2Found = true;
                    }
                }
                if (is1Found) {
                    action = "success";
                }
            },
            error: function(error) {
                console.error(error);
            },
            complete: function() {
                if (action === "success") {
                    toastr.success("Buku berhasil ditambahkan!", "Berhasil");

                    $("#book-insert input[name='judul']").val("");

                    $("#book-insert table tr:nth-child(2) td:nth-child(2) input:first-of-type").val("");
                    $("#book-insert table tr:nth-child(2) td:nth-child(2) br:not(:first-of-type)").remove();
                    $("#book-insert table tr:nth-child(2) td:nth-child(2) input:not(:first-of-type)").remove();

                    $("#book-insert input[name='tt']").val("");

                    $("#book-insert table tr:nth-child(4) td:nth-child(2) input:first-of-type").val("");
                    $("#book-insert table tr:nth-child(4) td:nth-child(2) br:not(:first-of-type)").remove();
                    $("#book-insert table tr:nth-child(4) td:nth-child(2) input:not(:first-of-type)").remove();
                } else if (action === "failed") {
                    toastr.error("Ada sesuatu yang salah!", "Gagal");
                } else {
                    console.log("lol");
                }
            }
        });

    });
</script>