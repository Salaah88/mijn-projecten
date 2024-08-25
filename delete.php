<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Page</title>
    <link rel="stylesheet" href="delete.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="create.php">Create</a></li>
        <li><a href="read.php">Read</a></li>
        <li><a href="update.php">Update</a></li>
        <li><a href="delete.php">Delete</a></li>
    </ul>
</nav>

<div class="content">
    <h1>Delete Occasion</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
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

        $id = $_POST['id'];

        // Verwijder het record uit de database
        $sql = 'DELETE FROM occasions WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo '<p class="success">Record met ID ' . $id . ' succesvol verwijderd.</p>';
        } else {
            echo '<p class="error">Er is een fout opgetreden bij het verwijderen van het record.</p>';
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
        <label for="id">ID van het te verwijderen record:</label>
        <input type="text" id="id" name="id" required>

        <button type="submit">Verwijder</button>
    </form>
</div>
<footer>
    <p>&copy; 2024 Autodealer Crudwebsite.</p>
</footer>

</body>
</html>
