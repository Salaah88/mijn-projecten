<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klacht indienen</title>
    <link rel="stylesheet" href="klachten.css">
    <style>

        body{
            font-family: "Arial ", sans-serif;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-image: url('Nederland.png');
            background-size: 500px; /* Pas dit aan op basis van je behoeften */
            background-position: bottom; /* Pas dit aan om de positie van de achtergrondafbeelding aan te passen */
            background-repeat: no-repeat;

        }
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .brand {
            font-size: 24px;
            margin-right: 20px;
        }
        .logo {
            width: 120px; /* Aanpassen naar de gewenste breedte */
            height: auto;
            margin-right:20px;
            margin-left: 20px;
            display:block;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .nav-links li {
            margin-right: 20px;
        }
        .nav-links a {
            color: #fff;
            text-decoration: none;
        }
        h1, p {
            margin-bottom: 20px;
            color: #1a1a1a;
        }
    </style>
</head>
<body>
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
            <li class="dropdown">
                <a href="#" class="dropbtn">Account</a>
                <div class="dropdown-content">
                    <a href="inloggengebruiker.php">Gast</a>
                    <a href="inloggenbeheerder.php">Beheerder</a>
                </div>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>
<body>
<h2>Klachten Indienen</h2>
<form action="klachten.php" method="post" enctype="multipart/form-data">
    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="complaint">Klacht:</label>
    <textarea id="complaint" name="complaint" required></textarea><br><br>

    <label for="location">Locatie (GPS-coördinaten):</label>
    <input type="text" id="location" name="location" readonly><br><br>

    <label for="photo">Foto's:</label>
    <input type="file" id="photo" name="photo[]" multiple accept="image/*"><br><br>

    <input type="submit" value="Klacht Indienen">
</form>

<script>
    // JavaScript code om de GPS-coördinaten op te halen (vereist toestemming)
    // Dit kan gebruikmaken van de Geolocation API van de browser.
    // Voorbeeld:
    navigator.geolocation.getCurrentPosition(showPosition);

    function showPosition(position) {
        document.getElementById('location').value = position.coords.latitude + ", " + position.coords.longitude;
    }
</script>
</body>
</html>
<?php
class KlachtenFormulier
{
    public $name;
    public $email;
    public $complaint;
    public $location;
    public $photos;

    public function __construct($name, $email, $complaint, $location, $photos)
    {
        $this->name = $name;
        $this->email = $email;
        $this->complaint = $complaint;
        $this->location = $location;
        $this->photos = $photos;
    }

    public function submitComplaint($conn)
    {
// Opslaan in een tekstbestand
        $data = "Naam: $this->name\n";
        $data .= "E-mail: $this->email\n";
        $data .= "Klacht: $this->complaint\n";
        $data .= "Locatie: $this->location\n\n";

        $file = 'klachten.txt';
        file_put_contents($file, $data, FILE_APPEND);

// Opslaan in de database
        $sql = "INSERT INTO klachten (naam, email, klacht, locatie) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $this->name, $this->email, $this->complaint, $this->location);
        $stmt->execute();
        $stmt->close();

// Opslaan van geüploade foto's
        $targetDir = "uploads/";
        foreach ($this->photos['name'] as $key => $name) {
            $targetFile = $targetDir . basename($this->photos['name'][$key]);
            move_uploaded_file($this->photos['tmp_name'][$key], $targetFile);
// Verdere verwerking met de geüploade foto's indien nodig
        }

        echo "Klacht succesvol ingediend!";
    }
}
// Databaseverbinding maken
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindingsfout: " . $conn->connect_error);
}

// Verwerken van het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $complaint = $_POST['complaint'];
    $location = $_POST['location'];
    $photos = $_FILES['photo'];

    $klacht = new KlachtenFormulier($name, $email, $complaint, $location, $photos);
    $klacht->submitComplaint($conn); // Geef $conn door als parameter
}

// ... (huidige code voor het maken van de databaseverbinding blijft hetzelfde)



?>

