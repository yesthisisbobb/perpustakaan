<?php
include("../db/config.php");
?>
<div id="book-container">
    <?php include("insertbuku.php"); ?>
    <div id="book-list">
        <table id="book-table" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tanggal Terbit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Row 1 Data 1</td>
                    <td>Row 1 Data 2</td>
                    <td>Row 1 Data 3</td>
                    <td>Row 1 Data 4</td>
                    <td>Row 1 Data 5</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>