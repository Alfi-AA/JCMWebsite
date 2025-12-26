<?php
// 1. MEMULAI SESI
session_start ();

// Pilihan yang Tersedia
$choices = [
    'batu' => 'Batu',
    'kertas' => 'Kertas',
    'gunting' => 'Gunting'
];

// 2. LOGIKA INISIALISASI & RESET SKOR
if (!isset ($_SESSION ['player_score']) || isset ($_POST['reset'])) {
    $_SESSION['player_score'] = 0;
    $_SESSION['computer_score'] = 0;
    $_SESSION['round_message'] = "Pilih Batu, Kertas, atau Gunting untuk memulai!";
    $_SESSION['player_choice' ] = '';
    $_SESSION['computer_choice' ] = '';
}

$player_score = $_SESSION['player_score'];
$computer_score = $_SESSION['computer_score'];
$round_message = $_SESSION ['round_message'];
$player_choice_display = $_SESSION['player_choice'];
$computer_choice_display = $_SESSION ['computer_choice'];

// 3. FUNGSI UNTUK MENENTUKAN PEMENANG
function determine_winner ($player, $computer) {
    if ($player === $computer) {
        return 'seri';
    }
    
    // Aturan Suit: Batu > Gunting, Gunting > Kertas, Kertas > Batu
    if (
        ($player === 'batu' && $computer === 'gunting' ) ||
        ($player === 'gunting' && $computer === 'kertas' ) ||
        ($player === 'kertas' && $computer === 'batu')
    )   {
            return 'pemain';
        } else {
            return 'komputer';
        }
}

// 4. LOGIKA PEMROSESAN PILIHAN
if (isset ($_POST ['choice'])) {
    $player_raw_choice = strtolower ($_POST ['choice']);
    
    // Pastikan pilihan valid
    if (!array_key_exists ($player_raw_choice, $choices)) {
        $_SESSION ['round message'] = "Pilihan tidak valid.";
    } else {
        // Pilihan Komputer (acak dari array keys)
        $computer_raw_choice = array_rand ($choices);
        
        // Tentukan pemenang
        $winner = determine_winner ($player_raw_choice, $computer_raw_choice);
        
        // Simpan tampilan untuk sesi ini
        $_SESSION['player_choice'] = $choices [$player_raw_choice];
        $_SESSION['computer_choice'] = $choices [$computer_raw_choice];
        
        // Perbarui Skor dan Pesan
        if ($winner === 'pemain') {
            $_SESSION ['player_score']++;
            $_SESSION ['round_message'] = "Anda Menang! {$choices[$player_raw_choice]} mengalahkan
            {$choices[$computer_raw_choice]}.";
        } elseif ($winner === 'komputer') {
            $_SESSION['computer_score']++;
            $_SESSION['round _message'] = "Anda Kalah. {$choices [$computer_raw_choice]} mengalahkan
            {$choices[$player_raw_choice]}.";
        } else {
            $_SESSION['round message'] = "Seri! Anda berdua memilih {$choices [$player_raw_choice]}.";
        }
        
        // Perbarui variabel tampilan
        $player_score = $_SESSION ['player_score'];
        $computer_score = $_SESSION ['computer_score'];
        $round_message = $_SESSION ['round_message'];
        $player_choice_display = $_SESSION ['player_choice'];
        $computer_choice_display = $_SESSION ['computer_choice'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Batu Kertas Gunting (PHP Game)</title>
    <style>
        /* --- 1. GLOBAL STYLE (Tema Dashboard) --- */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1D1B20; /* Warna Background Gelap */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        /* --- 2. CONTAINER (Glass Card) --- */
        .container {
            background: rgba(255, 255, 255, 0.05); /* Transparan */
            backdrop-filter: blur(10px); /* Efek Blur */
            padding: 40px;
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            position: relative;
        }
        
        h1 {
            color: white;
            margin-bottom: 25px;
            text-shadow: 0 0 15px rgba(255,255,255,0.1);
            font-size: 2rem;
        }
        
        h2 {
            font-size: 1.2rem;
            color: #ccc;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        /* --- 3. SCORE BOARD --- */
        .score-board {
            display: flex;
            justify-content: space-around;
            background: rgba(0, 0, 0, 0.3); /* Gelap */
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .score {
            font-size: 1.1em;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .score strong {
            font-size: 2em;
            margin-top: 5px;
        }
        
        .player-score { color: #4285f4; } /* Biru Google */
        .computer-score { color: #ea4335; } /* Merah Google */
        
        /* --- 4. MESSAGE AREA --- */
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.1em;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .last-move {
            margin-top: 20px;
            padding: 15px;
            background-color: rgba(251, 188, 5, 0.1); /* Kuning Transparan */
            border: 1px solid rgba(251, 188, 5, 0.3);
            border-radius: 10px; 
            color: #fbbc05;
            font-size: 0.95em;
        }
        
        /* --- 5. GAME BUTTONS (Batu Kertas Gunting) --- */
        .choices {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .choice-btn {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 15px 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px; /* Kapsul */
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s;
            flex: 1;
            min-width: 100px;
        }
        
        .choice-btn:hover {
            background-color: white;
            color: #1D1B20;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }
        
        /* --- 6. RESET BUTTON --- */
        .reset-btn {
            background-color: rgba(220, 53, 69, 0.2); /* Merah Transparan */
            color: #ff6b6b;
            padding: 10px 25px;
            border: 1px solid rgba(220, 53, 69, 0.5);
            border-radius: 20px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 0.9em;
            transition: 0.3s;
        }
        
        .reset-btn:hover {
            background-color: #dc3545;
            color: white;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.4);
        }

        /* --- 7. BACK BUTTON (Navigation) --- */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 10px;
            transition: 0.3s;
            background: rgba(255,255,255,0.05);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .back-button:hover {
            background: white;
            color: #1D1B20;
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .container { padding: 20px; }
            .choices { flex-direction: column; }
            .choice-btn { width: 100%; }
        }
    </style>
</head>
<body>
    
    <!-- Back button (top-left) - goes to main index.html in the parent folder -->
    <a class="back-button" href="../index.html" aria-label="Kembali ke halaman utama">← Kembali</a>

<div class="container">
    <h1> Batu, Kertas, Gunting </h1>
    
    <div class="score-board">
        <div class="score player-score">Pemain: <strong> <?php echo $player_score; ?></strong></div>
        <div class="score computer-score">Komputer: <strong> <?php echo $computer_score; ?></strong></div>
    </div>
    
    <div class="message">
        <?php echo htmlspecialchars ($round_message); ?>
    </div>
    
    <?php if ($player_choice_display): ?>
    <div class="last-move">
        Pilihan Anda: <strong> <?php echo $player_choice_display; ?></strong>
        <br>
        Pilihan Komputer: <strong> <?php echo $computer_choice_display; ?></strong>
    </div>
    <?php endif; ?>
    
    <h2>Pilih: </h2>
    <form method="POST" class="choices">
        <button type="submit" name="choice" value="batu" class="choice-btn">Batu</button>
        <button type="submit" name="choice" value="kertas" class="choice-btn">Kertas</button>
        <button type="submit" name="choice" value="gunting" class="choice-btn">Gunting</button>
    </form>
    
    <form method="POST">
        <button type="submit" name="reset" class="reset-btn">Mulai Ulang Skor</button>
    </form>
</div>

</body>
</html>