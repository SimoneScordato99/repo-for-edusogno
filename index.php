<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


class User {
    public $ids;
    public $firstnames;
    public $lastnames;
    public $emails;
    public $passwords;

    public function __construct($_ids, $_firstnames, $_lastnames, $_emails, $_passwords) {
        $this->ids = $_ids;
        $this->firstnames = $_firstnames;
        $this->lastnames = $_lastnames;
        $this->emails = $_emails;
        $this->passwords = $_passwords;
    }
}


if (isset($_POST['submit'])) {

    $user = 'root';
    $password = 'root';
    $db = 'db_edusogno';
    $host = 'localhost';
    $port = 3306;
    
    $conn = mysqli_connect($host, $user, $password, $db, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $queryNumRows = "SELECT COUNT(*) as num_rows FROM usersss";
    $resultQueryNumRows = mysqli_query($conn, $queryNumRows);
    $numRows = mysqli_fetch_row($resultQueryNumRows)[0];
    
    $firstnames = $_POST['firstname'];
    $lastnames = $_POST['lastname'];
    $emails = $_POST['email'];
    $passwords = $_POST['password'];
    $soldatinoEmails = false;

    $queryAll = "SELECT * FROM usersss";
    $resultQueryAll = mysqli_fetch_all(mysqli_query($conn, $queryAll));
    foreach ($resultQueryAll as $key => $value) {
        if ($emails == $value[3] ) {
            $soldatinoEmails = true;
        }
    }

    if ($numRows == 0) {
        $ids = 1;
    } else {
        $ids = $numRows + 1; 
    }

    if ($soldatinoEmails) {
        echo "<h3>usa un altra email</h3>";
        exit;
    } else {
        $newUser = new User($ids, $firstnames, $lastnames, $emails, $passwords);
    }

    $query = "INSERT INTO usersss (id, firstname, lastname, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "issss" ,$newUser->ids, $newUser->firstnames, $newUser->lastnames, $newUser->emails, $newUser->passwords);
        mysqli_stmt_execute($stmt);
        
        
        $UserID = $newUser->ids;

        header("Location: dashboard.php?id=$UserID");
    
        exit;
    } else {
        echo "Errore nella preparazione della dichiarazione: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>EduSogno | Register</title>
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
                    <label for="firstname">Inserisci il tuo nome</label>
                    <input type="text" name="firstname" id="firstname">

                    <label for="lastname">Inserisci il tuo cognome</label>
                    <input type="text" name="lastname" id="lastname" >

                    <label for="email">Inserisci la tua email</label>
                    <input type="email" name="email" id="email" >

                    <label for="password">Inserisci la tua password</label>
                    <input type="password" name="password" id="password">

                    <button class="btn" type="submit" name="submit">Registrati</button>
                </form>

                <div class="linkbasso">
                    <p class="linkbasso">Hai già un account? <a href="login.php">Accedi</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>