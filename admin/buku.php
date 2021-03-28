<?php
include("../db/config.php");
?>
<div id="book-container">
    <div id="book-controls-container"></div>
    <div class="book-options">
        <button class="button-neutral" id="book-control-close"><i class="fas fa-times"></i>&nbsp&nbspTutup Menu</button>
        <button class="button-neutral" id="book-insert-show"><i class="fas fa-plus"></i>&nbsp&nbspTambah Buku</button>
        <button class="button-neutral" id="penerbit-insert-show"><i class="fas fa-plus"></i>&nbsp&nbspTambah Penerbit</button>
    </div>
    <div id="book-list">
        <table id="book-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tanggal Terbit</th>
                    <th>Status</th>
                    <th>Pustaka</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
    let isInsert = false;
    let isUpdate = false;
    let isPInsert = false;

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // Nutup menu
    $("#book-control-close").click(function() {
        isInsert = false;
        isUpdate = false;
        isPInsert = false;

        $("#book-controls-container").html("");
    });
    // Munculin menu tambah buku
    $("#book-insert-show").click(function() {
        isInsert = true;
        isUpdate = false;
        isPInsert = false;
        $("#book-controls-container").load("insertbuku.php");
    });
    $("#penerbit-insert-show").click(function() {
        isInsert = false;
        isUpdate = false;
        isPInsert = true;
        $("#book-controls-container").load("insertpenerbit.php");
    });
    $("#book-list").on("click", ".buku-actions", function() {
        console.log($(this).attr("bid"), $(this).attr("pid"));

        let bid = $(this).attr("bid");
        let pid = $(this).attr("pid");

        let type = $(this).text();
        // Kalo neken edit
        if (type === "Edit") {
            isUpdate = true;
            isInsert = false;

            let content;

            $.ajax({
                url: `updatebuku.php?bid=${bid}&pid=${pid}`,
                success: function(data) {
                    content = data;
                },
                error: function(err) {
                    console.error(err.responseText);
                },
                complete: function() {
                    $("#book-controls-container").html(content);
                }
            });
        }
        if (type === "Delete") {
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus sebuah buku, apakah anda benar-benar yakin anda ingin menghapus buku ini?",
                icon: "warning",
                showConfirmButton: true,
                confirmButtonText: "Ya, Hapus",
                showCancelButton: true,
                cancelButtonText: "Batal"
            }).then(result => {
                if (result.isConfirmed) {
                    let qsFound = false;

                    console.log(bid);

                    $.ajax({
                        url: "../processes/deletebuku.php",
                        method: "POST",
                        data: {
                            "bid": bid
                        },
                        success: function(data) {
                            console.log(data);
                            sdata = JSON.parse(data);
                            sdata.forEach(item => {
                                if (item === "QS") qsFound = true;
                            });
                        },
                        complete: function() {
                            if (qsFound) {
                                Swal.fire({
                                    title: "Sukses",
                                    text: "Buku berhasil dihapus",
                                    icon: "success",
                                    showConfirmButton: true
                                });
                                reloadDT();
                            } else {
                                Swal.fire({
                                    title: "Gagal",
                                    text: "Terjadi sebuah kesalahan saat menghapus buku",
                                    icon: "error",
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            });
        }

    });
</script>
<script>
    $("#add-penulis").click(function() {
        if ($(".book-controls table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() != "") {
            $(".book-controls table tr:nth-child(2) td:nth-child(2) input:last-of-type").after('<br><input type="text" name="penulis" class="penulis">');
        }

        let inputAmount = $(".book-controls table tr:nth-child(2) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-penulis").removeClass("button-disabled");
        }
    });
    $("#rmv-penulis").click(function() {
        // Harus 2 kali karena tekniknya
        let inputAmount = $(".book-controls table tr:nth-child(2) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $(".book-controls table tr:nth-child(2) td:nth-child(2) br:last-of-type").remove();
            $(".book-controls table tr:nth-child(2) td:nth-child(2) input:last-of-type").remove();
        }

        inputAmount = $(".book-controls table tr:nth-child(2) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-penulis").removeClass("button-disabled");
        } else {
            $("#rmv-penulis").addClass("button-disabled");
        }
    });

    $("#add-dp").click(function() {
        if ($(".book-controls table tr:nth-child(4) td:nth-child(2) input:last-of-type").val() != "") {
            $(".book-controls table tr:nth-child(4) td:nth-child(2) input:last-of-type").after('<br><input type="text" name="dp" class="dp">');
        }

        let inputAmount = $(".book-controls table tr:nth-child(4) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-dp").removeClass("button-disabled");
        }
    });
    $("#rmv-dp").click(function() {
        // Harus 2 kali karena tekniknya
        let inputAmount = $(".book-controls table tr:nth-child(4) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $(".book-controls table tr:nth-child(4) td:nth-child(2) br:last-of-type").remove();
            $(".book-controls table tr:nth-child(4) td:nth-child(2) input:last-of-type").remove();
        }

        inputAmount = $(".book-controls table tr:nth-child(4) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-dp").removeClass("button-disabled");
        } else {
            $("#rmv-dp").addClass("button-disabled");
        }
    });

    // Baru bisa nambah kalo keisi - Add penulis
    $(".book-controls table tr:nth-child(2) td:nth-child(2) input:last-of-type").keyup(function() {
        // Kalo kosong
        if (!$(".book-controls table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() || $(".book-controls table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() === " ") {
            $("#add-penulis").addClass("button-disabled");
        } else {
            $("#add-penulis").removeClass("button-disabled");
        }
    });
    // Baru bisa nambah kalo keisi - Add Daftar Pustaka
    $(".book-controls table tr:nth-child(4) td:nth-child(2) input:last-of-type").keyup(function() {
        // Kalo kosong
        if (!$(".book-controls table tr:nth-child(4) td:nth-child(2) input:last-of-type").val() || $(".book-controls table tr:nth-child(4) td:nth-child(2) input:last-of-type").val() === " ") {
            $("#add-dp").addClass("button-disabled");
        } else {
            $("#add-dp").removeClass("button-disabled");
        }
    });
</script>