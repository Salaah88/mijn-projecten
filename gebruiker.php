<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemeente Klachten</title>
    <link rel="stylesheet" href="gebruiker.css">
</head>

<body>

<header>
    <div class="logosec">
        <div class="logo">Gemeente Klachten</div>
        <img src="menu.png" class="icn menuicn" id="menuicn" alt="menu-icoon">
    </div>
    <div class="searchbar">
        <input type="text" placeholder="Zoek klachten">
        <div class="searchbtn">
            <img src="zoek.png" class="icn srchicn" alt="zoek-icoon">
        </div>
    </div>
    <div class="message">
        <div class="circle"></div>
        <img src="" class="icn" alt="">
        <div class="dp">
            <img src="profiel.jpg" class="dpicn" alt="profielfoto">
        </div>
    </div>
</header>

<div class="main-container">
    <div class="navcontainer">
        <nav class="nav">
            <div class="nav-upper-options">
                <div class="nav-option option1">
                    <h3>Klachten</h3>
                </div>
                <div class="nav-option option1">
                    <ul class="nav-links">
                        <h3><a href="gebruikerklacht.php">Klachten melden</a></h3>
                    </ul>
                </div>
                <div class="nav-option option5">
                    <h3><a href="instellingen.php">Instellingen</a></h3>
                </div>
                <div class="nav-option option5">
                    <h3><a href="inloggengebruiker.php">Uitloggen</a></h3>
                </div>
            </div>
        </nav>
    </div>

    <div class="main">
        <div class="dashboard-intro">
            <h1>Welkom bij het Gebruikersdashboard van de Gemeente Klachtenwebsite</h1>
            <p>
                Dit dashboard biedt u als gewaardeerde gebruiker een centrale plek om uw interacties met onze Gemeente Klachtenwebsite te beheren en te volgen.
                Hieronder vindt u de functionaliteiten die beschikbaar zijn in uw dashboard:
            </p>
        </div>

        <div class="functionaliteiten">
            <h2>Overzicht van Functionaliteiten:</h2>
        </div>
        <div class="functionality-item">
            <h3>Klachtenoverzicht:</h3>
            <p>
                In deze sectie vindt u een overzicht van alle door u ingediende klachten.
                Het toont details zoals de datum van indiening, het onderwerp van de klacht en de huidige status van elke klacht.
            </p>
        </div>

        <div class="functionality-item">
            <h3>Nieuwe Klacht Indienen:</h3>
            <p>
                Gebruik deze functie om een nieuwe klacht te melden aan de gemeente.
                Vul de benodigde details in over het probleem dat u wilt rapporteren voor verdere opvolging.
            </p>
        </div>

        <div class="functionality-item">
            <h3>Zoekfunctionaliteit:</h3>
            <p>
                Maak gebruik van de zoekbalk om snel specifieke klachten te vinden op basis van trefwoorden of specifieke details.
            </p>
        </div>

        <div class="functionality-item">
            <h3>Profielbeheer:</h3>
            <p>
                Pas uw profielfoto aan of wijzig andere persoonlijke instellingen om uw ervaring te personaliseren.
            </p>
        </div>

        <h2>Belangrijke Aandachtspunten:</h2>

        <div class="functionality-item">
            <h3>Klachtstatus Opvolgen:</h3>
            <p>
                Elke klacht wordt gekenmerkt met een status, zoals 'In behandeling', 'Afgehandeld', of 'Wacht op feedback'.
                Hierdoor kunt u de voortgang van uw klacht volgen terwijl deze door de gemeente wordt afgehandeld.
            </p>
        </div>

        <div class="functionality-item">
            <h3>Contact en Ondersteuning:</h3>
            <p>
                Voor verdere vragen, ondersteuning of feedback staat ons team klaar om u te helpen. U vindt de contactgegevens in de sectie 'Instellingen'.
            </p>
        </div>
    </div>


    <div class="searchbar2">
        <input type="text" name="" id="" placeholder="Zoek klachten">
        <div class="searchbtn">
            <img src="link-naar-zoek-icoon" class="icn srchicn" alt="zoek-knop">
        </div>
    </div>

    <div class="klachten-container">

    </div>
</div>
</div>

</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindingsfout: " . $conn->connect_error);
}

$sql = "SELECT * FROM gebruikerklacht";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="klacht-item">';
        echo '<h3 class="t-op-nextlvl">' . (isset($row["klachtID"]) ? $row["klachtID"] : '') . '</h3>';
        echo '<h3 class="t-op-nextlvl">' . (isset($row["datum"]) ? $row["datum"] : '') . '</h3>';
        echo '<h3 class="t-op-nextlvl">' . (isset($row["onderwerp"]) ? $row["onderwerp"] : '') . '</h3>';
        echo '<h3 class="t-op-nextlvl label-tag">' . (isset($row["status"]) ? $row["status"] : '') . '</h3>';
        echo '</div>';
    }
} else {
    echo "Geen klachten gevonden";
}

$conn->close();



if(isset($_POST['uitloggen'])) {
    session_unset();
    session_destroy();
    header("Location: inloggen.php");
    exit();
}
?>



