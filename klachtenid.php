<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klacht Zoeken</title>
    <style>
        /* Voeg hier je CSS-stijlen toe */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .dashboard {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color:  #0A2558;;
            color: #fff;
            padding-top: 20px;
        }

        .logo-details {
            display: flex;
            height: 60px;
            align-items: center;
            padding-left: 20px;
            font-weight: bold;
            font-size: 20px;
        }

        .logo-details i {
            font-size: 24px;
            margin-right: 5px;
        }

        .nav-links {
            padding-left: 0;
        }

        .nav-links li {
            list-style: none;
            margin-bottom: 10px;
        }

        .nav-links a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
        }

        .nav-links a:hover {
            background-color:darkblue;
        }

        .nav-links .active {
            background-color: darkblue;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        #searchForm {
            margin-bottom: 20px;
        }

        #resultaat {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-details">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </div>
        <ul class="nav-links">
            <li><a href="Beheerder.php" class="active">Dashboard</a></li>
            <!-- Voeg andere zijbalk-links toe zoals nodig -->
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h1>Zoek Klacht op basis van ID</h1>
        <form id="searchForm" action="" method="GET">
            <label for="klacht_id">Voer Klacht ID in:</label>
            <input type="text" id="klacht_id" name="klacht_id" required>
            <input type="submit" value="Zoeken">
        </form>

        <div id="resultaat">
            <?php
            // Controleer of er een klacht-ID is ingediend en of er een databaseverbinding is
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['klacht_id'])) {
                // Maak verbinding met de database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "project";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Verbindingsfout: " . $conn->connect_error);
                }

                $klacht_id = $_GET['klacht_id'];

                // Query om de klacht op te halen op basis van het opgegeven ID
                $sql = "SELECT * FROM klachten WHERE id = ?";
                $stmt = $conn->prepare($sql);


                if ($stmt) {
                    $stmt->bind_param("i", $klacht_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Toon de klachtgegevens als de klacht is gevonden
                        $row = $result->fetch_assoc();
                        echo "<h3>Klachtgegevens:</h3>";
                        echo "Naam: " . $row['naam'] . "<br>";
                        echo "E-mail: " . $row['email'] . "<br>";
                        echo "Klacht: " . $row['klacht'] . "<br>";
                        echo "Locatie: " . $row['locatie'] . "<br>";


                        // Je kunt hier andere informatie weergeven indien nodig
                    } else {
                        echo "Geen klacht gevonden met dat ID.";
                    }

                    $stmt->close();
                } else {
                    echo "Fout bij het voorbereiden van de query.";
                }

                // Sluit de databaseverbinding
                $conn->close();
            }
            ?>
            <?php
            // Controleer of er een klacht-ID is ingediend en of er een databaseverbinding is
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['klacht_id'])) {
                // Maak verbinding met de database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "project";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Verbindingsfout: " . $conn->connect_error);
                }

                $klacht_id = $_GET['klacht_id'];

                // Query om de klacht op te halen op basis van het opgegeven ID
                $sql = "SELECT * FROM gebruikerklacht WHERE id = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("i", $klacht_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Toon de klachtgegevens als de klacht is gevonden
                        $row = $result->fetch_assoc();
                        echo "<h3>Klachtgegevens:</h3>";
                        echo "Naam: " . $row['naam'] . "<br>";
                        echo "Klacht: " . $row['klacht'] . "<br>";
                        echo "Locatie: " . $row['locatie'] . "<br>";
                        echo "email:"    . $row['email']. "<br>";
                        // Je kunt hier andere informatie weergeven indien nodig
                    } else {
                        echo " Geen klacht gevonden met dat ID.";
                    }

                    $stmt->close();
                } else {
                    echo "Fout bij het voorbereiden van de query.";
                }

                // Sluit de databaseverbinding
                $conn->close();
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>
