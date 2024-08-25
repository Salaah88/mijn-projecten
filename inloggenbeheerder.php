<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="project10.css">
    <nav class="navbar">
        <div class="container">
            <div class="brand">
                <a href="project10.php"></a>
            </div>
            <a href="project10.php">
                <img src="website.png" alt="Gemeente Logo"  class="logo">
            </a>
            <ul class="nav-links">
                <li><a href="project10.php">Home</a></li>
                <li><a href="inloggengebruiker.php">Gast</a></li>
            </ul>
        </div>
    </nav>
</head>
<body>
<div class="login-container">
    <h2>Inloggen</h2>
    <form action="Beheerder.php"method="post">
        <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
        <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
        <button type="submit">Inloggen</button>
    </form>
</div>
</body>
</html>

<?php
// Hier dien je je databasegegevens in te voeren
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Maak een databaseverbinding met PDO
try {
    $conn = new PDO ("mysql:host=localhost;dbname=project", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Verbinding met de database mislukt: " . $e->getMessage();
}

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang gebruikersnaam en wachtwoord uit het formulier
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $raw_wachtwoord = $_POST['wachtwoord'];

    // Het wachtwoord hashen voordat het wordt opgeslagen in de database
    $hashed_wachtwoord = password_hash($raw_wachtwoord, PASSWORD_DEFAULT);

    // Bereid een SQL-query voor om gebruikersgegevens op te slaan
    $stmt = $conn->prepare("INSERT INTO inloggen (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)");
    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
    $stmt->bindParam(':wachtwoord', $hashed_wachtwoord);

    // Voer de SQL-query uit
    try {
        $stmt->execute();
        echo "Wachtwoord succesvol opgeslagen in de database";
    } catch(PDOException $e) {
        echo "Fout bij het opslaan van het wachtwoord: " . $e->getMessage();
    }
}
?>

