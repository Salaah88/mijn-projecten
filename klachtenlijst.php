<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Klachtenlijst</title>
    <link rel="stylesheet" href="beheerder.css">
    <style>

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        /* Aanpassingen voor klachtenlijst */
        .content {
            padding: 20px;
            margin-left: 240px; /* Breedte van de zijbalk */
        }
        form {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid blue;
            resize: vertical;
        }
        ul {
            list-style-type: none;
            padding: 0;
            color:white;
        }
        li {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 4px;
            background-color: #081D45;
            border: 1px solid white;

        }
    </style>
</head>
<body>
<div class="sidebar">
    <li>
        <a href="Beheerder.php" class="active">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Dashboard</span>
        </a>
    </li>
</div>


    <div class="content">
        <h1>Klachtenlijst</h1>

        <form id="klachtenForm">
            <label for="klacht">Voer uw klacht in:</label><br>
            <textarea id="klacht" name="klacht" rows="4" cols="50"></textarea><br><br>

            <input type="submit" value="Verstuur klacht">
        </form>

        <!-- Hier komt de lijst van ingediende klachten -->
        <h2>Ingediende klachten</h2>
        <ul id="klachtenLijst">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Aantal Klachten</div>
                    <div class="text"></div>

                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">Toegenomen</span>
                    </div>
                </div>
        </ul>
    </div>
</div>

<!-- JavaScript voor het toevoegen van klachten aan de lijst -->
<script>
    document.getElementById("klachtenForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Voorkom standaardgedrag van het formulier

        // Haal de ingevoerde klacht op uit het tekstvak
        var nieuweKlacht = document.getElementById("klacht").value;

        // Voeg de nieuwe klacht toe aan de lijst
        var klachtenLijst = document.getElementById("klachtenLijst");
        var nieuweKlachtItem = document.createElement("li");
        nieuweKlachtItem.textContent = nieuweKlacht;
        klachtenLijst.appendChild(nieuweKlachtItem);

        // Reset het tekstvak na het toevoegen van de klacht
        document.getElementById("klacht").value = "";
    });
</script>
</body>
</html>

