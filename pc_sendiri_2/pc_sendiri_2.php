<?php
function ps ($cmd) {
    return trim(shell_exec("powerShell -NoProfile -Command \"$cmd\""));
}

// ========== OS ==========
$os = ps("(Get-CimInstance Win32_OperatingSystem).Caption");

// ========== CPU ==========
$cpu = ps("(Get-CimInstance Win32_Processor).Name");

// ========== RAM ==========
// dalam bytes -> konversi ke GB

$ramBytes = ps("(Get-CimInstance Win32_ComputerSystem).TotalPhysicalMemory");
$ramGB = round($ramBytes / 1073741024, 2);

// ========== GPU ==========
$gpu = ps("(Get-CimInstance Win32_VideoController)[0].Name");

// ========== Motherboard ==========
$mb = ps("(Get-CimInstance Win32_BaseBoard).Product");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Hardware - PowerShell</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1D1B20; 
            color: white;
            padding: 0;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            width: 90%;
            max-width: 600px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left; 
            position: relative;
        }

        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 30px;
            font-size: 1.8rem;
            text-shadow: 0 0 10px rgba(255,255,255,0.1);
        }

        .item {
            margin-bottom: 15px;
            font-size: 1.1rem;
            padding: 15px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column; 
        }
        
        .item strong {
            color: #4285f4; 
            margin-bottom: 5px;
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
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-button:hover {
            background: white;
            color: #1D1B20;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.1);
        }

        @media (min-width: 600px) {
            .item {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            .item strong {
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Back button (top-left). Uses history.back() if possible; falls back to ../index.html -->
    <a href="../index.html" class="back-button" aria-label="Kembali ke halaman sebelumnya" onclick="if (history.length>1){ history.back(); return false;}" title="Kembali ke halaman sebelumnya">← Kembali</a>
    <div class="box">
        <h2>Deteksi Hardware (PowerShell)</h2>
        <div class="item"><strong>OS:</strong> <?= $os ?></div>
        <div class="item"><strong>CPU:</strong> <?= $cpu ?></div>
        <div class="item"><strong>RAM:</strong> <?= $ramGB ?>GB</div>
        <div class="item"><strong>GPU:</strong> <?= $gpu ?></div>
        <div class="item"><strong>Motherboard:</strong> <?= $mb ?></div>
    </div>
</body>
</html>