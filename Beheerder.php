<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Gemeente Klachtenbeheer</title>
    <link rel="stylesheet" href="beheerder.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="sidebar">
    <div class="logo-details">
        <i class='bx bx-message-square-error'></i>
        <span class="logo_name">Klachten</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="Beheerder.php" class="active">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="klachtenid.php">
                <i class='bx bx-search'></i>
                <span class="links_name">Zoeken</span>
            </a>
        </li>
        <li>
            <a href="kaart.php">
                <i class='bx bx-map'></i>
                <span class="links_name">Kaartweergave</span>
            </a>
        </li>
        <li>
            <a href="gebruiker.php">
                <i class='bx bx-user'></i>
                <span class="links_name">Gebruikers</span>
            </a>
        </li>
        <li>


            <a href="inloggenbeheerder.php">
                <i class='bx bx-user'></i>
                <span class="links_name">Uitloggen</span>
            </a>
        </li>

    </ul>


</div>




<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Zoeken...">
            <i class='bx bx-search' id="searchIcon"></i>
        </div>


        <div class="profile-details" onclick="window.location.href='account.php'">
            <img src="Nederland.png" alt="">
            <span class="admin_name">Admin</span>
        </div>



    </nav>

    <div class="home-content">
        <div class="overview-boxes">
            <div class="complaints-section">
                <div class="complaints-box">
                    <h2>Klachten</h2>
                    <p>Aantal klachten: <span id="total-complaints">100</span></p>
                    <p>Klachten in behandeling: <span id="pending-complaints">30</span></p>
                    <p>Afgehandelde klachten: <span id="resolved-complaints">70</span></p>
                    <!-- Voeg meer relevante informatie toe -->
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Aantal Klachten</div>
                        <div class="number">100</div>
                        <div class="indicator">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span class="text">Toegenomen</span>
                        </div>
                    </div>
                    <i class='bx bx-message-square-detail cart'></i>
                </div>
                <div class="complaints-section">
                    <div class="complaints-box">
                        <h2>Klachten</h2>
                        <p>Aantal klachten: <span id="total-complaints">100</span></p>
                        <p>Klachten in behandeling: <span id="pending-complaints">30</span></p>
                        <p>Afgehandelde klachten: <span id="resolved-complaints">70</span></p>
                    </div>

                    <div class="complaints-box">
                        <h2>Soorten klachten</h2>
                        <p>Technische problemen: <span id="technical-issues">25</span></p>
                        <p>Infrastructuurklachten: <span id="infrastructure-complaints">40</span></p>
                        <p>Administratieve klachten: <span id="admin-complaints">15</span></p>
                    </div>
                </div>

                <div class="sales-boxes">
                    <div class="specific-complaints-section">
                        <div class="recent-complaints">
                            <h2>Recente Klachten</h2>
                            <!-- Voeg hier de lijst met recente klachten toe -->
                            <ul>
                                <li>Klacht 1 : kappote licht in de poort</li>
                                <li>Klacht 2 : putten in de straten lopen te snel vol</li>
                                <li>Klacht 3 : te weinig vuilbakken</li>
                                <li>Klacht 4 : lampen op straat doen het niet</li>
                                <li>Klacht 5 : te weinig parkeervakken</li>
                                <!-- Voeg meer recente klachten toe -->
                            </ul>
                        </div>

                        <div class="top-complaints">
                            <h2>Topklachten</h2>
                            <!-- Voeg hier de topklachten toe -->
                            <ol>
                                <li>te weinig parkeervakken</li>
                                <li>te weinig vuilbakken</li>
                                <li>lampen op straat doen het niet</li>
                                <!-- Voeg meer topklachten toe -->
                            </ol>
                        </div>

                        <div class="complaints-statistics">
                            <h2></h2>
                            <div class="complaints-statistics">
                                <h2>Klachten Statistieken</h2>
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>

                            <p>Grafieken of diagrammen kunnen hier worden weergegeven om klachtentrends te tonen.</p>
                        </div>
                        <!-- Voeg eerst de Chart.js-bibliotheek toe -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <script>
                            // JavaScript om de grafiek te maken
                            document.addEventListener("DOMContentLoaded", function() {
                                // Selecteer de canvas
                                const ctx = document.getElementById('myChart').getContext('2d');

                                // Maak een voorbeeldgegevens voor de grafiek
                                const data = {
                                    labels: ['Klacht A', 'Klacht B', 'Klacht C', 'Klacht D'],
                                    datasets: [{
                                        label: 'Aantal Klachten',
                                        data: [12, 19, 3, 5], // Voorbeeldgegevens van het aantal klachten
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                };

                                // Configureer de opties voor de grafiek (bijvoorbeeld: titel, legendes, etc.)
                                const options = {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                };

                                // Creëer de grafiek met Chart.js
                                const myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: data,
                                    options: options
                                });
                            });
                        </script>

                        <ul><!-- Voorbeeld van een extra sectie voor recente klachten -->
                            <h2>Klachten beschrijving</h2>
                            <li>Klacht 1 - De lichten in de poort doen het niet waardoor het in de avond heel donker is.</li>
                            <li>Klacht 2 - De putten in de straten lopen te snelvol tijdens hevige regen val de hele straat staat daar door blank.</li>
                            <li>Klacht 3 - De vuilbakken raken te snel vol waardoor er vervelende stank komt.</li>
                            <li>Klacht 4 - De lampen op straat doen het niet er geen licht s'avonds op straat.</li>
                            <li>Klacht 5 - Door de kleine hoeveelheid parkeervakken is de straat snel vol en moeten veel bewoners een te ver van hun huis gaan parkeren.</li>

                            <!-- Voeg meer klachten toe -->
                        </ul>
