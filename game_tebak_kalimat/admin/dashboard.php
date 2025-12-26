<?php
session_start ();
if (!isset ($_SESSION['admin'])) {
    header ("Location: index.php");
    exit;
}
include '../koneksi.php';

// CREATE
if (isset($_POST['tambah'])) {
    $teks = mysqli_real_escape_string($conn, $_POST['teks']);
    if (!empty($teks)) {
        mysqli_query($conn, "INSERT INTO kalimat (teks) VALUES ('$teks')");
        $msg = "✅ Kalimat berhasil ditambahkan!";
    }
}

// READ
$data = mysqli_query($conn, "SELECT * FROM kalimat ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        /* --- 1. GLOBAL STYLE (Tema Dashboard) --- */
        body { 
            font-family: 'Arial', sans-serif; 
            background-color: #1D1B20; /* Warna Background Gelap */
            color: white;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- 2. CONTAINER (Glass Card) --- */
        .container { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 900px;
            margin-top: 50px;
        }

        h2, h3 {
            color: white;
            text-shadow: 0 0 10px rgba(255,255,255,0.1);
        }

        /* --- 3. FORM ELEMENTS --- */
        form {
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 20px;
        }

        textarea { 
            width: 100%; 
            height: 80px; 
            margin-bottom: 15px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            padding: 15px;
            font-size: 1rem;
            outline: none;
            box-sizing: border-box; /* Agar padding tidak melebar */
            resize: vertical;
        }

        textarea:focus {
            border-color: #4285f4;
            background: rgba(0, 0, 0, 0.5);
        }

        /* --- 4. BUTTONS --- */
        button { 
            padding: 10px 20px; 
            cursor: pointer; 
            background: rgba(40, 167, 69, 0.8); /* Hijau Transparan */
            color: white; 
            border: none; 
            border-radius: 30px; 
            font-weight: bold;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        button:hover { 
            background: #28a745; 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        /* Logout Button Styles */
        .logout { 
            float: right; 
            background: rgba(220, 53, 69, 0.2); 
            color: #ff6b6b; 
            padding: 8px 15px; 
            border-radius: 20px; 
            text-decoration: none; 
            font-size: 0.9rem; 
            border: 1px solid rgba(220, 53, 69, 0.5);
            transition: 0.3s;
        }

        .logout:hover { 
            background: #dc3545; 
            color: white;
        }

        /* --- 5. TABLE STYLES --- */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            color: #ddd;
        }

        th, td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Garis tipis */
        }

        th { 
            background: rgba(255, 255, 255, 0.05); 
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.03); /* Highlight baris saat hover */
        }

        /* Link Aksi (Edit/Hapus) */
        td a { 
            text-decoration: none; 
            color: #4285f4; 
            font-weight: bold;
            transition: 0.2s;
            margin-right: 10px;
        }

        td a:hover { 
            text-decoration: underline; 
            color: white;
        }
        
        /* Khusus link Hapus warnanya merah */
        td a[href*="hapus"] {
            color: #ea4335;
        }
        td a[href*="hapus"]:hover {
            color: #ff6b6b;
        }

        .msg { 
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #28a745;
        }

        /* --- 6. NAVIGASI HOME --- */
        .back-home {
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
        }
        .back-home:hover {
            background: white;
            color: #1D1B20;
        }

        /* Responsif Mobile */
        @media (max-width: 600px) {
            .container { width: 95%; padding: 20px; }
            .logout { float: none; display: inline-block; margin-top: 10px; }
            th, td { padding: 10px 5px; font-size: 0.9rem; }
            textarea { height: 100px; }
        }
    </style>
</head>
<body>
    <a href="../index.php" class="back-home">🏠 Ke Halaman Utama</a>
    <div class="container">
        <h2>📋 Dashboard Admin</h2>
        <a href="logout.php" class="logout">🚪 Logout</a>
        <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

        <form method="post">
            <textarea name="teks" placeholder="Tulis kalimat baru di sini..." required></textarea><br>
            <button type="submit" name="tambah">➕ Tambah Kalimat</button>
        </form>

        <h3>Daftar Kalimat</h3>
        <table>
        <tr>
            <th>ID</th>
            <th>Kalimat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['teks']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">✏️ Edit</a> | 
                <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus kalimat ini?')">🗑️ Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    </div>
</body>
</html>