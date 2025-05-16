INSCHRIJVEN Pagina

<?php
// Databaseverbinding
$host = 'localhost';
$dbname = 'hoekschlyceum';
$username = 'root';
$password = '';

try {
    // Zorg ervoor dat de verbinding met de database wordt gemaakt
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

// Verwerken van het inschrijfformulier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Controleer of alle velden ingevuld zijn
    if (empty($_POST['voornaam']) || empty($_POST['achternaam']) || empty($_POST['geboortedatum']) || empty($_POST['adres']) || empty($_POST['woonplaats']) || empty($_POST['postcode']) || empty($_POST['email']) || empty($_POST['telefoonnummer']) || empty($_POST['niveau'])) {
        echo "<script>alert('Vul alstublieft alle velden in!'); window.location.href='inschrijven.php';</script>";
        exit; // Stop de uitvoering van de code als niet alle velden ingevuld zijn
    }

    // Verkrijg de formuliergegevens
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $geboortedatum = $_POST['geboortedatum'];
    $adres = $_POST['adres'];
    $woonplaats = $_POST['woonplaats'];
    $postcode = $_POST['postcode'];
    $email = $_POST['email'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $niveau = $_POST['niveau'];

    try {
        // Start een transactie voor beide tabellen
        $pdo->beginTransaction();

        // Toevoegen aan de 'leerlingen' tabel
        $stmt = $pdo->prepare("INSERT INTO leerlingen (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, email, telefoonnummer, niveau) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $email, $telefoonnummer, $niveau]);

        // Toevoegen aan de 'inschrijvingen' tabel
        $stmt = $pdo->prepare("INSERT INTO inschrijvingen (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, email, telefoonnummer, niveau) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $email, $telefoonnummer, $niveau]);

        $pdo->commit();

        // Succesbericht via PHP
        echo "<script>alert('Leerling succesvol ingeschreven!'); window.location.href='inschrijven.php';</script>";
        exit; // Stop de uitvoering van de script na het succesbericht

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Er is een fout opgetreden bij de inschrijving: " . $e->getMessage());
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
        <li><a href="leerlingen.php">Bekijk Leerlingen</a></li>
        <li><a href="personeel.php">Bekijk Personeel</a></li>
    </ul>
</nav>

<form method="POST" enctype="multipart/form-data">
    <h3>Schrijf je kind hier in</h3>
    <img src="lyceum.jpg" alt="Inschrijven bij het hoekschlyceum" class="img-fluid mb-4" id="shift-left-transform">

    <div class="col-md-4"><input type="text" name="voornaam" class="form-control" placeholder="Voornaam" required></div>
    <div class="col-md-4"><input type="text" name="achternaam" class="form-control" placeholder="Achternaam" required></div>
    <div class="col-md-4"><input type="date" name="geboortedatum" class="form-control" required></div>

    <div class="row mt-2">
        <div class="col-md-4"><input type="text" name="adres" class="form-control" placeholder="Adres" required></div>
        <div class="col-md-4"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" required></div>
        <div class="col-md-4"><input type="text" name="postcode" class="form-control" placeholder="Postcode" required></div>
    </div>

    <div class="row mt-2">
        <div class="col-md-4"><input type="text" name="telefoonnummer" class="form-control" placeholder="Telefoonnummer" required></div>
        <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="E-mail" required></div>
        <div class="col-md-4"><input type="text" name="niveau" class="form-control" placeholder="Niveau" required></div>
    </div>

    <div class="form-buttons mt-3">
        <button type="submit" class="btn btn-success">Inschrijven</button>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




HOME PAGINA

<?php
// config.php - Databaseverbinding
$host = 'localhost';
$dbname = 'hoekschlyceum';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoeksch Lyceum</title>
    <link rel="stylesheet" href="crud.css">
</head>
<body>

<!-- Navigatiebalk met logo -->
<nav>
    <div class="logo">
        <img src="https://hoekschlyceum-server.nl/skin/Image_0435F73B_2D0F_4BF4_4181_65F86A8DAC19_nl.png?v=1645107797961" href="hoekschhome.php" alt="Hoeksch Lyceum Logo">
    </div>
    <ul>
        <li><a href="inschrijven.php">Inschrijven</a></li>
        <li><a href="solicitatie.php">Soliciteren</a></li>
        <li><a href="leerlingen.php">Bekijk Leerlingen</a></li>
        <li><a href="personeel.php">Bekijk Personeel</a></li>
    </ul>
</nav>

<!-- Hero sectie met welkomsttekst en afbeelding -->
<div class="hero-section text-center">
    <div class="container">
        <h1>Welkom bij Het Hoeksch Lyceum</h1>
        <h3>De beste school voor een gedegen opleiding in de regio. Wij bieden een breed scala aan vakken en activiteiten voor een complete leerervaring.</h3>
        <img src="hoekschlyceum.png" alt="Hoeksch Lyceum gebouw" class="img-fluid mt-4" style="max-width: 80%; height: auto;">
        <div class="mt-4">
            <a href="inschrijven.php" class="btn btn-light btn-lg mt-3">Inschrijven als leerling</a>
            <a href="solicitatie.php" class="btn btn-warning btn-lg mt-3">Solliciteer hier</a>
        </div>
    </div>
</div>

<!-- Over de school sectie -->
<div class="container text-center my-5">
    <h2>Over Hoeksch Lyceum</h2>
    <p>Het Hoeksch Lyceum is een gerenommeerde onderwijsinstelling die studenten voorbereidt op hun toekomst in een dynamische samenleving. Onze school biedt hoogwaardige opleidingen en biedt naast academische trainingen ook volop ruimte voor persoonlijke groei. Onze gedreven docenten helpen studenten hun volledige potentieel te ontdekken en te realiseren. </p>
    <p>Wij hebben een breed aanbod aan vakken, moderne faciliteiten, en een cultuur die gericht is op innovatie en samenwerking. Onze school staat bekend om haar focus op zowel theoretische kennis als praktische vaardigheden, zodat leerlingen goed voorbereid de arbeidsmarkt betreden.</p>
    <p>Kom langs en ontdek waarom het Hoeksch Lyceum de ideale plek is voor jouw opleiding!</p>
</div>

<!-- Feature sectie met de links naar pagina's -->
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

<!-- Footer -->
<footer>
    <p1>&copy; 2025 Hoeksch Lyceum. Alle rechten voorbehouden.</p1>
</footer>
</body>
</html>



PERSONEEL PAGINA

<?php
// Databaseverbinding
$host = 'localhost';
$dbname = 'hoekschlyceum';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

// Verwijderen van een medewerker
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM personeel WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: personeel.php");
}

// Ophalen van gegevens voor bewerken
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM personeel WHERE id = ?");
    $stmt->execute([$id]);
    $personeel = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Toevoegen of bijwerken van personeel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $geboortedatum = $_POST['geboortedatum'];
    $adres = $_POST['adres'];
    $woonplaats = $_POST['woonplaats'];
    $postcode = $_POST['postcode'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $email = $_POST['email'];
    $vakgebied = $_POST['vakgebied'];
    $motivatie = $_POST['motivatie'];

    if ($id) {
        // Update query
        $stmt = $pdo->prepare("UPDATE personeel SET voornaam=?, achternaam=?, geboortedatum=?, adres=?, woonplaats=?, postcode=?, telefoonnummer=?, email=?, vakgebied=?, motivatie=? WHERE id=?");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $id]);
    } else {
        // Insert query
        $stmt = $pdo->prepare("INSERT INTO personeel (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, telefoonnummer, email, vakgebied, motivatie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie]);
    }

    header("Location: personeel.php");
}

// Ophalen van alle personeelsleden
$stmt = $pdo->query("SELECT * FROM personeel");
$personeelList = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Zoekfunctionaliteit
$zoekterm = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($zoekterm)) {
    $searchQuery = "%" . $zoekterm . "%";
    $stmt = $pdo->prepare("SELECT * FROM personeel WHERE voornaam LIKE ? OR achternaam LIKE ?");
    $stmt->execute([$searchQuery, $searchQuery]);
} else {
    $stmt = $pdo->query("SELECT * FROM personeel");
}

$personeelList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personeelsbeheer</title>
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
        <li><a href="leerlingen.php">Bekijk Leerlingen</a></li>
        <li><a href="personeel.php">Bekijk Personeel</a></li>
    </ul>
</nav>

<div class="container mt-5">
    <h2>Personeelsbeheer</h2>

    <div class="search-container">
        <form method="GET" style="display: flex; justify-content: flex-end;">
            <input type="text" name="search" placeholder="Zoek op naam..." value="<?= htmlspecialchars($zoekterm) ?>">
            <button type="submit">Zoeken</button>
        </form>
    </div>

    <img src="Hoeksch-Lyceum.jpg" alt="Solliciteren bij het hoekschlyceum" class="img-fluid mb-4">

    <!-- Formulier voor toevoegen of bewerken -->
    <form method="post">
        <input type="hidden" name="id" value="<?= isset($personeel) ? $personeel['id'] : '' ?>">

        <div class="row">
            <div class="col-md-4"><input type="text" name="voornaam" class="form-control" placeholder="Voornaam" value="<?= isset($personeel) ? $personeel['voornaam'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="achternaam" class="form-control" placeholder="Achternaam" value="<?= isset($personeel) ? $personeel['achternaam'] : '' ?>" required></div>
            <div class="col-md-4"><input type="date" name="geboortedatum" class="form-control" value="<?= isset($personeel) ? $personeel['geboortedatum'] : '' ?>" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="adres" class="form-control" placeholder="Adres" value="<?= isset($personeel) ? $personeel['adres'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" value="<?= isset($personeel) ? $personeel['woonplaats'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="postcode" class="form-control" placeholder="Postcode" value="<?= isset($personeel) ? $personeel['postcode'] : '' ?>" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="telefoonnummer" class="form-control" placeholder="Telefoonnummer" value="<?= isset($personeel) ? $personeel['telefoonnummer'] : '' ?>" required></div>
            <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="E-mail" value="<?= isset($personeel) ? $personeel['email'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="vakgebied" class="form-control" placeholder="Vakgebied" value="<?= isset($personeel) ? $personeel['vakgebied'] : '' ?>" required></div>
        </div>


        <div class="form-buttons">
            <button type="submit" class="btn btn-success"><?= isset($personeel) ? 'Bijwerken' : 'Toevoegen' ?></button>
            <a href="personeel.php" class="btn btn-secondary">Annuleren</a>
        </div>
    </form>

    <h3 class="mt-5">Overzicht personeel</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Achternaam</th>
            <th>Geboortedatum</th>
            <th>Adres</th>
            <th>Woonplaats</th>
            <th>Postcode</th>
            <th>Telefoonnummer</th>
            <th>Email</th>
            <th>Vakgebied</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($personeelList as $persoon): ?>
            <tr>
                <td><?= $persoon['id'] ?></td>
                <td><?= $persoon['voornaam'] ?></td>
                <td><?= $persoon['achternaam'] ?></td>
                <td><?= $persoon['geboortedatum'] ?></td>
                <td><?= $persoon['adres'] ?></td>
                <td><?= $persoon['woonplaats'] ?></td>
                <td><?= $persoon['postcode'] ?></td>
                <td><?= $persoon['telefoonnummer'] ?></td>
                <td><?= $persoon['email'] ?></td>
                <td><?= $persoon['vakgebied'] ?></td>
                <td>
                    <div class="table-actions">
                        <a href="personeel.php?edit=<?= $persoon['id'] ?>" class="btn btn-warning btn-sm">Bewerken</a>
                        <a href="personeel.php?delete=<?= $persoon['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?')">Verwijderen</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>


SOLICITATIE PAGINA

<?php
// Databaseverbinding
$host = 'localhost';
$dbname = 'hoekschlyceum';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

// Verwerken van de sollicitatie
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formuliergegevens ophalen
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $geboortedatum = $_POST['geboortedatum'];
    $adres = $_POST['adres'];
    $woonplaats = $_POST['woonplaats'];
    $postcode = $_POST['postcode'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $email = $_POST['email'];
    $vakgebied = $_POST['vakgebied'];
    $motivatie = $_POST['motivatie'];

    // Bestandsupload voor het cv
    $cv_naam = '';
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $cv_naam = basename($_FILES['cv']['name']);
        $cv_pad = 'uploads/' . $cv_naam;

        // Verplaats het bestand naar de uploads map
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $cv_pad)) {
            // Het bestand is succesvol geüpload, doorgaan met de query
        } else {
            die("Er is een probleem met het uploaden van je CV.");
        }
    }

    // Query voor het toevoegen van gegevens aan de sollicitatie tabel
    $stmt = $pdo->prepare("INSERT INTO sollicitatie (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, telefoonnummer, email, vakgebied, motivatie, cv_naam) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Voer de sollicitatie query uit
    $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, $cv_naam]);

    // Query voor het toevoegen van gegevens aan de personeel tabel
    $stmt_personeel = $pdo->prepare("INSERT INTO personeel (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, telefoonnummer, email, vakgebied, motivatie, sollicitatiedatum, originele_cv_naam) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Voer de personeel query uit
    $stmt_personeel->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $telefoonnummer, $email, $vakgebied, $motivatie, date('Y-m-d'), $cv_naam]);

    // Redirect naar de sollicitatiespagina na succes
    header("Location: solicitatie.php");
    exit();
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

