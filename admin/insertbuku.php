<div id="book-insert">
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
            <td><label for="tt">Tanggal Terbit</label></td>
            <td><input type="date" name="tt"></td>
        </tr>
    </table>
    <button id="add-buku" class="button-success">Tambah buku</button>
</div>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
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
    $("#add-buku").click(function() {
        let penulisArr = [];
        let penulisDb = "";
        $(".penulis").each(function(index) {
            penulisArr = [...penulisArr, $(this).val()];
        });
        if (penulisArr.length > 1) {
            for (let i = 0; i < penulisArr.length; i++) {
                const p = penulisArr[i];
                penulisDb += p;
                if (i < penulisArr.length - 1) {
                    penulisDb += ", ";
                }
            }
        } else {
            penulisDb = penulisArr[0];
        }

        console.log($("#book-insert input[name='judul']").val(), penulisDb, $("#book-insert input[name='tt']").val());
        $.ajax({
            url: "../processes/insertbuku.php",
            method: "POST",
            data: {
                "judul": $("#book-insert input[name='judul]'").val(),
                "penulis": penulisDb,
                "tt": $("#book-insert input[name='tt]'").val()
            },
            success: function(pdata) {
                console.log(pdata + " - " + typeof(pdata));

                if (pdata == "IS") {
                    toastr.success("Proses penambahan buku berhasil!", "Berhasil");
                } else if (pdata == "DKL") {
                    toastr.error("Data kurang lengkap", "Gagal");
                } else {
                    console.log("nope");
                }
            },
            error: function(error) {
                console.error(error);
            }
        });

    });
    $("#add-penulis").click(function() {
        if ($("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() != "") {
            $("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").after('<br><input type="text" name="penulis" class="penulis">');
        }

        let inputAmount = $("#book-insert table tr:nth-child(2) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-penulis").removeClass("button-disabled");
        }
    });
    $("#rmv-penulis").click(function() {
        // Harus 2 kali karena tekniknya
        let inputAmount = $("#book-insert table tr:nth-child(2) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#book-insert table tr:nth-child(2) td:nth-child(2) br:last-of-type").remove();
            $("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").remove();
        }

        inputAmount = $("#book-insert table tr:nth-child(2) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-penulis").removeClass("button-disabled");
        } else {
            $("#rmv-penulis").addClass("button-disabled");
        }
    });
    $("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").keyup(function() {
        // Kalo kosong
        if (!$("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() || $("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() === " ") {
            $("#add-penulis").addClass("button-disabled");
        } else {
            $("#add-penulis").removeClass("button-disabled");
        }
    });
</script>