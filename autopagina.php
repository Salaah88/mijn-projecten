<?php
// config.php

$host = 'localhost';
$db = 'automvc';
$user = 'root';
$pass = '';

// Create connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    echo "Connected successfully";
}
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'controllers/AutoController.php';

try {
    $controller = new AutoController($mysqli);

    $action = isset($_GET['action']) ? $_GET['action'] : 'index';
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    switch ($action) {
        case 'show':
            if ($id) {
                $controller->show($id);
            } else {
                echo "ID is vereist om auto informatie te tonen.";
            }
            break;
        case 'index':
        default:
            $controller->index();
            break;
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<?php
// controllers/AutoController.php

require_once 'models/Auto.php';

class AutoController {
    private $autoModel;

    public function __construct($db) {
        $this->autoModel = new Auto($db);
    }

    public function show($id) {
        try {
            $auto = $this->autoModel->getAutoById($id);
            if ($auto) {
                include 'views/autoView.php';
            } else {
                echo "Geen auto gevonden met ID: $id";
            }
        } catch (Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }

    public function index() {
        try {
            $autos = $this->autoModel->getAllAutos();
            include 'views/autoListView.php';
        } catch (Exception $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Lijst</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Auto Lijst</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Bouwjaar</th>
        <th>Kleur</th>
        <th>Model</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($autos as $auto): ?>
        <tr>
            <td><?php echo htmlspecialchars($auto['id']); ?></td>
            <td><?php echo htmlspecialchars($auto['type']); ?></td>
            <td><?php echo htmlspecialchars($auto['bouwjaar']); ?></td>
            <td><?php echo htmlspecialchars($auto['kleur']); ?></td>
            <td><?php echo htmlspecialchars($auto['model']); ?></td>
            <td><a href="index.php?action=show&id=<?php echo htmlspecialchars($auto['id']); ?>">Bekijken</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>


<!-- views/autoView.php -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Auto Details</h1>
<p><strong>ID:</strong> <?php echo htmlspecialchars($auto['id']); ?></p>
<p><strong>Type:</strong> <?php echo htmlspecialchars($auto['type']); ?></p>
<p><strong>Bouwjaar:</strong> <?php echo htmlspecialchars($auto['bouwjaar']); ?></p>
<p><strong>kleur:</strong> <?php echo htmlspecialchars($auto['kleur']); ?></p>
<p><strong>Model:</strong> <?php echo htmlspecialchars($auto['model']); ?></p>
<a href="autopagina.php">Terug naar lijst</a>
</body>
</html>

