<?php
session_start () ;

// Inisialisasi permainan jika belum dimulai
if (!isset ($_SESSION ['target'])) {
    $_SESSION['target'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
    $_SESSION['difficulty'] = 'normal';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Game Cerdas - Tebak Angka</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            text-align: center; 
            background-color: #1D1B20; 
            color: white;
            padding: 0;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .card { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            padding: 40px; 
            margin: auto; 
            width: 350px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h1 { 
            color: white; 
            font-size: 1.8rem;
            margin-bottom: 10px;
            text-shadow: 0 0 15px rgba(255,255,255,0.1);
        }

        p {
            color: #ccc;
            margin-bottom: 25px;
        }

        input { 
            padding: 12px; 
            font-size: 1.2rem; 
            width: 120px; 
            text-align: center; 
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #4285f4;
            box-shadow: 0 0 10px rgba(66, 133, 244, 0.5);
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        button { 
            padding: 10px 25px; 
            font-size: 1rem; 
            margin-top: 15px; 
            background: rgba(255, 255, 255, 0.1); 
            color: white; 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 30px; 
            cursor: pointer; 
            transition: all 0.3s;
            font-weight: bold;
        }

        button:hover { 
            background: white; 
            color: #1D1B20;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.1);
        }


        button[style*="background:#b33"] {
            background: rgba(220, 53, 69, 0.2) !important;
            border-color: #dc3545 !important;
            color: #ff6b6b !important;
        }
        
        button[style*="background:#b33"]:hover {
            background: #dc3545 !important;
            color: white !important;
        }


        .result { 
            margin-top: 20px; 
            font-size: 1.1rem; 
            padding: 10px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
            color: #ffd700; 
        }


        .back-button {
            position: absolute; 
            top: 20px;         
            left: 20px;
            transform: none;   
            
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255,255,255,0.7);
            padding: 8px 15px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.9rem;
            border: 1px solid rgba(255,255,255,0.2);
            transition: 0.3s;
            box-shadow: none;
        }

        .back-button:hover {
            background: white;
            color: #1D1B20;
        }

        /* Responsif Mobile */
        @media (max-width: 480px) {
            .card { width: 85%; padding: 30px 20px; }
            .back-button { top: 15px; left: 15px; }
        }
    </style>
</head>
<body>
    <!-- Back button; links to the root index.html in the parent folder -->
    <a href="../index.html" class="back-button" title="Kembali ke halaman utama">← Kembali</a>
    <div class="card">
        <h1>Game Cerdas - Tebak Angka</h1>
        <p>Tebak angka antara <b>1 - 100</b></p>

        <form action="process.php" method="post">
            <input type="number" name="guess" min="1" max="100" required autofocus>
            <br>
            <button type="submit">Tebak!</button>
        </form>

        <form action="reset.php" method="post">
            <button type="submit" style="background:#b33; margin-top:10px;">Reset Game</button>
        </form>

        <?php if (isset ($_SESSION ['message'])): ?>
            <div class="result"><?= $_SESSION ['message']?></div>
        <?php endif; ?>
    </div>
</body>
</html>