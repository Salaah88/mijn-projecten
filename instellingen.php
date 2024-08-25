<!DOCTYPE html>
<html>
<head>
    <title>Gebruikersnaam en wachtwoord wijzigen</title>
    <link rel="stylesheet" href="gebruiker.css">



</head>

<style>
    /* Standaard opmaak voor de hele pagina */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    /* Stijl voor de hoofdcontainer */
    .dashboard {
        display: flex;
    }

    /* Stijl voor de zijbalk */
    .sidebar {
        width: 250px;
        height: 100vh;
        background: #333;
        padding-top: 20px;
        color: white;
    }

    .sidebar ul {
        list-style: none;
        padding-left: 0;
    }

    .sidebar ul li {
        padding: 10px 20px;
        border-bottom: 1px solid #555;
    }

    .sidebar ul li a {
        color: white;
        text-decoration: none;
    }

    .sidebar ul li:hover {
        background: #555;
    }

    /* Stijl voor de content sectie */
    .content {
        flex: 1;
        padding: 20px;
    }

    .content h1 {
        margin-bottom: 20px;
    }

    /* Stijl voor het formulier */
    form {
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
        width: calc(100% - 12px);
        padding: 5px;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        background-color: #333;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #555;
    }



</style>

<body>
<div class="dashboard">
    <div class="dashboard">

        <div class="sidebar">
            <div class="logo-details">
                <i class='bx bx-chevron-down'></i>
                <span class="admin_name"></span>
            </div>
            <ul class="nav-links">
                <li><a href="gebruiker.php">dashboard</a></li>
                <!-- Andere zijbalklinks hier toevoegen indien nodig -->
            </ul>
            <ul class="nav-links">
                <li><a href="instellingen.php">Wachtwoord</a></li>
                <!-- Andere zijbalklinks hier toevoegen indien nodig -->
            </ul>
        </div>


        <!-- Content -->
        <div class="content">
            <h1> Gebruikersnaam en wachtwoord wijzigen</h1>
            <form method="post" action="instellingen.php">
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
        $stmt = $conn->prepare("INSERT INTO instellingen (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)");
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
