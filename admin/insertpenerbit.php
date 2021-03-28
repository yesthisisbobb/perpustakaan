<div class="book-controls" id="penerbit-insert">
    <table>
        <tr>
            <td><label for="penerbit">Penerbit</label></td>
            <td><input type="text" name="penerbit"></td>
        </tr>
    </table>
    <button id="add-penerbit" class="button-success">Tambah penerbit</button>
</div>
<script>
    $("#add-penerbit").click(function() {
        let nama = $("#penerbit-insert input[name='penerbit']").val();

        let action = "";
        $.ajax({
            url: "../processes/insertpenerbit.php",
            method: "POST",
            data: {
                "nama": nama
            },
            success: function(pdata) {
                let data = JSON.parse(pdata);

                let qsFound = false;

                for (let i = 0; i < data.length; i++) {
                    const code = data[i];
                    if (code === "QS") {
                        qsFound = true;
                    }
                }
                if (qsFound) {
                    action = "success";
                }
            },
            error: function(error) {
                console.error(error);
            },
            complete: function() {
                if (action === "success") {
                    toastr.success("Penerbit berhasil ditambahkan!", "Berhasil");
                } else if (action === "failed") {
                    toastr.error("Ada sesuatu yang salah!", "Gagal");
                }
            }
        });

    });
</script>