<?php
include("../db/config.php");
?>
<div id="book-container">
    <!-- <div><button class="button-neutral"><i class="fas fa-plus"></i>&nbsp&nbspTambah Buku</button></div> -->
    <div id="book-controls-container">
        <?php include("insertbuku.php"); ?>
    </div>
    <div id="book-list">
        <table id="book-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
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

    $("#book-list").on("click", ".buku-actions", function() {
        console.log($(this).attr("bid"), $(this).attr("pid"));

        let bid = $(this).attr("bid");
        let pid = $(this).attr("pid");

        let content;

        $.ajax({
            url: `updatebuku.php?bid=${bid}&pid=${pid}`,
            success: function(data) {
                console.log(data);
                content = data;
            },
            error: function(err) {
                console.error(err.responseText);
            },
            complete: function() {
                $("#book-controls-container").html(content);
            }
        });
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