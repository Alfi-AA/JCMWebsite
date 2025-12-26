<?php
seasion_start ();
if (isset ($_SESSION['admin'])) {
    header ("Location: index.php");
    exit;
}
include '../koneksi.php';

$id = intval ($_GET['id']);
mysqli_query ($conn, "DELETE FROM kalimat wHERE id = $id");

header ("Location: dashboard.php");
exit;
?>