<!DOCTYPE html>
<html>
<head>
    <title>Gebruikersnaam en wachtwoord wijzigen</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .dashboard {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #0A2558;
            color: #fff;
            padding-top: 20px;
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
        }

        .nav-links a:hover {
            background-color: darkblue;
        }

        .nav-links .active {
            background-color: darkblue;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        #searchForm {
            margin-bottom: 20px;
        }

        #resultaat {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-details">
                <i class='bx bx-chevron-down'></i>
                <span class="admin_name">Admin</span>
            </div>
            <ul class="nav-links">
                <li><a href="Beheerder.php">dashboard</a></li>
                <!-- Andere zijbalklinks hier toevoegen indien nodig -->
            </ul>
            <ul class="nav-links">
                <li><a href="account.php">Wachtwoord</a></li>
                <!-- Andere zijbalklinks hier toevoegen indien nodig -->
            </ul>
        </div>


        <!-- Content -->
    <div class="content">
        <h1> Gebruikersnaam en wachtwoord wijzigen</h1>
        <form method="post" action="account.php">
            <!-- Veld voor de gebruikersnaam -->
            <label for="gebruikersnaam">Gebruikersnaam:</label>
            <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br><br>

            <!-- Veld voor het nieuwe wachtwoord -->
            <label for="wachtwoord">Nieuw wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord"><br><br>

            <input type="submit" value="Wijzigen">
        </form>
    </div>
</div>
</body>
</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Maak verbinding met de database
$db_host = 'localhost';
$db_name = 'project';
$db_user = 'root';
$db_pass = '';

try {
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$gebruikersnaam = $_POST['gebruikersnaam'];
$wachtwoord = $_POST['wachtwoord']; // Niet hashen

// Bereid een SQL-query voor om gebruikersgegevens op te slaan
$stmt = $conn->prepare("INSERT INTO account (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)");
$stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
$stmt->bindParam(':wachtwoord', $wachtwoord); // Gebruik het wachtwoord zoals ingevoerd

// Voer de SQL-query uit
$stmt->execute();
echo "Wachtwoord succesvol opgeslagen in de database";
} catch(PDOException $e) {
echo "Fout bij het opslaan van het wachtwoord: " . $e->getMessage();
}
}
?>