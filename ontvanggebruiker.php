<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleer of het klachtformulier is ingediend
    if (isset($_POST['klacht'])) {
        $_SESSION['klacht'] = $_POST['klacht']; // Bewaar de klachtgegevens in een sessievariabele
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Ontvangen Klacht</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Googlefont Poppins CDN Link */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        /* Gecombineerde CSS-stijlen */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .dashboard {
            display: flex;
            height: 100%;
        }

        /* Sidebar CSS-stijlen */
        .sidebar {
            width: 250px;
            background: #0A2558;
            color: #fff;
            padding-top: 20px;
            height: 100vh;
        }

        .logo-details {
            display: flex;
            height: 60px;
            align-items: center;
            padding-left: 20px;
            font-weight: bold;
            font-size: 20px;
        }

        .logo-details i {
            font-size: 24px;
            margin-right: 5px;
        }

        .nav-links {
            padding-left: 0;
        }

        .nav-links li {
            list-style: none;
            margin-bottom: 10px;
        }

        .nav-links a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background-color: #081D45;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        div {
            width: 80%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h3 {
            margin-bottom: 10px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="sidebar">
        <ul class="nav-links">
            <li><a href="Beheerder.php" class="active">Dashboard</a></li>
            <!-- Voeg andere zijbalk-links toe zoals nodig -->
        </ul>
    </div>

    <div class="content">
        <h1>Ontvangen Klacht</h1>

        <div>
            <h3>Ingediende klacht:</h3>
            <textarea rows="8" cols="50"><?php echo isset($_SESSION['klacht']) ? $_SESSION['klacht'] : ''; ?></textarea>
            <!-- Andere klachtgegevens kunnen hier ook worden weergegeven -->
        </div>
    </div>
</div>
</body>
</html>
