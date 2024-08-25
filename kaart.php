<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>OpenStreetMap met Klachten</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-color: #f4f4f4; /* Lichtere achtergrondkleur */
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #0A2558;
            color: #fff;
            padding-top: 20px;
        }

        .logo-details {
            display: flex;
            align-items: center;
            padding-left: 20px;
        }

        .logo-details i {
            font-size: 32px;
            margin-right: 10px;
        }

        .logo_name {
            font-size: 20px;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .nav-links li {
            padding: 10px 0;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 8px 20px;
        }

        .nav-links a:hover {
            background-color: #0E3B8C;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        #map {
            height: 400px;
            border: 1px solid #AAA;
            margin-bottom: 20px;
            background-color: #fff; /* Kaartachtergrond wit maken */
        }

        #complaintForm {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
        }

        #complaintForm label {
            display: block;
            margin-bottom: 10px;
            color: #333; /* Tekstkleur aanpassen voor labels */
        }

        #complaintForm input[type="text"],
        #complaintForm input[type="email"],
        #complaintForm textarea {
            width: calc(100% - 22px); /* Aanpassing breedte voor inputvelden */
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        #complaintForm input[type="submit"] {
            background-color: #0A2558;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        #complaintForm input[type="submit"]:hover {
            background-color: #0E3B8C;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo-details">
        <i class="fas fa-fire"></i>
        <span class="logo_name">OPENSTREETMAP</span>
    </div>
    <ul class="nav-links">
        <li><a href="Beheerder.php">Dasboard</a></li>
    </ul>
</div>

<div class="content">
    <h1>Map with Complaints</h1>

    <div id="complaintForm">
        <h2>Submit Complaint</h2>
        <form id="submitForm">
            <label for="complaint">Klacht:</label>
            <textarea id="complaint" name="complaint" placeholder="Enter your complaint" required></textarea>

            <label for="latitude">Lengtegraad:</label>
            <input type="text" id="latitude" name="latitude" placeholder="Enter latitude" required>

            <label for="longitude">Breedtegraad:</label>
            <input type="text" id="longitude" name="longitude" placeholder="Enter longitude" required>

            <input type="submit" value="zoeken">
        </form>
    </div>

    <div id="map"></div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js"></script>
    <script type="text/javascript">
        var map = L.map('map').setView([52.3676, 4.9041], 12);

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            subdomains: ['a', 'b', 'c']
        }).addTo(map);

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Verbindingsfout: " . $conn->connect_error);
        }

        $sql = "SELECT locatie, klacht FROM klachten";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $location = $row['locatie'];
                $complaint = $row['klacht'];

                $locationArray = explode(',', $location);
                $latitude = floatval($locationArray[0]);
                $longitude = floatval($locationArray[1]);

                echo "L.marker([$latitude, $longitude])
                            .bindPopup('$complaint')
                            .addTo(map);";
            }
        }

        $conn->close();
        ?>
    </script>
</div>
</body>
</html>