<nav>
    <a href="hoekschhome.php">
        <div class="logo">
            <img src="https://hoekschlyceum-server.nl/skin/Image_0435F73B_2D0F_4BF4_4181_65F86A8DAC19_nl.png?v=1645107797961" alt="Hoeksch Lyceum Logo">
        </div>
    </a>
    <ul>
        <li><a href="inschrijven.php">Inschrijven</a></li>
        <li><a href="sollicitatie.php">Soliciteren</a></li>
        <li><a href="leerlingen.php">Bekijk Leerlingen</a></li>
        <li><a href="personeel.php">Bekijk Personeel</a></li>
    </ul>
</nav>

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

</body>
</html>



LEERLINGEN PAGINA

<?php
$host = 'localhost';
$dbname = 'hoekschlyceum';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

// Verwerken van het toevoegen of bijwerken van een leerling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $voornaam = $_POST['voornaam'] ?? '';
    $achternaam = $_POST['achternaam'] ?? '';
    $geboortedatum = $_POST['geboortedatum'] ?? '';
    $adres = $_POST['adres'] ?? '';
    $woonplaats = $_POST['woonplaats'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefoonnummer = $_POST['telefoonnummer'] ?? '';
    $niveau = $_POST['niveau'] ?? '';

    if ($id) {
        // Update bestaande leerling
        $stmt = $pdo->prepare("UPDATE leerlingen SET voornaam=?, achternaam=?, geboortedatum=?, adres=?, woonplaats=?, postcode=?, email=?, telefoonnummer=?, niveau=? WHERE id=?");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $email, $telefoonnummer, $niveau, $id]);
        echo "<script>alert('Leerling bijgewerkt!'); window.location.href='leerlingen.php';</script>";
    } else {
        // Voeg nieuwe leerling toe
        $stmt = $pdo->prepare("INSERT INTO leerlingen (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, email, telefoonnummer, niveau) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $email, $telefoonnummer, $niveau]);
        echo "<script>alert('Leerling toegevoegd!'); window.location.href='leerlingen.php';</script>";
    }
}

