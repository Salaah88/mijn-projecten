<?php

// Controleer of het formulier via POST is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Maak een nieuw object van de klasse Sollicitatie met databasegegevens
    $sollicitatie = new Sollicitatie('localhost', 'hoekschlyceum', 'root', '');
    // Verwerk het formulier en de geüploade bestanden
    $sollicitatie->verwerkSollicitatie($_POST, $_FILES);
    // Redirect naar dezelfde pagina om dubbele inzending te voorkomen
    header("Location: solicitatie.php");
    exit();
}

// Klasse voor het verwerken van sollicitaties
class Sollicitatie
{
    private $pdo; // Variabele voor de databaseverbinding

    // Constructor om de databaseverbinding op te zetten via PDO
    public function __construct($host, $dbname, $username, $password)
    {
        try {
            // Maak de verbinding en stel foutafhandeling in
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            // Toon foutmelding als de verbinding mislukt
            die("Verbinding mislukt: " . $e->getMessage());
        }
    }

    // Methode om de sollicitatie te verwerken
    public function verwerkSollicitatie($postData, $fileData)
    {
        // Haal gegevens uit het formulier
        $voornaam = $postData['voornaam'];
        $achternaam = $postData['achternaam'];
        $geboortedatum = $postData['geboortedatum'];
        $adres = $postData['adres'];
        $woonplaats = $postData['woonplaats'];
        $postcode = $postData['postcode'];
        $telefoonnummer = $postData['telefoonnummer'];
        $email = $postData['email'];
        $vakgebied = $postData['vakgebied'];
        $motivatie = $postData['motivatie'];

        // Upload het cv-bestand
        $cv_naam = $this->uploadBestand($fileData);

        // Als upload mislukt, toon een foutmelding
        if (!$cv_naam) {
            die("Er is een probleem met het uploaden van je CV.");
        }

        // Voeg de gegevens toe aan de sollicitatie-tabel
        $this->voegSollicitatieToe($voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $cv_naam);

        // Voeg dezelfde gegevens ook toe aan de personeel-tabel
        $this->voegPersoneelToe($voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $cv_naam);

        return true;
    }

    // Methode voor het uploaden van het cv-bestand
    private function uploadBestand($fileData)
    {
        if (isset($fileData['cv']) && $fileData['cv']['error'] == 0) {
            // Genereer een unieke naam en stel het pad in
            $cv_naam = uniqid() . '_' . basename($fileData['cv']['name']);
            $cv_pad = 'uploads/' . $cv_naam;

            // Verplaats het bestand naar de uploads-map
            if (move_uploaded_file($fileData['cv']['tmp_name'], $cv_pad)) {
                return $cv_naam;
            }
        }
        return false; // Upload mislukt
    }

    // Voeg sollicitatiegegevens toe aan de database
    private function voegSollicitatieToe($voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $cv_naam)
    {
        $stmt = $this->pdo->prepare("INSERT INTO sollicitatie (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, telefoonnummer, email, vakgebied, motivatie, cv_naam) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $cv_naam]);
    }

    // Voeg sollicitant toe aan personeel-tabel
    private function voegPersoneelToe($voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $cv_naam)
    {
        $stmt_personeel = $this->pdo->prepare("INSERT INTO personeel (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, telefoonnummer, email, vakgebied, motivatie, sollicitatiedatum, originele_cv_naam) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_personeel->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, date('Y-m-d'), $cv_naam]);
    }
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sollicitatieformulier</title>
    <link rel="stylesheet" href="crud.css">
</head>
<body>

<!-- Navigatiebalk -->
<nav>
    <a href="hoekschhome.php">
        <div class="logo">
            <img src="https://hoekschlyceum-server.nl/skin/Image_0435F73B_2D0F_4BF4_4181_65F86A8DAC19_nl.png?v=1645107797961" alt="Hoeksch Lyceum Logo">
        </div>
    </a>
    <ul>
        <li><a href="inschrijven.php">Inschrijven</a></li>
        <li><a href="sollicitatie.php">Soliciteren</a></li>
        <li><a href="leerlingen.php">Leerlingenoverzicht</a></li>
        <li><a href="personeel.php">Personeelsoverzicht</a></li>
    </ul>
</nav>

<!-- Sollicitatieformulier -->
<div class="container mt-5">
    <h2>Solliciteer hier !</h2>
    <img src="solicitatie.jpg" alt="Inschrijven bij het hoekschlyceum" class="img-fluid mb-4">

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4"><input type="text" name="voornaam" class="form-control" placeholder="Voornaam" required></div>
            <div class="col-md-4"><input type="text" name="achternaam" class="form-control" placeholder="Achternaam" required></div>
            <div class="col-md-4"><input type="date" name="geboortedatum" class="form-control" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="adres" class="form-control" placeholder="Adres" required></div>
            <div class="col-md-4"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" required></div>
            <div class="col-md-4"><input type="text" name="postcode" class="form-control" placeholder="Postcode" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="telefoonnummer" class="form-control" placeholder="Telefoonnummer" required></div>
            <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="E-mail" required></div>
            <div class="col-md-4"><input type="text" name="vakgebied" class="form-control" placeholder="Vakgebied" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12"><textarea name="motivatie" class="form-control" placeholder="Motivatie" required></textarea></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12"><input type="file" name="cv" class="form-control" required></div>
        </div>

        <div class="form-buttons mt-3">
            <button type="submit" class="btn btn-success">Verzenden</button>
        </div>
    </form>
</div>
<!-- Voetnoot met copyright-informatie -->
<footer>
    <p1>&copy; 2025 Hoeksch Lyceum. Alle rechten voorbehouden.</p1>
</footer>

</body>
</html>
