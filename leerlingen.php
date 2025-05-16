<?php

class Leerling
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Fout bij verbinden met database: " . $e->getMessage());
        }
    }

    // Toevoegen of bijwerken van een leerling
    public function voegLeerlingToeOfUpdate($postData)
    {
        $id = $postData['id'] ?? null;
        $voornaam = $postData['voornaam'];
        $achternaam = $postData['achternaam'];
        $geboortedatum = $postData['geboortedatum'];
        $adres = $postData['adres'];
        $woonplaats = $postData['woonplaats'];
        $postcode = $postData['postcode'];
        $email = $postData['email'];
        $telefoonnummer = $postData['telefoonnummer'];
        $niveau = $postData['niveau'];

        if ($id) {
            // Update bestaande leerling
            $stmt = $this->pdo->prepare("UPDATE leerlingen SET voornaam=?, achternaam=?, geboortedatum=?, adres=?, woonplaats=?, postcode=?, email=?, telefoonnummer=?, niveau=? WHERE id=?");
            $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $email, $telefoonnummer, $niveau, $id]);
            return "Leerling bijgewerkt!";
        } else {
            // Voeg nieuwe leerling toe
            $stmt = $this->pdo->prepare("INSERT INTO leerlingen (voornaam, achternaam, geboortedatum, adres, woonplaats, postcode, email, telefoonnummer, niveau) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$voornaam, $achternaam, $geboortedatum, $adres, $woonplaats, $postcode, $email, $telefoonnummer, $niveau]);
            return "Leerling toegevoegd!";
        }
    }

    // Verwijder een leerling
    public function verwijderLeerling($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM leerlingen WHERE id = ?");
        $stmt->execute([$id]);
        return "Leerling verwijderd!";
    }

    // Ophalen van een leerling voor bewerking
    public function getLeerling($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM leerlingen WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Zoeken naar leerlingen
    public function zoekLeerlingen($zoekterm)
    {
        $searchQuery = "%" . $zoekterm . "%";
        $stmt = $this->pdo->prepare("SELECT * FROM leerlingen WHERE voornaam LIKE ? OR achternaam LIKE ?");
        $stmt->execute([$searchQuery, $searchQuery]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Alle leerlingen ophalen
    public function getAlleLeerlingen()
    {
        $stmt = $this->pdo->query("SELECT * FROM leerlingen");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

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
        <li><a href="leerlingen.php">Leerlingenoverzicht</a></li>
        <li><a href="personeel.php">Personeelsoverzicht</a></li>
    </ul>
</nav>

<div class="container mt-5">
    <h2>Leerlingenbeheer</h2>
    <div class="search-container">
        <form method="GET" style="display: flex; justify-content: flex-end;">
            <input type="text" name="search" placeholder="Zoek op naam..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Zoeken</button>
        </form>
    </div>

    <img src="Hoeksch-Lyceum.jpg" alt="Solliciteren bij het Hoeksch Lyceum" class="img-fluid mb-4">

    <?php
    // Maak een instantie van de Leerling klasse
    $leerlingClass = new Leerling('localhost', 'hoekschlyceum', 'root', '');

    // Verwerken van het toevoegen of bijwerken van een leerling
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = $leerlingClass->voegLeerlingToeOfUpdate($_POST);
        echo "<script>alert('$message'); window.location.href='leerlingen.php';</script>";
    }

    // Verwerken van de verwijdering van een leerling
    if (isset($_GET['delete'])) {
        $message = $leerlingClass->verwijderLeerling($_GET['delete']);
        echo "<script>alert('$message'); window.location.href='leerlingen.php';</script>";
        exit;
    }

    // Ophalen van de leerling om te bewerken
    $editLeerling = null;
    if (isset($_GET['edit'])) {
        $editLeerling = $leerlingClass->getLeerling($_GET['edit']);
    }

    // Zoekfunctionaliteit
    $zoekterm = $_GET['search'] ?? '';
    if (!empty($zoekterm)) {
        $leerlingen = $leerlingClass->zoekLeerlingen($zoekterm);
    } else {
        $leerlingen = $leerlingClass->getAlleLeerlingen();
    }
    ?>

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
                <td><?= $leerling['inschrijfdatum']?></td>
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
<!-- Voetnoot met copyright-informatie -->
<footer>
    <p1>&copy; 2025 Hoeksch Lyceum. Alle rechten voorbehouden.</p1>
</footer>
</body>
</html>
