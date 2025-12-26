<?php
session_start ();

if (isset ($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "admin" && $password == "1234") {
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            text-align: center; 
            background-color: #1D1B20; 
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

        form { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 300px;
        }

        input { 
            padding: 12px 15px; 
            width: 100%; 
            box-sizing: border-box; 
            background: rgba(0, 0, 0, 0.3); 
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #4285f4; 
            box-shadow: 0 0 10px rgba(66, 133, 244, 0.3);
            background: rgba(0, 0, 0, 0.5);
        }

        input::placeholder {
            color: #aaa;
        }

        button {
            padding: 12px;
            font-size: 1rem;
            margin-top: 10px;
            background: rgba(66, 133, 244, 0.8);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            width: 100%;
        }

        button:hover {
            background: #4285f4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 133, 244, 0.4);
        }

        .error {
            color: #ff6b6b;
            background: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 8px;
            margin-top: 15px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            font-size: 0.9rem;
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
        }

        .back-button:hover {
            background: white;
            color: #1D1B20;
        }
    </style>
</head>
<body>
    <a href="../index.php" class="back-button">← Kembali</a>
    <h2>🔑 Login Admin</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Masuk</button>
    </form>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
</body>
</html>