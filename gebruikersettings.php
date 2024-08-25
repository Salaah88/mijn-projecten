<!DOCTYPE html>
<html>
<head>
    <title>Gebruikersbeheer</title>
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
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- ... (bestaande zijbalkinhoud) ... -->

        <!-- Nieuwe zijbalklink om gebruikers toe te voegen -->
        <ul class="nav-links">
            <li><a href="gebruiker_toevoegen.php">Gebruiker toevoegen</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Gebruikersbeheer</h1>

        <!-- Code voor het tonen en verwijderen van gebruikers -->
        <?php
        session_start(); // Start de sessie als die nog niet gestart is

        // Hier zou je jouw authenticatie- en autorisatielogica moeten plaatsen,
        // zoals sessiebeheer, gebruikersautorisatie, etc.

        // Voorbeeld:
        // Controleer of de gebruiker is ingelogd, anders doorsturen naar de inlogpagina
        // if (!isset($_SESSION['logged_in'])) {
        //     header("Location: login.php");
        //     exit();
        // }

        // Controleer of de gebruiker is ingelogd (voor nu simuleren we dit met een variabele)
        $_SESSION['logged_in'] = true;

        // Code voor het weergeven van gebruikers en de mogelijkheid om ze te verwijderen
        // Hier zou je een lijst met gebruikers uit de database moeten halen
        $gebruikers = array("Gebruiker1", "Gebruiker2", "Gebruiker3");

        // Toon de lijst met gebruikers
        echo "<ul>";
        foreach ($gebruikers as $gebruiker) {
            echo "<li>$gebruiker <a href='gebruiker_verwijderen.php?gebruiker=$gebruiker'>Verwijder</a></li>";
        }
        echo "</ul>";

        // Logica om gebruikers te verwijderen
        if (isset($_GET['gebruiker'])) {
            $teVerwijderenGebruiker = $_GET['gebruiker'];

            // Voer hier de logica uit om de gebruiker te verwijderen, bijvoorbeeld in een database.

            // Voorbeeld van het verwijderen van een gebruiker (vervang dit met jouw database logica)
            // Vervang 'jouw_database_host', 'jouw_database_naam', 'jouw_database_gebruikersnaam' en 'jouw_database_wachtwoord'
            $db_host = 'localhost';
            $db_name = 'project';
            $db_user = 'root';
            $db_pass = '';

            try {
                // Maak verbinding met de database
                $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Bereid de query voor om de gebruiker te verwijderen
                $stmt = $conn->prepare("DELETE FROM inloggen WHERE gebruikersnaam = :gebruiker");

                // Voer de query uit
                $stmt->bindParam(':gebruiker', $teVerwijderenGebruiker);
                $stmt->execute();

                // Geef een succesbericht weer
                echo "Gebruiker '$teVerwijderenGebruiker' succesvol verwijderd!";
            } catch(PDOException $e) {
                echo "Fout bij het verwijderen van de gebruiker: " . $e->getMessage();
            }

            // Sluit de databaseverbinding
            $conn = null;
        }
        ?>
    </div>
</div>
</body>
</html>

