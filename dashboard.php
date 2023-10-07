<?php

$user = 'root';
$password = 'root';
$db = 'db_edusogno';
$host = 'localhost';
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$UserID = $_GET['id'];

$query =" SELECT * FROM usersss WHERE id = $UserID";
$risultato = mysqli_query($conn, $query);
$datiUser = mysqli_fetch_assoc($risultato);
$nomeUser = $datiUser['firstname'];
$cognomeUser = $datiUser['lastname'];
$emailUser = $datiUser['email'];


$queryAllEvents = "SELECT * FROM events";
$resultQueryAllEvents = mysqli_fetch_all(mysqli_query($conn, $queryAllEvents));




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>I tuoi eventi</title>
</head>
<body>
    <header>
    <div class="header">
            <a href="login.php"><img src="img/logo-black.svg" alt="logo"></a>
        </div>
    </header>
    <main>
        <div class="main" id="appDiv">
            <h2>ciao <?php echo $nomeUser. " " . $cognomeUser ; ?></h2>
            <h1>La tua Dashboard personale</h1>
 
            <div class="center-admin" id="center-admin2">
                <h3>Eventi:</h3>
                <div class="box">
                    <div class="center-events">
                        <?php foreach ($resultQueryAllEvents as $key => $value): ?> 
                            <div class="card">
                                <div class="title">
                                    <p><?= $value[1]; ?></p>
                                </div>
                                <div class="description">
                                    <p><?= $value[2]; ?></p>
                                </div>
                                <div class="when">
                                    <div class="date">
                                        <p><?= $value[3]; ?></p>
                                    </div>
                                    <div class="hour">
                                        <p><?= $value[4]; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>