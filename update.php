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

// Haal een bestaand record op
$sql = 'SELECT * FROM occasions LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$occasion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$occasion) {
    die('Geen records gevonden.');
}

// Werk de gegevens bij
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $merk = $_POST['merk'] ?? '';
    $model = $_POST['model'] ?? '';
    $bouwjaar = $_POST['bouwjaar'] ?? '';
    $prijs = $_POST['prijs'] ?? '';
    $kilometerstand = $_POST['kilometerstand'] ?? '';
    $brandstof = $_POST['brandstof'] ?? '';
    $id = $occasion['id'];

    $sql = 'UPDATE occasions SET merk = :merk, model = :model, bouwjaar = :bouwjaar, prijs = :prijs, kilometerstand = :kilometerstand, brandstof = :brandstof WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':merk', $merk);
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':bouwjaar', $bouwjaar);
    $stmt->bindParam(':prijs', $prijs);
    $stmt->bindParam(':kilometerstand', $kilometerstand);
    $stmt->bindParam(':brandstof', $brandstof);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo 'Record succesvol bijgewerkt.';
    } else {
        echo 'Er is een fout opgetreden bij het bijwerken van het record.';
    }

    // Haal de bijgewerkte gegevens opnieuw op
    $sql = 'SELECT * FROM occasions WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $occasion = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page</title>
    <link rel="stylesheet" href="update.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="create.php">Create</a></li>
        <li><a href="read.php">Read</a></li>
        <li><a href="delete.php">Delete</a></li>
    </ul>
</nav>

<div class="content">
    <h1>Update Occasion</h1>
    <form action="update.php" method="POST">
        <label for="merk">Merk:</label>
        <input type="text" id="merk" name="merk" value="<?php echo htmlspecialchars($occasion['merk'] ?? ''); ?>" required>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($occasion['model'] ?? ''); ?>" required>

        <label for="bouwjaar">Bouwjaar:</label>
        <input type="number" id="bouwjaar" name="bouwjaar" value="<?php echo htmlspecialchars($occasion['bouwjaar'] ?? ''); ?>" required>

        <label for="prijs">Prijs:</label>
        <input type="number" id="prijs" name="prijs" value="<?php echo htmlspecialchars($occasion['prijs'] ?? ''); ?>" step="0.01" required>

        <label for="kilometerstand">Kilometerstand:</label>
        <input type="number" id="kilometerstand" name="kilometerstand" value="<?php echo htmlspecialchars($occasion['kilometerstand'] ?? ''); ?>" step="0.01" required>

        <label for="brandstof">Brandstof:</label>
        <input type="text" id="brandstof" name="brandstof" value="<?php echo htmlspecialchars($occasion['brandstof'] ?? ''); ?>" required>

        <button type="submit">Update</button>
    </form>
</div>
<footer>
    <p>&copy; 2024 Autodealer Crudwebsite.</p>
</footer>

</body>
</html>
