<?php
// Verbinding met de database
$dsn = 'mysql:host=localhost;dbname=autodealer';
$username = 'root'; // Vervang met jouw gebruikersnaam
$password = ''; // Vervang met jouw wachtwoord

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Databaseverbinding mislukt: ' . $e->getMessage());
}

// Controleer of het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $bouwjaar = $_POST['bouwjaar'];
    $prijs = $_POST['prijs'];
    $kilometerstand = $_POST['kilometerstand'];
    $brandstof = $_POST['brandstof'];

    // Voeg de nieuwe occasion toe aan de database
    $sql = 'INSERT INTO occasions (merk, model, bouwjaar, prijs, kilometerstand, brandstof) VALUES (:merk, :model, :bouwjaar, :prijs, :kilometerstand, :brandstof)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'merk' => $merk,
        'model' => $model,
        'bouwjaar' => $bouwjaar,
        'prijs' => $prijs,
        'kilometerstand' => $kilometerstand,
        'brandstof' => $brandstof
    ]);

    echo "Nieuwe occasion succesvol toegevoegd!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Page</title>
    <link rel="stylesheet" href="crud.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="read.php">Read</a></li>
        <li><a href="update.php">Update</a></li>
        <li><a href="delete.php">Delete</a></li>
    </ul>
</nav>

<div class="content">
    <h1>Create Page</h1>
    <form action="create.php" method="post">
        <label for="merk">Merk:</label><br>
        <input type="text" id="merk" name="merk" required><br>

        <label for="model">Model:</label><br>
        <input type="text" id="model" name="model" required><br>

        <label for="bouwjaar">Bouwjaar:</label><br>
        <input type="number" id="bouwjaar" name="bouwjaar" required><br>

        <label for="prijs">Prijs:</label><br>
        <input type="number" step="0.01" id="prijs" name="prijs" required><br>

        <label for="kilometerstand">Kilometerstand:</label><br>
        <input type="number" id="kilometerstand" name="kilometerstand" required><br>

        <label for="brandstof">Brandstof:</label><br>
        <input type="text" id="brandstof" name="brandstof" required><br><br>

        <input type="submit" value="Toevoegen">
    </form>
</div>
<footer>
    <p>&copy; 2024 Autodealer Crudwebsite.</p>
</footer>

</body>
</html>
