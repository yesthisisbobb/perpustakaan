<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <?php include("../components/lib.php"); ?>
    <link rel="stylesheet" href="dashboard.css">

</head>

<body>
    <div id="nav">
        <div class="base">
            <div id="nav-close"><i class="fas fa-chevron-left"></i></div>
            <div class="nav-item">
                <div class="n-left">
                    <i class="fas fa-columns"></i>
                </div>
                <div class="n-right">
                    Dashboard
                </div>
            </div>
            <div class="nav-item">
                <div class="n-left">
                    <i class="fas fa-book"></i>
                </div>
                <div class="n-right">
                    Buku
                </div>
            </div>
            <div class="nav-item">
                <div class="n-left">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="n-right">
                    Peminjaman
                </div>
            </div>
            <div class="nav-item">
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

        </div>
    </div>
</body>

</html>

<script>
    let navClosed = false;
    let firstClosingHappened = false;

    function fillMain(comp) {
        $("#main .content").load("insertbuku.php");
    }
    fillMain("default");

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
    });
</script>