// Verwerken van de verwijdering van een leerling
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM leerlingen WHERE id = ?");
    $stmt->execute([$id]);
    echo "<script>alert('Leerling verwijderd!'); window.location.href='leerlingen.php';</script>";
    exit;
}

// Ophalen van de leerling om te bewerken
$editLeerling = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM leerlingen WHERE id = ?");
    $stmt->execute([$id]);
    $editLeerling = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Zoekfunctionaliteit
$zoekterm = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($zoekterm)) {
    $searchQuery = "%" . $zoekterm . "%";
    $stmt = $pdo->prepare("SELECT * FROM leerlingen WHERE voornaam LIKE ? OR achternaam LIKE ?");
    $stmt->execute([$searchQuery, $searchQuery]);
} else {
    $stmt = $pdo->query("SELECT * FROM leerlingen");
}

$leerlingen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leerlingen Overzicht</title>
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
        <li><a href="leerlingen.php">Bekijk Leerlingen</a></li>
        <li><a href="personeel.php">Bekijk Personeel</a></li>
    </ul>
</nav>

<div class="container mt-5">
    <h2>Leerlingenbeheer</h2>
    <div class="search-container">
        <form method="GET" style="display: flex; justify-content: flex-end;">
            <input type="text" name="search" placeholder="Zoek op naam..." value="<?= htmlspecialchars($zoekterm) ?>">
            <button type="submit">Zoeken</button>
        </form>
    </div>

    <img src="Hoeksch-Lyceum.jpg" alt="Solliciteren bij het Hoeksch Lyceum" class="img-fluid mb-4">

    <!-- Zoekformulier -->
    <form method="post">
        <input type="hidden" name="id" value="<?= isset($editLeerling) ? $editLeerling['id'] : '' ?>">

        <!-- Eerste rij: Voornaam, Achternaam, Geboortedatum -->
        <div class="row">
            <div class="col-md-4"><input type="text" name="voornaam" class="form-control" placeholder="Voornaam" value="<?= isset($editLeerling) ? $editLeerling['voornaam'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="achternaam" class="form-control" placeholder="Achternaam" value="<?= isset($editLeerling) ? $editLeerling['achternaam'] : '' ?>" required></div>
            <div class="col-md-4"><input type="date" name="geboortedatum" class="form-control" value="<?= isset($editLeerling) ? $editLeerling['geboortedatum'] : '' ?>" required></div>
        </div>

        <!-- Tweede rij: Adres, Woonplaats, Postcode -->
        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="adres" class="form-control" placeholder="Adres" value="<?= isset($editLeerling) ? $editLeerling['adres'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" value="<?= isset($editLeerling) ? $editLeerling['woonplaats'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="postcode" class="form-control" placeholder="Postcode" value="<?= isset($editLeerling) ? $editLeerling['postcode'] : '' ?>" required></div>
        </div>

        <!-- Derde rij: Telefoonnummer, E-mail, Niveau -->
        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="telefoonnummer" class="form-control" placeholder="Telefoonnummer" value="<?= isset($editLeerling) ? $editLeerling['telefoonnummer'] : '' ?>" required></div>
            <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="E-mail" value="<?= isset($editLeerling) ? $editLeerling['email'] : '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="niveau" class="form-control" placeholder="Niveau" value="<?= isset($editLeerling) ? $editLeerling['niveau'] : '' ?>" required></div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn btn-success"><?= isset($editLeerling) ? 'Bijwerken' : 'Toevoegen' ?></button>
            <a href="leerlingen.php" class="btn btn-secondary">Annuleren</a>
        </div>

    </form>

    <h3 class="mt-4">Alle Leerlingen</h3>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Voornaam</th>
            <th>Achternaam</th>
            <th>Geboortedatum</th>
            <th>Adres</th>
            <th>Woonplaats</th>
            <th>Postcode</th>
            <th>Email</th>
            <th>Telefoonnummer</th>
            <th>Niveau</th>
            <th>Inschrijfdatum</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($leerlingen as $leerling) : ?>
            <tr>
                <td><?= $leerling['id'] ?></td>
                <td><?= $leerling['voornaam'] ?></td>
                <td><?= $leerling['achternaam'] ?></td>
                <td><?= $leerling['geboortedatum'] ?></td>
                <td><?= $leerling['adres'] ?></td>
                <td><?= $leerling['woonplaats'] ?></td>
                <td><?= $leerling['postcode'] ?></td>
                <td><?= $leerling['email'] ?></td>
                <td><?= $leerling['telefoonnummer'] ?></td>
                <td><?= $leerling['niveau'] ?></td>
                <td>
                    <div class="table-actions">
                        <a href="leerlingen.php?edit=<?= $leerling['id'] ?>" class="btn btn-warning btn-sm">Bewerken</a>
                        <a href="leerlingen.php?delete=<?= $leerling['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je deze leerling wilt verwijderen?')">Verwijderen</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($leerlingen)) : ?>
        <p>Geen leerlingen gevonden.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




