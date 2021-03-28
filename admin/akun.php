<div id="akun-list">
    <table id="akun-table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Reset Password</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    $("#akun-table").on("click", ".akun-actions", function() {
        let act = $(this).attr("act");
        let uid = $(this).attr("uid");

        let action = "";
        let qsFound = false;
        if (act === "reset") {
            $.ajax({
                url: "../processes/resetpassword.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    "uid": uid
                },
                success: function(data) {
                    console.log(data);
                    for (let i = 0; i < data.length; i++) {
                        const item = data[i];
                        if (item === "QS") {
                            qsFound = true;
                        }
                    }
                },
                complete: function() {
                    if (qsFound) {
                        toastr.success("Password user sudah di-reset", "Success");
                    }
                }
            });
        }
    })
</script>