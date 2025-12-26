<?php
session_start();

$mode = isset($_POST['mode']) ? $_POST['mode'] : "easy";

// Jika skor belum ada, buat baru
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = ["win" => 0, "draw" => 0, "lose" => 0];
}

// Reset papan permainan, tapi simpan skor
$_SESSION['board'] = array_fill (0, 9, "");
$_SESSION['mode'] = $mode;
$_SESSION['message'] = "Permainan baru dimulai. Giliran Anda (X).";
$_SESSION['gameover'] = false;

echo json_encode([
    "board" => $_SESSION['board'],    
    "message" => $_SESSION['message'],
    "mode" => $_SESSION['mode'],
    "gameover" => false,
    "score" => $_SESSION['score']
]);
?>