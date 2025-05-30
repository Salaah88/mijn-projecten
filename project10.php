<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gemeente Klachten Website</title>
    <link rel="stylesheet" href="project10.css">
    <style>

        body{
            font-family: "Arial ", sans-serif;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-image: url('Nederland.png');
            background-size: 500px; /* Pas dit aan op basis van je behoeften */
            background-position: bottom; /* Pas dit aan om de positie van de achtergrondafbeelding aan te passen */
            background-repeat: no-repeat;

        }
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .brand {
            font-size: 24px;
            margin-right: 20px;
        }
        .logo {
            width: 120px; /* Aanpassen naar de gewenste breedte */
            height: auto;
            margin-left: auto;
            display:block;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .nav-links li {
            margin-right: 20px;
        }
        .nav-links a {
            color: #fff;
            text-decoration: none;
        }
        h1, p {
            margin-bottom: 20px;
            color: #1a1a1a;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="container">
        <div class="brand">
            <a href="project10.php"></a>
        </div>
        <a href="project10.php">
            <img src="website.png" alt="Gemeente Logo"  class="logo">
        </a>
        <ul class="nav-links">
            <li><a href="klachten.php">Klachten</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Account</a>
                <div class="dropdown-content">
                    <a href="inloggengebruiker.php">Gast</a>
                    <a href="inloggenbeheerder.php">Beheerder</a>
                </div>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div style="display: flex;">
        <div style="flex: 1; margin-right: 20px;">
            <h1>Welkom bij de Gemeentelijke Klachtenwebsite!</h1>
            <p>Al 23 jaar lang zijn wij een toegewijde bron voor de inwoners om hun klachten en problemen met de gemeente te adresseren.</p>

            <p>Wij zijn er om te luisteren naar de stem van onze gemeenschap. Of het nu gaat om infrastructuurproblemen, openbare diensten, milieukwesties of administratieve hindernissen, wij staan paraat om te helpen bij het oplossen van deze uitdagingen.</p>
        </div>
        <div style="flex: 1;">
            <p>Onze missie is het bieden van een transparante en toegankelijke omgeving waar inwoners van onze gemeente hun klachten kunnen indienen. Wij zetten ons in om deze problemen op te lossen door samen te werken met zowel de inwoners als de gemeente.</p>

            <p>Door onze toewijding en expertise willen we de belangen van onze gemeenschap behartigen. Uw klachten zijn belangrijk voor ons, en we nemen ze serieus. Samen kunnen we werken aan het verbeteren van onze gemeente.</p>

            <p>Heeft u een klacht of wilt u meer informatie? Aarzel niet om contact met ons op te nemen. Wij staan klaar om u te helpen en samen te streven naar een betere leefomgeving.</p>

            <p>Met vriendelijke groet,</p>
            <p>Het Team van de Gemeentelijke Klachtenwebsite</p>
        </div>
    </div>
</div>
</body>
</html>
