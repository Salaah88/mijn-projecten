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

// Haal alle records op uit de occasions-tabel
$sql = 'SELECT * FROM occasions';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$occasions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$occasions) {
    die('Geen records gevonden of er is een probleem met de query.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Page</title>
    <link rel="stylesheet" href="read.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="create.php">Create</a></li>
        <li><a href="update.php">Update</a></li>
        <li><a href="delete.php">Delete</a></li>
    </ul>
</nav>

<div class="content">
    <h1>Occasions Overzicht</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Merk</th>
            <th>Model</th>
            <th>Bouwjaar</th>
            <th>Prijs</th>
            <th>Kilometerstand</th>
            <th>Brandstof</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($occasions as $occasion): ?>
            <tr>
                <td><?php echo htmlspecialchars($occasion['id']); ?></td>
                <td><?php echo htmlspecialchars($occasion['Merk']); ?></td>
                <td><?php echo htmlspecialchars($occasion['Model']); ?></td>
                <td><?php echo htmlspecialchars($occasion['Bouwjaar']); ?></td>
                <td><?php echo htmlspecialchars($occasion['Prijs']); ?></td>
                <td><?php echo htmlspecialchars($occasion['Kilometerstand']); ?></td>
                <td><?php echo htmlspecialchars($occasion['Brandstof']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<footer>
    <p>&copy; 2024 Autodealer Crudwebsite.</p>
</footer>

</body>
</html>
