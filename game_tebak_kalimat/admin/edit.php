<?php
session_start ();
if (!isset ($_SESSION['admin'])) {
    header ("Location: index.php");
    exit;
}
include '../koneksi.php';

$id = $_GET['id'];
$query = mysqli_query ($conn, "SELECT * FROM kalimat WHERE id = $id");
$data = mysqli_fetch_assoc ($query);

if (!$data){
    die("Data tidak ditemukan!");
}

if (isset ($_POST['update'])) {
    $teks = mysqli_real_escape_string ($conn, $_POST['teks']);
    mysqli_query($conn, "UPDATE kalimat SET teks = '$teks' WHERE id = $id");
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kalimat</title>
    <style>
        /* --- 1. GLOBAL STYLE (Tema Dashboard) --- */
        body { 
            font-family: 'Arial', sans-serif; 
            text-align: center; 
            background-color: #1D1B20; /* Warna Background Gelap */
            color: white;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 0 0 15px rgba(255,255,255,0.1);
            color: white;
        }

        /* --- 2. FORM CONTAINER (Glass Card) --- */
        form { 
            background: rgba(255, 255, 255, 0.05); /* Transparan */
            backdrop-filter: blur(10px); /* Efek Blur */
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* --- 3. TEXTAREA --- */
        textarea { 
            width: 100%; 
            height: 120px; 
            box-sizing: border-box; 
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            padding: 15px;
            font-size: 1rem;
            outline: none;
            resize: vertical; /* User bisa atur tinggi */
            font-family: inherit;
        }

        textarea:focus {
            border-color: #4285f4;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 10px rgba(66, 133, 244, 0.3);
        }

        /* --- 4. BUTTON (Simpan - Hijau) --- */
        button { 
            padding: 12px 20px; 
            cursor: pointer; 
            background: rgba(40, 167, 69, 0.8); /* Hijau Transparan */
            color: white; 
            border: none; 
            border-radius: 30px; 
            font-weight: bold;
            font-size: 1rem;
            transition: 0.3s;
        }

        button:hover {
            background: #28a745; 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        /* --- 5. LINK KEMBALI --- */
        form a {
            text-decoration: none;
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            margin-top: 10px;
            transition: 0.3s;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid transparent;
        }

        form a:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }

        /* Responsif */
        @media (max-width: 600px) {
            form { width: 85%; padding: 30px; }
        }
    </style>
</head>
<body>
    <h2>✏️ Edit Kalimat</h2>
    <form method="post">
        <textarea name="teks" required><?= htmlspecialchars($data['teks'])?></textarea><br>
        <button type="submit" name="update">Simpan Perubahan</button>
        <br><br>
        <a href="dashboard.php"><----- Kembali</a>
    </form>
</body>
</html>