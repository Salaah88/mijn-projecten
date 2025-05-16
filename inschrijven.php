<?php
// Leerling-klasse voor het verwerken van formuliergegevens en databaseopslag
class Leerling {
    private array $data;

    // Constructor: ontvangt de gegevens van het formulier en slaat deze op.
    public function __construct(array $postData) {
        $this->data = $postData;
    }

    // Controleert of alle verplichte velden in het formulier zijn ingevuld.
    public function isGeldig(): bool {
        // Lijst van verplichte velden die gecontroleerd moeten worden
        $verplichteVelden = ['voornaam', 'achternaam', 'geboortedatum', 'adres', 'woonplaats', 'postcode', 'email', 'telefoonnummer', 'niveau'];

        // Controleert of elk verplicht veld is ingevuld
        foreach ($verplichteVelden as $veld) {
            if (empty($this->data[$veld])) {
                return false;  // Als een verplicht veld leeg is, is het formulier ongeldig
            }
        }
        return true;  // Als alle velden ingevuld zijn, is het formulier geldig
    }

    // Slaat de leerling op in de database
    public function opslaan(PDO $pdo): void {
        try {
            // Start een database transactie
            $pdo->beginTransaction();

            // Velden die we willen opslaan in de database
            $velden = ['voornaam', 'achternaam', 'geboortedatum', 'adres', 'woonplaats', 'postcode', 'email', 'telefoonnummer', 'niveau'];
            // Waarden uit het formulier die overeenkomen met de velden
            $waarden = array_map(fn($veld) => $this->data[$veld], $velden);

            // Invoegen van de leerling in de 'leerlingen' tabel
            $stmt = $pdo->prepare("INSERT INTO leerlingen (" . implode(", ", $velden) . ") VALUES (" . str_repeat("?, ", count($velden) - 1) . "?)");
            $stmt->execute($waarden);

            // Invoegen van de leerling in de 'inschrijvingen' tabel
            $stmt = $pdo->prepare("INSERT INTO inschrijvingen (" . implode(", ", $velden) . ") VALUES (" . str_repeat("?, ", count($velden) - 1) . "?)");
            $stmt->execute($waarden);

            // Commit de transactie om de wijzigingen door te voeren
            $pdo->commit();
        } catch (PDOException $e) {
            // Als er een fout optreedt, rollback de transactie
            $pdo->rollBack();
            throw new Exception("Fout bij opslaan: " . $e->getMessage());
        }
    }
}

// Databaseverbinding
$host = 'localhost';
$dbname = 'hoekschlyceum';
$username = 'root';
$password = '';

try {
    // Verbindt met de MySQL-database via PDO (PHP Data Objects)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Zet de foutmodus naar uitzonderingen voor betere foutmeldingen
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Als de verbinding niet lukt, wordt de fout weergegeven
    die("Fout bij verbinden met database: " . $e->getMessage());
}

// Formulierverwerking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Maak een nieuw Leerling object van de POST-gegevens
    $leerling = new Leerling($_POST);

    // Als het formulier niet geldig is (bijvoorbeeld ontbrekende velden), toon een foutmelding
    if (!$leerling->isGeldig()) {
        echo "<script>alert('Vul alstublieft alle velden in!'); window.location.href='inschrijven.php';</script>";
        exit;
    }

    // Probeer de leerling op te slaan in de database
    try {
        $leerling->opslaan($pdo);
        // Als het opslaan succesvol is, toon een succesmelding
        echo "<script>alert('Leerling succesvol ingeschreven!'); window.location.href='inschrijven.php';</script>";
        exit;
    } catch (Exception $e) {
        // Als er een fout optreedt bij het opslaan, toon een foutmelding
        die("Fout: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inschrijven Leerling</title>
    <link rel="stylesheet" href="crud.css">
</head>
<body>
<nav>
    <a href="hoekschhome.php">
        <div class="logo">
            <img src="https://hoekschlyceum-server.nl/skin/Image_0435F73B_2D0F_4BF4_4181_65F86A8DAC19_nl.png?v=1645107797961" alt="Hoeksch Lyceum Logo">
        </div>
    </a>
    <ul>
        <li><a href="inschrijven.php">Inschrijven</a></li>
        <li><a href="solicitatie.php">Soliciteren</a></li>
        <li><a href="leerlingen.php">Leerlingenoverzicht</a></li>
        <li><a href="personeel.php">Personeelsoverzicht</a></li>
    </ul>
</nav>

<!-- Formulier voor inschrijven van een leerling -->
<form method="POST" enctype="multipart/form-data">
    <h3>Schrijf je kind hier in</h3>
    <img src="lyceum.jpg" alt="Inschrijven bij het hoekschlyceum" class="img-fluid mb-4" id="shift-left-transform">

    <!-- Velden voor naam, geboortedatum en contactgegevens -->
    <div class="col-md-4"><input type="text" name="voornaam" class="form-control" placeholder="Voornaam" required></div>
    <div class="col-md-4"><input type="text" name="achternaam" class="form-control" placeholder="Achternaam" required></div>
    <div class="col-md-4"><input type="date" name="geboortedatum" class="form-control" required></div>

    <!-- Velden voor adres en locatiegegevens -->
    <div class="row mt-2">
        <div class="col-md-4"><input type="text" name="adres" class="form-control" placeholder="Adres" required></div>
        <div class="col-md-4"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" required></div>
        <div class="col-md-4"><input type="text" name="postcode" class="form-control" placeholder="Postcode" required></div>
    </div>

    <!-- Velden voor telefoonnummer, e-mail en niveau -->
    <div class="row mt-2">
        <div class="col-md-4"><input type="text" name="telefoonnummer" class="form-control" placeholder="Telefoonnummer" required></div>
        <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="E-mail" required></div>
        <div class="col-md-4"><input type="text" name="niveau" class="form-control" placeholder="Niveau" required></div>
    </div>

    <!-- Submit knop om het formulier in te dienen -->
    <div class="form-buttons mt-3">
        <button type="submit" class="btn btn-success">Inschrijven</button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Voetnoot met copyright-informatie -->
<footer>
    <p1>&copy; 2025 Hoeksch Lyceum. Alle rechten voorbehouden.</p1>
</footer>
</body>
</html>
