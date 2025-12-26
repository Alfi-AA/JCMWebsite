<?php
include 'koneksi.php';

$query = "SELECT * FROM kalimat ORDER BY RAND() LIMIT 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$kalimat_asli = strtoupper($data['teks']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tebak Kalimat (3 kesempatan)</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            text-align: center; 
            background-color: #1D1B20; 
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 800px;
            width: 90%;
            display: inline-block; 
            position: relative;
        }

        h1 { 
            font-size: 2rem;
            margin-bottom: 10px;
            text-shadow: 0 0 15px rgba(255,255,255,0.1);
        }

        p {
            color: #ccc;
            margin-bottom: 25px;
            font-size: 1rem;
        }

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
            z-index: 100;
        }

        .admin-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 10px;
            transition: 0.3s;
            background: rgba(255,255,255,0.05);
            font-size: 0.9rem;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .back-button:hover, .admin-button:hover {
            background: white;
            color: #1D1B20;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.1);
        }

        #nyawa {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }

        .kalimat { 
            font-size: 2rem; 
            letter-spacing: 5px; 
            margin-bottom: 30px; 
            font-weight: bold;
            word-wrap: break-word;
            color: #fff;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
            min-height: 40px;
        }

        #keyboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        #keyboard button { 
            padding: 10px 14px; 
            font-size: 1rem; 
            cursor: pointer; 
            border: 1px solid rgba(255,255,255,0.2); 
            border-radius: 8px; 
            background: rgba(255, 255, 255, 0.1); 
            color: white; 
            transition: all 0.2s;
            font-weight: bold;
            width: 45px; height: 45px;
        }

        #keyboard button:hover {
            background: white;
            color: #1D1B20;
            transform: translateY(-2px);
        }

        #keyboard button:disabled {
            background: rgba(0,0,0,0.2);
            color: #555;
            cursor: not-allowed;
            transform: none;
        }

        .correct { 
            background: #34a853 !important; 
            border-color: #34a853 !important;
            color: white !important;
            box-shadow: 0 0 10px #34a853 !important;
        }
        
        .wrong { 
            background: #ea4335 !important; 
            border-color: #ea4335 !important;
            color: white !important;
            opacity: 0.6;
        }

        #hasil { 
            font-size: 1.2rem; 
            margin-top: 20px; 
            font-weight: bold; 
            min-height: 30px;
        }

        body > .container > button {
            padding: 12px 30px;
            font-size: 1rem;
            margin-top: 20px;
            background: rgba(66, 133, 244, 0.2); 
            color: #4285f4;
            border: 1px solid #4285f4;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
        }

        body > .container > button:hover {
            background: #4285f4;
            color: white;
            box-shadow: 0 0 20px rgba(66, 133, 244, 0.4);
        }

        @media (max-width: 600px) {
            .container { padding: 20px; margin-top: 40px; }
            .kalimat { font-size: 1.5rem; letter-spacing: 2px; }
            #keyboard button { width: 35px; height: 35px; font-size: 0.9rem; padding: 5px; }
            
            .back-button, .admin-button {
                padding: 6px 10px;
                font-size: 0.8rem;
                top: 15px;
            }
        }
    </style>
</head>
<body>
    <a href="../index.html" class="back-button">← Kembali</a>

    <a href="admin/dashboard.php" class="admin-button">Admin ⚙️</a>
    <div class="container">
        <h1>🎯 Tebak Kalimat Per Huruf</h1>
        <p>Tebak huruf satu per satu. Kamu hanya punya <b>3 kesempatan</b> untuk salah</p>

        <div id="nyawa">❤️❤️❤️</div>
        <div id="kalimat" class="kalimat"></div>
        <div id="keyboard"></div>
        <div id="hasil"></div>

        <br>
        <button onclick="location.reload()">🔁 Main Lagi</button>
    </div>

    <script>
        const kalimatAsli = "<?= $kalimat_asli ?>";
        let tampil = kalimatAsli.replace(/[A-Z]/g, '_');
        let salah = 0;
        let nyawaMaks = 3;
        document.getElementById('kalimat').textContent = tampil;
        updateNyawa();

        const keyboard = document.getElementById('keyboard');
        const huruf = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for (let i = 0; i < huruf.length; i++) {
            const btn = document.createElement('button');
            btn.textContent = huruf[i];
            btn.onclick = () => tebakHuruf(btn, huruf[i]);
            keyboard.appendChild(btn);
        }

        function updateNyawa() {
            let hearts = '';
            for (let i = 0; i < nyawaMaks - salah; i++) hearts += '❤️';
            for (let i = 0; i < salah; i++) hearts += '🖤'; 
            document.getElementById('nyawa').innerHTML = hearts;
        }

        function tebakHuruf(btn, huruf) {
            btn.disabled = true;
            let benar = false;
            let tampilBaru = '';

            for (let i = 0; i < kalimatAsli.length; i++) {
                if (kalimatAsli[i] === huruf) {
                    tampilBaru += huruf;
                    benar = true;
                } else {
                    tampilBaru += tampil[i];
                }
            }

            tampil = tampilBaru;
            document.getElementById('kalimat').textContent = tampil;

            if (benar) {
                btn.classList.add('correct');
            } else {
                btn.classList.add('wrong');
                salah++;
                updateNyawa();
            }

            if (tampil.indexOf('_') === -1) {
                document.getElementById('hasil').innerHTML = "🎉 <span style='color:green;'>Selamat! Kamu berhasil menebak kalimatnya! </span><br><br><b>" + kalimatAsli + "</b>";
                nonaktifkanKeyboard();
            }

            if (salah >= nyawaMaks) {
                document.getElementById('hasil').innerHTML = "💀 <span style='color:red;'>Kamu kehabisan kesempatan!</span><br><br>Kalimat yang benar adalah:<br><b>" + kalimatAsli + "</b>";
                nonaktifkanKeyboard();
            }
        }

        function nonaktifkanKeyboard() {
            const allBtns = document.querySelectorAll('#keyboard button');
            allBtns.forEach(b => b.disabled = true);
        }
    </script>
</body>
</html>