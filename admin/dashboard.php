<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include("../components/lib.php"); ?>

    <!-- JQUERY DATATABLES -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="dashboard.css">

    <!-- Sweet Alert -->
    <script src="../vendor/sweetalert/dist/sweetalert2.all.min.js"></script>
    <script src="../vendor/sweetalert/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../vendor/sweetalert/dist/sweetalert2.min.css">
</head>

<body>
    <div id="nav">
        <div class="base">
            <div id="nav-close"><i class="fas fa-chevron-left"></i></div>
            <div class="nav-item" id="dash">
                <div class="n-left">
                    <i class="fas fa-columns"></i>
                </div>
                <div class="n-right">
                    Dashboard
                </div>
            </div>
            <div class="nav-item" id="buku">
                <div class="n-left">
                    <i class="fas fa-book"></i>
                </div>
                <div class="n-right">
                    Buku
                </div>
            </div>
            <div class="nav-item" id="pmjn">
                <div class="n-left">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="n-right">
                    Peminjaman
                </div>
            </div>
            <div class="nav-item" id="mnjn">
                <div class="n-left">
                    <i class="fas fa-users"></i>
                </div>
                <div class="n-right">
                    Manajemen Akun
                </div>
            </div>
        </div>
    </div>
    <div id="main">
        <div class="content">
            <!-- ISI NANTINYA DITAMPILKAN DISINI -->
        </div>
    </div>
</body>

</html>

<script>
    let COMP_DEFAULT = "default";
    let COMP_BUKU = "buku";
    let COMP_AKUN = "akun";

    let navClosed = false;
    let firstClosingHappened = false;

    let dataTable;

    function fillMain(comp) {
        $(".nav-item").each(function () {
            $(this).css("color", "black");
        });

        if (comp === COMP_DEFAULT) {
            $("#dash").css("color", "royalblue");
        } else if (comp === COMP_BUKU) {
            $("#buku").css("color", "royalblue");

            $("#main .content").load("buku.php", function() {
                dataTable = $("#book-table").DataTable({
                    "paging": true,
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "info": true,
                    "ajax": {
                        url: "../processes/allbukudatatable.php",
                        type: "POST"
                    },
                    "columnDefs": [{
                            "targets": [0, -1, -2],
                            "orderable": false,
                        },
                        {
                            "targets": [-1, -2],
                            "searchable": false
                        }
                    ],
                });
            });
        } else if (comp === COMP_AKUN) {
            $("#mnjn").css("color", "royalblue");

            $("#main .content").load("akun.php", function() {
                dataTable = $("#akun-table").DataTable({
                    "paging": true,
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "info": true,
                    "ajax": {
                        url: "../processes/alluserdatatable.php",
                        type: "POST"
                    },
                    "columnDefs": [{
                            "targets": [-1],
                            "orderable": false,
                        },
                        {
                            "targets": [-1],
                            "searchable": false
                        }
                    ],
                });
            });
        }
    }
    fillMain(COMP_AKUN);

    // Biar dari page lain bisa reload, UNSAFE karena script ini harus ke-load dulu sebelum yang lain
    function reloadDT() {
        dataTable.ajax.reload();
    }

    $(document).ready(function() {
        $("#nav-close").click(function() {
            if (navClosed) {
                navClosed = false;
                $("#nav-close i").removeClass("rotate-180");
                $("#nav").css("transform", `translateX(0px)`);
            } else {
                navClosed = true;
                if (!firstClosingHappened) {
                    firstClosingHappened = true;
                    $("#main").css({
                        "width": "100%",
                        "padding-left": "0"
                    });
                }
                $("#nav-close i").addClass("rotate-180");
                $("#nav").css("transform", `translateX(-${$("#nav").width()}px)`);
            }
        });
        $(".nav-item").click(function() {
            let id = $(this).attr("id");

            if (id === "buku") {
                fillMain(COMP_BUKU);
            } else if (id === "mnjn") {
                fillMain(COMP_AKUN);
            }
        });
    });

    $("#main .content").on("click", "#add-buku", function() {
        dataTable.ajax.reload();
    });
    $("#main .content").on("click", "#update-buku", function() {
        dataTable.ajax.reload();
    });
</script>