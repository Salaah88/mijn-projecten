<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gemeente Klachten Website</title>
    <link rel="stylesheet" href="project10.css">
    <style>
        /* Algemene opmaakstijlen voor de pagina */

        /* Stijlen voor de navigatiebalk */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #c8e8e9;
            color: red;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Stijlen voor de navigatiebalk */
        .navbar {
            background-color: lightgrey;
            color: #fff;
            width: 100%;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            top: 0; /* Plaats de navbar bovenaan */
        }

        .navbar .container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .brand {
            font-size: 24px;
            margin-right: 20px;
        }

        .navbar .logo {
            width: 120px;
            height: auto;
        }

        .navbar .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar .nav-links li {
            margin-right: 20px;
        }

        .navbar .nav-links a {
            color: red;
            text-decoration: none;
        }

        h1, p {
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin-top: 60px; /* Voeg ruimte toe boven de inhoud om de navbar te compenseren */
            background: #fff;
            border-radius: 6px;
            padding: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .container .content{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .container .content .left-side{
            width: 25%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
            position: relative;
        }
        .content .left-side::before{
            content: '';
            position: absolute;
            height: 70%;
            width: 2px;
            right: -15px;
            top: 50%;
            transform: translateY(-50%);
            background: #afafb6;
        }
        .content .left-side .details{
            margin: 14px;
            text-align: center;
        }
        .content .left-side .details i{
            font-size: 30px;
            color: #3e2093;
            margin-bottom: 10px;
        }
        .content .left-side .details .topic{
            font-size: 18px;
            font-weight: 500;
        }
        .content .left-side .details .text-one,
        .content .left-side .details .text-two{
            font-size: 14px;
            color: #afafb6;
        }
        .container .content .right-side{
            width: 75%;
            margin-left: 75px;
        }
        .content .right-side .topic-text{
            font-size: 23px;
            font-weight: 600;
            color: #3e2093;
        }
        .right-side .input-box{
            height: 50px;
            width: 100%;
            margin: 12px 0;
        }
        .right-side .input-box input,
        .right-side .input-box textarea{
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            font-size: 16px;
            background: #F0F1F8;
            border-radius: 6px;
            padding: 0 15px;
            resize: none;
        }
        .right-side .message-box{
            min-height: 110px;
        }
        .right-side .input-box textarea{
            padding-top: 6px;
        }
        .right-side .button{
            display: inline-block;
            margin-top: 12px;
        }
        .right-side .button input[type="button"]{
            color: #fff;
            font-size: 18px;
            outline: none;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            background: #3e2093;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .button input[type="button"]:hover{
            background: #5029bc;
        }

        @media (max-width: 950px) {
            .container{
                width: 90%;
                padding: 30px 40px 40px 35px ;
            }
            .container .content .right-side{
                width: 75%;
                margin-left: 55px;
            }
        }
        @media (max-width: 820px) {
            .container{
                margin: 40px 0;
                height: 100%;
            }
            .container .content{
                flex-direction: column-reverse;
            }
            .container .content .left-side{
                width: 100%;
                flex-direction: row;
                margin-top: 40px;
                justify-content: center;
                flex-wrap: wrap;
            }
            .container .content .left-side::before{
                display: none;
            }
            .container .content .right-side{
                width: 100%;
                margin-left: 0;
            }
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

        /* Aanvullende stijlen voor de rest van de inhoud */
        /* ... */

    </style>
</head>
<body>
<nav class="navbar">
    <div class="container">
        <div class="brand">
            <a href="project10.php"></a>
        </div>
        <a href="project10.php">
            <img src="website.png" alt="Gemeente Logo" class="logo">
        </a>
        <ul class="nav-links">
            <li><a href="project10.php">Home</a></li>
            <li><a href="klachten.php">Klachten</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Account</a>
                <div class="dropdown-content">
                    <a href="inloggengebruiker.php">Gast</a>
                    <a href="inloggenbeheerder.php">Beheerder</a>
                </div>
            </li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="content">
        <div class="container">
            <div class="content">
                <div class="left-side">
                    <div class="address details">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="topic">Adres</div>
                        <div class="text-one">Gemeente Nederland</div>
                    </div>
                    <div class="phone details">
                        <i class="fas fa-phone-alt"></i>
                        <div class="topic">Tel:</div>
                        <div class="text-one">+31 123 456 789</div>
                    </div>
                    <div class="email details">
                        <i class="fas fa-envelope"></i>
                        <div class="topic">Email</div>
                        <div class="text-one">Info@gemeente.nl</div>
                    </div>
                </div>
                <div class="right-side">
                    <div class="topic-text">Contacteer ons !</div>
                    <p><h1>Contacteer ons voor meer informatie</h1>
                    <p>Heeft u vragen, suggesties of wilt u meer informatie over onze diensten? Neem gerust contact met ons op</p>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

