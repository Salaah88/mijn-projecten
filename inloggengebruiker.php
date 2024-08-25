<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Verbinding met de database mislukt: " . $e->getMessage();
    }

    $gebruikersnaam = $_POST['gebruikersnaam'];
    $raw_wachtwoord = $_POST['wachtwoord'];

    // Wachtwoord zonder hashing opslaan in de database
    $wachtwoord = $raw_wachtwoord;

    $stmt = $conn->prepare("INSERT INTO inloggebruiker (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)");
    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
    $stmt->bindParam(':wachtwoord', $wachtwoord);

    $stmt->execute();

    // Stel de gebruiker in als ingelogd via een sessievariabele
    $_SESSION['ingelogd'] = true;

    header("Location: gebruiker.php"); // Doorsturen naar de gebruikerpagina
    exit();
}
?>

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
                    <li><a href="klachten.php">Klachten</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
        </nav>
    </head>
</head>
<body>
<div class="login-container">
    <h2>Inloggen</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- Formulierinvoervelden -->
        <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
        <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
        <button type="submit">Inloggen</button>
    </form>
</div>
</body>
</html>
