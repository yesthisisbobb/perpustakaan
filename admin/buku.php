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