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
    $("#add-buku").click(function() {
        let judul = $("#book-insert input[name='judul']").val();
        let tt = $("#book-insert input[name='tt']").val();

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
                "tt": tt,
                "dp": dpDb
            },
            success: function(pdata) {
                console.log(pdata + " - " + typeof(pdata));

                let is1Found = false;
                let is2Found = false;

                for (let i = 0; i < pdata.length; i++) {
                    const code = pdata[i];
                    if (code === "IS1") {
                        is1Found = true;
                    }
                    if (code === "IS2") {
                        is2Found = true;
                    }
                }
                if (is1Found && is2Found) {
                    action = "success";
                } else {
                    action = "failed";
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

    $("#add-dp").click(function() {
        if ($("#book-insert table tr:nth-child(4) td:nth-child(2) input:last-of-type").val() != "") {
            $("#book-insert table tr:nth-child(4) td:nth-child(2) input:last-of-type").after('<br><input type="text" name="dp" class="dp">');
        }

        let inputAmount = $("#book-insert table tr:nth-child(4) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-dp").removeClass("button-disabled");
        }
    });
    $("#rmv-dp").click(function() {
        // Harus 2 kali karena tekniknya
        let inputAmount = $("#book-insert table tr:nth-child(4) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#book-insert table tr:nth-child(4) td:nth-child(2) br:last-of-type").remove();
            $("#book-insert table tr:nth-child(4) td:nth-child(2) input:last-of-type").remove();
        }

        inputAmount = $("#book-insert table tr:nth-child(4) td:nth-child(2) input").length;
        if (inputAmount > 1) {
            $("#rmv-dp").removeClass("button-disabled");
        } else {
            $("#rmv-dp").addClass("button-disabled");
        }
    });

    // Baru bisa nambah kalo keisi - Add penulis
    $("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").keyup(function() {
        // Kalo kosong
        if (!$("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() || $("#book-insert table tr:nth-child(2) td:nth-child(2) input:last-of-type").val() === " ") {
            $("#add-penulis").addClass("button-disabled");
        } else {
            $("#add-penulis").removeClass("button-disabled");
        }
    });
    // Baru bisa nambah kalo keisi - Add Daftar Pustaka
    $("#book-insert table tr:nth-child(4) td:nth-child(2) input:last-of-type").keyup(function() {
        // Kalo kosong
        if (!$("#book-insert table tr:nth-child(4) td:nth-child(2) input:last-of-type").val() || $("#book-insert table tr:nth-child(4) td:nth-child(2) input:last-of-type").val() === " ") {
            $("#add-dp").addClass("button-disabled");
        } else {
            $("#add-dp").removeClass("button-disabled");
        }
    });
</script>