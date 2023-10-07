<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$user = 'root';
$password = 'root';
$db = 'db_edusogno';
$host = 'localhost';
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$queryAll = "SELECT * FROM usersss";
$resultQueryAll = mysqli_fetch_all(mysqli_query($conn, $queryAll));

$querySuperAdmin = "SELECT * FROM super_admin";
$resultQuerySuperAdmin = mysqli_fetch_all(mysqli_query($conn, $querySuperAdmin));

if (isset($_POST['submit'])) {

    $emails = $_POST['email'];
    $passwords = $_POST['password'];
    $soldatinoEmails = false;

    if ($emails == $resultQuerySuperAdmin[0][0] && $passwords == $resultQuerySuperAdmin[0][1]) {
        header("Location: superAdmin.php");
    }
    else {
        foreach ($resultQueryAll as $key => $value) {
                if ($emails == $value[3] ) {
                    $soldatinoEmails = true;
                    if ($soldatinoEmails) {
                        if ($passwords == $value[4]) {
                            $UserID = $value[0];
                            echo "<h3>password esatta</h3>";
                            header("Location: dashboard.php?id=$UserID");
                        }
                        else {
                            echo "password sbagliata";
                        }
                    }
                }
                else {
                    echo "email non registrata";
                }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>EduSogno | Login</title>
</head>
<body>
    <header>
    <div class="header">
            <a href="login.php"><img src="img/logo-black.svg" alt="logo"></a>
        </div>
    </header>
    <main>
        <div class="main" id="appDiv">
            <div class="center">
                <h1>Crea il tuo account</h1>
               
                
                <form method="post" action="" class="form" autocomplete="off">

                    <label for="email">Inserisci la tua email</label>
                    <input type="email" name="email" id="email" >

                    <label for="password">insirisci la tua password</label>
                    <input type="password" name="password" id="password">

                    
                    <button class="btn" type="submit" name="submit">Accedi</button>
                </form>
                

                

                <div class="linkbasso">
                    <p >Non hai un account? <a href="index.php">Registrati</a></p>

                </div>
            </div>
        </div>
    </main>


</body>
</html>