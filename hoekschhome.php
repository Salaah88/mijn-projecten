<?php
// Deze class (soort bouwplan) zorgt ervoor dat we makkelijk verbinding kunnen maken met de database.
class Database {
    // Hier wordt de databaseverbinding opgeslagen
    private PDO $pdo;

    // Dit is de "bouwer" van de class. Zodra je een nieuw Database-object maakt, wordt dit automatisch uitgevoerd.
    public function __construct(string $host, string $dbname, string $username, string $password) {
        try {
            // Hier wordt de daadwerkelijke verbinding gemaakt met de database
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Zorgt ervoor dat fouten netjes gemeld worden
            ]);
        } catch (PDOException $e) {
            // Als de verbinding mislukt, wordt dit bericht getoond
            die("Verbinding mislukt: " . $e->getMessage());
        }
    }

    // Deze functie geeft de databaseverbinding terug zodat we hem ergens anders kunnen gebruiken
    public function getPDO(): PDO {
        return $this->pdo;
    }
}

// Hier maken we de verbinding met de database 'hoekschlyceum' op de computer zelf (localhost)
$db = new Database('localhost', 'hoekschlyceum', 'root', '');
// We halen de actieve verbinding op zodat we hem kunnen gebruiken voor andere database-acties
$pdo = $db->getPDO();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoeksch Lyceum</title>
    <!-- Verwijzing naar het CSS-bestand dat zorgt voor de opmaak van de website -->
    <link rel="stylesheet" href="crud.css">
</head>
<body>

<!-- Navigatiebalk met het logo van de school en links naar andere pagina's -->
<nav>
    <div class="logo">
        <a href="hoekschhome.php">
            <img src="https://hoekschlyceum-server.nl/skin/Image_0435F73B_2D0F_4BF4_4181_65F86A8DAC19_nl.png?v=1645107797961" alt="Hoeksch Lyceum Logo">
        </a>
    </div>
    <ul>
        <li><a href="inschrijven.php">Inschrijven</a></li>
        <li><a href="solicitatie.php">Soliciteren</a></li>
        <li><a href="leerlingen.php">leerlingenoverzicht</a></li>
        <li><a href="personeel.php">Personeelsoverzicht</a></li>
    </ul>
</nav>

<!-- Groot welkomsblok met tekst, afbeelding en knoppen -->
<div class="hero-section text-center">
    <div class="container">
        <h1>Welkom bij Het Hoeksch Lyceum</h1>
        <h3>De beste school voor een gedegen opleiding in de regio. Wij bieden een breed scala aan vakken en activiteiten voor een complete leerervaring.</h3>
        <!-- Afbeelding van het schoolgebouw -->
        <img src="hoekschlyceum.png" alt="Hoeksch Lyceum gebouw" class="img-fluid mt-4" style="max-width: 80%; height: auto;">
        <!-- Knoppen om door te gaan naar inschrijven of solliciteren -->
        <div class="mt-4">
            <a href="inschrijven.php" class="btn btn-light btn-lg mt-3">Inschrijven als leerling</a>
            <a href="solicitatie.php" class="btn btn-warning btn-lg mt-3">Solliciteer hier</a>
        </div>
    </div>
</div>

<!-- Uitleg over de school -->
<div class="container text-center my-5">
    <h2>Over Hoeksch Lyceum</h2>
    <p>Het Hoeksch Lyceum is een gerenommeerde onderwijsinstelling die studenten voorbereidt op hun toekomst in een dynamische samenleving. Onze school biedt hoogwaardige opleidingen en biedt naast academische trainingen ook volop ruimte voor persoonlijke groei. Onze gedreven docenten helpen studenten hun volledige potentieel te ontdekken en te realiseren. </p>
    <p>Wij hebben een breed aanbod aan vakken, moderne faciliteiten, en een cultuur die gericht is op innovatie en samenwerking. Onze school staat bekend om haar focus op zowel theoretische kennis als praktische vaardigheden, zodat leerlingen goed voorbereid de arbeidsmarkt betreden.</p>
    <p>Kom langs en ontdek waarom het Hoeksch Lyceum de ideale plek is voor jouw opleiding!</p>
</div>

<!-- Blokken om snel naar informatie over leerlingen en docenten te gaan -->
<div class="container row justify-content-center my-5">
    <div class="col-md-3">
        <div class="feature-box">
            <h4>Leerlingen</h4>
            <p>Bekijk het overzicht van alle leerlingen bij ons op school en blijf op de hoogte van hun voortgang.</p>
            <a href="leerlingen.php" class="btn btn-light">Bekijk Leerlingen</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="feature-box">
            <h4>Docenten</h4>
            <p>Bekijk het overzicht van onze docenten, hun vakken en hoe ze onze leerlingen begeleiden in hun ontwikkeling.</p>
            <a href="personeel.php" class="btn btn-warning">Bekijk Docenten</a>
        </div>
    </div>
</div>

<!-- Voetnoot met copyright-informatie -->
<footer>
    <p1>&copy; 2025 Hoeksch Lyceum. Alle rechten voorbehouden.</p1>
</footer>
</body>
</html>
