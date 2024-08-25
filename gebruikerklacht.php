<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klachtenformulier</title>
    <link rel="stylesheet" href="gebruiker.css">
</head>
<body>

<div class="sidebar">
    <h2>Sidebar</h2>
    <ul class="nav-links">
        <li>
            <a href="gebruiker.php" class="active">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
</div>

<div class="content">
    <h1>Klachtenformulier</h1>

    <form action="gebruikerklacht.php" method="post" enctype="multipart/form-data">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="naam">Email:</label>
        <input type="text" id="Email" name="email" required><br><br>

        <label for="klacht">Klacht:</label><br>
        <textarea id="klacht" name="klacht" rows="4" cols="50" required></textarea><br><br>

        <label for="location">Locatie (GPS-coördinaten):</label>
        <input type="text" id="location" name="location" readonly><br><br>

        <label for="foto">Foto's (optioneel):</label>
        <input type="file" id="foto" name="foto[]" multiple accept="image/*"><br><br>

        <input type="submit" value="Verstuur klacht">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            navigator.geolocation.getCurrentPosition(showPosition, showError, { enableHighAccuracy: true });

            function showPosition(position) {
                document.getElementById('location').value = position.coords.latitude + ", " + position.coords.longitude;
            }

            function showError(error) {
                console.error(error.message);
            }
        });
    </script>

</div>

<style>
    /* Basisstijlen voor de pagina */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        display: flex;
    }

    .sidebar {
        background-color:darkslategray;
        color: white;
        width: 250px;
        height: 100vh; /* Neemt volledige hoogte van het scherm in */
        padding: 20px;
    }

    .content {
        flex: 1; /* Neemt resterende ruimte in beslag */
        padding: 20px;
    }
    .nav-links {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .nav-links li {
        padding: 10px 0;
    }

    .nav-links a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 8px 20px;
    }

    .nav-links a:hover {
        background-color: lightblue;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #1a1a1a;
    }
    #complaintForm {
        margin-bottom: 20px;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
        background-color: #fff;
    }

    #complaintForm label {
        display: block;
        margin-bottom: 10px;
        color: #333; /* Tekstkleur aanpassen voor labels */
    }

    #complaintForm input[type="text"],
    #complaintForm textarea {
        width: calc(100% - 22px); /* Aanpassing breedte voor inputvelden */
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 3px;
        border: 1px solid #ccc;
    }

    /* Voeg hier verdere stijlen toe voor het klachtenformulier en de rest van de inhoud */
</style>
</body>
</html>






<?php
class KlachtenFormulier {
    public $name;
    public $email;
    public $complaint;
    public $location;
    public $photos;

    public function __construct($name, $email, $complaint, $location, $photos) {
        $this->name = $name;
        $this->email = $email; // Dit moet worden aangepast om de waarde van $email toe te kennen aan $this->email
        $this->complaint = $complaint;
        $this->location = $location;
        $this->photos = $photos;
    }

    // ... (andere methoden)



    public function submitComplaint($conn)
    {
        // Opslaan van de klacht in een tekstbestand
        $data = "Naam: $this->name\n";
        $data = "Email: $this->email\n";
        $data .= "Klacht: $this->complaint\n";
        $data .= "Locatie: $this->location\n\n";

        $file = 'klachten.txt';
        file_put_contents($file, $data, FILE_APPEND);

        $sql = "INSERT INTO gebruikerklacht (naam, email, klacht, locatie) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $this->name, $this->email, $this->complaint, $this->location);
        $stmt->execute();
        $stmt->close();


        // Opslaan van geüploade foto's
        $targetDir = "uploads2";
        foreach ($this->photos['name'] as $key => $name) {
            $targetFile = $targetDir . basename($this->photos['name'][$key]);
            move_uploaded_file($this->photos['tmp_name'][$key], $targetFile);
            // Verdere verwerking met de geüploade foto's indien nodig
        }
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindingsfout: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['naam'];
    $email = $_POST['email'];
    $complaint = $_POST['klacht'];
    $location = $_POST['location'];
    $photos = $_FILES['foto'];

    $klacht = new KlachtenFormulier($name, $email, $complaint, $location, $photos);
    $klacht->submitComplaint($conn); // Geef $conn door als parameter
}

// ... (code om de klacht te verwerken en op te slaan in de database)



?>

