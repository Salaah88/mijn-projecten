<?php

class Database {   // Database Klasse
// Deze klasse zorgt voor de verbinding met de database, zodat we gegevens kunnen ophalen en opslaan.

    private PDO $pdo;

    // Constructor: maakt verbinding met de database.
    public function __construct($host, $dbname, $username, $password) {
        try {
            // Verbindt met de MySQL-database via PDO (PHP Data Objects).
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            // Als de verbinding niet lukt, wordt er een foutmelding weergegeven.
            die("Verbinding mislukt: " . $e->getMessage());
        }
    }

    // Geeft de verbinding met de database terug.
    public function getPDO(): PDO {
        return $this->pdo;
    }
}

// Personeel Manager Klasse
// Deze klasse is verantwoordelijk voor het beheren van personeelsgegevens in de database.
class PersoneelManager {
    private PDO $pdo;

    // Constructor: ontvangt de databaseverbinding als parameter.
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Verwijdert een personeelslid op basis van hun ID.
    public function deletePersoon($id) {
        $stmt = $this->pdo->prepare("DELETE FROM personeel WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Haalt de gegevens van een specifiek personeelslid op op basis van hun ID.
    public function getPersoon($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM personeel WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Voegt een nieuw personeelslid toe of werkt de gegevens van een bestaand personeelslid bij.
    public function savePersoon($data) {
        if (!empty($data['id'])) {
            // Als er een ID is, werken we de gegevens van een bestaand personeelslid bij.
            $stmt = $this->pdo->prepare("UPDATE personeel SET voornaam=?, achternaam=?, geboortedatum=?, adres=?, woonplaats=?, postcode=?, telefoonnummer=?, email=?, vakgebied=?, motivatie=? WHERE id=?");
            $stmt->execute([
                $data['voornaam'], $data['achternaam'], $data['geboortedatum'], $data['adres'],
                $data['woonplaats'], $data['postcode'], $data['telefoonnummer'], $data['email'],
                $data['vakgebied'], $data['motivatie'], $data['id']
            ]);
        } else {
            // Als er geen ID is, voegen we een nieuw personeelslid toe.
            $stmt = $this->pdo->prepare("INSERT INTO personeel (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, telefoonnummer, email, vakgebied, motivatie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['voornaam'], $data['achternaam'], $data['geboortedatum'], $data['adres'],
                $data['woonplaats'], $data['postcode'], $data['telefoonnummer'], $data['email'],
                $data['vakgebied'], $data['motivatie']
            ]);
        }
    }

    // Zoekt naar personeel op basis van een zoekterm (bijvoorbeeld naam).
    public function zoekPersoneel($zoekterm = '') {
        if (!empty($zoekterm)) {
            $search = '%' . $zoekterm . '%';
            $stmt = $this->pdo->prepare("SELECT * FROM personeel WHERE voornaam LIKE ? OR achternaam LIKE ?");
            $stmt->execute([$search, $search]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM personeel");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Initialisatie van de databaseverbinding
$db = new Database('localhost', 'hoekschlyceum', 'root', '');
$manager = new PersoneelManager($db->getPDO());

// Verkrijgen van zoekterm uit de URL
$personeel = null;
$zoekterm = $_GET['search'] ?? '';

// Verwijderen van een personeelslid
if (isset($_GET['delete'])) {
    $manager->deletePersoon($_GET['delete']);
    header("Location: personeel.php");
    exit;
}

// Bewerken van een personeelslid
if (isset($_GET['edit'])) {
    $personeel = $manager->getPersoon($_GET['edit']);
}

// Verwerken van POST (toevoegen of bijwerken van personeelslid)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manager->savePersoon($_POST);
    header("Location: personeel.php");
    exit;
}

// Ophalen van de lijst met alle personeelsleden op basis van de zoekterm
$personeelList = $manager->zoekPersoneel($zoekterm);
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
        <li><a href="leerlingen.php">Leerlingenoverzicht</a></li>
        <li><a href="personeel.php">Personeelsoverzicht</a></li>
    </ul>
</nav>

<div class="container mt-5">
    <h2>Personeelsbeheer</h2>

    <!-- Zoeken naar personeel -->
    <div class="search-container">
        <form method="GET" style="display: flex; justify-content: flex-end;">
            <input type="text" name="search" placeholder="Zoek op naam..." value="<?= htmlspecialchars($zoekterm) ?>">
            <button type="submit">Zoeken</button>
        </form>
    </div>

    <img src="Hoeksch-Lyceum.jpg" alt="Solliciteren bij het hoekschlyceum" class="img-fluid mb-4">

    <!-- Formulier voor toevoegen of bewerken van personeel -->
    <form method="post">
        <input type="hidden" name="id" value="<?= $personeel['id'] ?? '' ?>">

        <div class="row">
            <div class="col-md-4"><input type="text" name="voornaam" class="form-control" placeholder="Voornaam" value="<?= $personeel['voornaam'] ?? '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="achternaam" class="form-control" placeholder="Achternaam" value="<?= $personeel['achternaam'] ?? '' ?>" required></div>
            <div class="col-md-4"><input type="date" name="geboortedatum" class="form-control" value="<?= $personeel['geboortedatum'] ?? '' ?>" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="adres" class="form-control" placeholder="Adres" value="<?= $personeel['adres'] ?? '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="woonplaats" class="form-control" placeholder="Woonplaats" value="<?= $personeel['woonplaats'] ?? '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="postcode" class="form-control" placeholder="Postcode" value="<?= $personeel['postcode'] ?? '' ?>" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-4"><input type="text" name="telefoonnummer" class="form-control" placeholder="Telefoonnummer" value="<?= $personeel['telefoonnummer'] ?? '' ?>" required></div>
            <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="E-mail" value="<?= $personeel['email'] ?? '' ?>" required></div>
            <div class="col-md-4"><input type="text" name="vakgebied" class="form-control" placeholder="Vakgebied" value="<?= $personeel['vakgebied'] ?? '' ?>" required></div>
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
            <th>Datum solicitatie</th>
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
                <td><?= $persoon['datumsolicitatie']?></td>
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
<footer>
    <p1>&copy; 2025 Hoeksch Lyceum. Alle rechten voorbehouden.</p1>
</footer>
</body>
</html>