</section>


<script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }

    // Zoekfunctionaliteit met JavaScript voor zowel klachten als sidebar-links
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const complaintsList = document.querySelectorAll(".recent-complaints ul li");
        const sidebarLinks = document.querySelectorAll(".nav-links li a");

        // Voeg een gebeurtenisluisteraar toe aan het invoerveld om te reageren op het 'keyup'-evenement
        searchInput.addEventListener("keyup", function() {
            const searchTerm = searchInput.value.toLowerCase(); // verkrijg de ingevoerde zoekterm

            // Loop door de lijst met klachten en verberg degenen die niet overeenkomen met de zoekterm
            complaintsList.forEach(function(complaint) {
                const text = complaint.textContent.toLowerCase(); // verkrijg de tekst van elke klacht

                // Controleer of de zoekterm overeenkomt met de tekst van de klacht
                if (text.includes(searchTerm)) {
                    complaint.style.display = "block"; // toon de klacht als er overeenkomsten zijn
                } else {
                    complaint.style.display = "none"; // verberg de klacht als er geen overeenkomsten zijn
                }
            });

            // Loop door de zijbalk-links en verberg degenen die niet overeenkomen met de zoekterm
            sidebarLinks.forEach(function(link) {
                const linkText = link.textContent.toLowerCase(); // verkrijg de tekst van elke link

                // Controleer of de zoekterm overeenkomt met de tekst van de link
                if (linkText.includes(searchTerm)) {
                    link.style.display = "block"; // toon de link als er overeenkomsten zijn
                } else {
                    link.style.display = "none"; // verberg de link als er geen overeenkomsten zijn
                }
            });
        });
    });

</script>


</body>

</html>
<?php
// Beheerder.php - Verwerkingspagina voor het formulier

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleer of de vereiste velden zijn ingevuld
    if (isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])) {
        // Verkrijg de ingediende gegevens van het formulier
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];

        // Probeer verbinding te maken met de database (voorbeeld: MySQL)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        // Maak verbinding met de database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Controleer de verbinding met de database
        if ($conn->connect_error) {
            die("Connectie mislukt: " . $conn->connect_error);
        }

        // Voorbeeld van een SQL-query om gegevens in de database in te voegen
        $sql = "INSERT INTO inloggen (gebruikersnaam, wachtwoord) VALUES ('$gebruikersnaam', '$wachtwoord')";

        if ($conn->query($sql) === TRUE) {
            echo "Gegevens succesvol toegevoegd aan de database!";
        } else {
            echo "Fout bij toevoegen van gegevens: " . $conn->error;
        }

        // Sluit de databaseverbinding
        $conn->close();
    } else {
        echo "Niet alle vereiste velden zijn ingevuld!";
    }
}

if(isset($_POST['uitloggen'])) {
    session_unset();
    session_destroy();
    header("Location: inloggenbeheerder.php");
    exit();
}

?>



